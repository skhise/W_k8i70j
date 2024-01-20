<?php 
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Mail;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\MailSetting;
use \App\Mail\MailSender;
use App\Models\MailLog;
Use Exception;
use PHPMailer\PHPMailer\PHPMailer;


class MailController extends Controller {

   public function GetMailSettings(Request $request){

      $mailSettings = MailSetting::where('id',1)->first();
      
      return response()->json(["success" => true, "mailsetings"=>$mailSettings]);
   }
   public function configure_smtp($mailSettings){
      require base_path("vendor/autoload.php");
      $mail = new PHPMailer(true);
      try {

         // Email server settings
         $mail->SMTPDebug = 0;
         $mail->isSMTP();
         $mail->Host = $mailSettings->smtp_server;             //  smtp host
         $mail->SMTPAuth = true;
         $mail->Username = $mailSettings->smtp_login_name;   //  sender username
         $mail->Password = $mailSettings->smtp_password;       // sender password
         $mail->SMTPSecure = $mailSettings->smtp_ssl == 'yes' ? 'ssl':'tls';                  // encryption - ssl/tls
         $mail->Port = $mailSettings->smtp_port;                          // port - 587/465
         $mail->isHTML(true);  
         $mail->setFrom($mailSettings->smtp_login_name, 'AMC Mail System');
         
         return $mail;
   
     } catch (Exception $e) {
          return null;
     }
   }
   public function SendMail($to,$subject,$body){

      try
      {
         $mailSettings = MailSetting::where('id',1)->first();
       $log = $to."\n".$subject."".$body;

        $mail = $this->configure_smtp($mailSettings);
        if($mail!=null){
            $mail->Subject =$subject;
            $mail->Body    = $body;
            $mail->addAddress($to);
            if(!$mail->send()){
               MailLog::create([
                  'sent_to'=>$to,
                  'subject'=>$subject,
                  'message'=>$body,
                  'reason'=>"something went wrong",
                  'status'=>'failed',
               ]);
           }
            MailLog::create([
               'sent_to'=>$to,
               'subject'=>$subject,
               'message'=>$body,
               'reason'=>"NA",
               'status'=>'success',
            ]);  
        } else {
         MailLog::create([
            'sent_to'=>$to,
            'subject'=>$subject,
            'message'=>$body,
            'reason'=>"mail settings missing",
            'status'=>'failed',
         ]);
        }
       
      }
      catch(Exception $e)
      {
          //
          MailLog::create([
            'sent_to'=>$to,
            'subject'=>$subject,
            'message'=>$body,
            'reason'=>$e->getMessage(),
            'status'=>'failed',
         ]);
      }
   }
   public function SendTestMail(Request $request){
       
      $validator  =   Validator::make($request->all(),
      [
         'test_email'=>'required|email'
      ]);


      if($validator->fails()) {
         return response()->json(["success" => false, "message"=>"all fields required."]);
      }
      $mailSettings = MailSetting::where('id',1)->first();
      if(!is_null($mailSettings)){
         try
         {
             $details = [
               'title' => 'Test Mail',
               'body' => 'This is test mail'
           ];
           $mail = $this->configure_smtp($mailSettings);
           if($mail!=null){
               $mail->Subject ="Test Mail";
               $mail->Body    = "This is test mail";
               $mail->addAddress($request->test_email);
           }
           if(!$mail->send()){
            return response()->json(["success" => false, "message"=>"failed to send mail, try again."]);
           }
           return response()->json(["success" => true, "message"=>"Test mail sent successfully."]);
         }
         catch(Exception $e)
         {
             //
             return response()->json(["success" => false, "message"=>$e->getMessage()]);
         }
      } else {
         return response()->json(["success" => false, "message"=>"Mail settings missed."]);
      }

         
   }
   public function basic_email() {
      $data = array('name'=>"Shekhar Khise");
   
      Mail::send(['text'=>'mail'], $data, function($message) {
         $message->to('shekhar.khise@gmail.com', 'Test Mail')->subject
            ('Laravel Basic Testing Mail');
         $message->from('shekhar.khise2010@gmail.com','Shekhar Khise');
      });
      echo "Basic Email Sent. Check your inbox.";
   }
   public function html_email() {
      $data = array('name'=>"Virat Gandhi");
      Mail::send('mail', $data, function($message) {
         $message->to('abc@gmail.com', 'Tutorials Point')->subject
            ('Laravel HTML Testing Mail');
         $message->from('xyz@gmail.com','Virat Gandhi');
      });
      echo "HTML Email Sent. Check your inbox.";
   }
   public function attachment_email() {
      $data = array('name'=>"Virat Gandhi");
      Mail::send('mail', $data, function($message) {
         $message->to('abc@gmail.com', 'Tutorials Point')->subject
            ('Laravel Testing Mail with Attachment');
         $message->attach('C:\laravel-master\laravel\public\uploads\image.png');
         $message->attach('C:\laravel-master\laravel\public\uploads\test.txt');
         $message->from('xyz@gmail.com','Virat Gandhi');
      });
      echo "Email Sent with attachment. Check your inbox.";
   }

   public function StoreMailSetting(Request $request){
     
      $validator  =   Validator::make($request->all(),
         [
               "smtp_server"=> "required",
                "smtp_port"=> "required",
                "smtp_login_name"=> "required",
                'smtp_password'=> "required",
                "smtp_ssl"=> "required",
                "test_email"=> "required",
                "call_register_template"=> "required",
                "call_register_mail_allowed"=> "required",
                "call_forward_template"=> "required",
                "call_forward_mail_allowed"=> "required",
                "customer_add_template"=> "required",
                "customer_add_mail_allowed"=> "required",
                "employee_add_template"=> "required",
                "employee_add_mail_allowed"=> "required"
         ]
      );
      if($validator->fails()) {
            return response()->json(["success" => false, "message"=>"all fields required.","validation_error" => $request->all()]);
      }
      $mailSettings = MailSetting::where('id',1)->first();
      if(!is_null($mailSettings)) {
         try {
            $mailSettings->smtp_server = $request->smtp_server;
            $mailSettings->smtp_port = $request->smtp_port;
            $mailSettings->smtp_login_name = $request->smtp_login_name;
            $mailSettings->smtp_password=$request->smtp_password;
            $mailSettings->smtp_ssl=$request->smtp_ssl;
            $mailSettings->smtp_mail_from=$request->smtp_login_name;
            $mailSettings->test_email=$request->test_email;
            $mailSettings->call_register_template=$request->call_register_template;
            $mailSettings->call_register_mail_allowed=$request->call_register_mail_allowed;
            $mailSettings->call_forward_template=$request->call_forward_template;
            $mailSettings->call_forward_mail_allowed=$request->call_forward_mail_allowed;
            $mailSettings->customer_add_template=$request->customer_add_template;
            $mailSettings->customer_add_mail_allowed=$request->customer_add_mail_allowed;
            $mailSettings->employee_add_template=$request->employee_add_template;
            $mailSettings->employee_add_mail_allowed=$request->employee_add_mail_allowed;
           $issave = $mailSettings->save();
           if(!$issave){
               return response()->json(["success" => false, "message"=>"here action failed, try again"]);
           }
            return response()->json(["success" =>true, "message"=>"Settings Updated."]);
         }catch(Exception $x){
            return response()->json(["success" => false, "message"=>"here2 action failed, try again".$x->getMessage()]);
         }
         
      } else {
         $create = MailSetting::create([
            'smtp_server' => $request->smtp_server,
            'smtp_port' => $request->smtp_port,
            'smtp_login_name' =>$request->smtp_login_name,
            'smtp_password' =>$request->smtp_password,
            'smtp_ssl' =>$request->smtp_ssl,
            'smtp_mail_from' =>$request->smtp_login_name,
            'test_email' =>$request->test_email,
            'call_register_template' =>$request->call_register_template,
            'call_register_mail_allowed' =>$request->call_register_mail_allowed,
            'call_forward_template' =>$request->call_forward_template,
            'call_forward_mail_allowed' =>$request->call_forward_mail_allowed,
            'customer_add_template' =>$request->customer_add_template,
            'customer_add_mail_allowed' =>$request->customer_add_mail_allowed,
            'employee_add_template' =>$request->employee_add_template,
            'employee_add_mail_allowed'=>$request->employee_add_mail_allowed,
         ]);
         if(!is_null($create)){
            return response()->json(["success" =>true, "message"=>"Settings Saved."]);
         }
         return response()->json(["success" => false, "message"=>"action failed, try again"]);
      }
   }
}
?>