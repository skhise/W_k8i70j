<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Credimax;
use App\Models\ServiceFieldReport;
use App\Models\Order;
use App\Models\User;
use App\Models\Customer;
use App\Models\Payment;
//use App\Benefit\iPayBenefitPipe;
use Illuminate\Support\Facades\Mail;
//use Illuminate\Support\Facades\Redirect;

use DB;

class PaymentController extends Controller
{

    private $credimaxMerchantID =   'TEST100094060';
    private $credimaxPassword   =   '483df0a29beb7c775355c6f483d0925e';

    private $benefitAliasName   =   'test01598937';
    
    private $benefitPayAppID    =   '2333577182';
    private $benefitPayMerchant =   '007952501';
    private $benefitPaySecureKey =  '00lmiucy99qdybp3tpjbkxsl0docxeqoa9w1jouz26nn0';

    public function Payment_Status(Request $request) {

        if($request->input()){
            $id                 =   $request->input('id');
            $type               =   $request->input('type');
            if($type == 'service'){
                $orderDetails = ServiceFieldReport::where('ServiceId',$id)->first();
                if($orderDetails)
                    return response()->json(['success'=>false,"message"=>"","status"=>$orderDetails->payment_status]);
                else
                return response()->json(['success'=>false,"message"=>"Payment details missing.".$id]);
            }else{
                $orderDetails = Order::where('id',$id)->first();
                if($orderDetails)
                    return response()->json(['success'=>false,"message"=>"","status"=>$orderDetails->payment_status]);
                else
                    return response()->json(['success'=>false,"message"=>"Payment details missing.".$id]);
                
            }

        }
    }   
    public function init( Request $request )
    {
        if ($request->input()) {
            
            $id                 =   $request->input('id');
            $userid             =   $request->input('customerId');
            $medium             =   $request->input('medium') ?? '';
            $type               =   $request->input('type');
            $paymentGateway     =   $request->input('gateway');
            //$redirect           =   $request->input('redirect');
            //$redirectURL        =   $request->input('redirect_url');
            
            if($type == 'service'){
                $orderDetails = ServiceFieldReport::where('ServiceId',$id)->first();
                if($orderDetails)
                    $amount       =   $orderDetails->TotalAmount;
                else
                return response()->json(['success'=>false,"message"=>"Payment details missing.".$id]);
            }else{
                $orderDetails = Order::where('id',$id)->first();
                $amount       =   $orderDetails->Order_Amount;
            }
            

            $orderid                      =   $id."_".date('YmdHis');

            $orderDetails->payment_method = $paymentGateway;
            $orderDetails->payment_id     = $orderid;
            $orderDetails->save();
            
            
            $transactionID      =   $orderid;

            $gatewayData['type']            =   $type;
            $gatewayData['amount']          =   $amount;
            $gatewayData['transactionID']   =   $transactionID;
            $gatewayData['merchantID']      =   $this->credimaxMerchantID;


            // $payment = new Payment();
            // $payment->payment_id = $transactionID;
            // $payment->type       = $type;
            // $payment->medium     = $medium;
            // $payment->method     = $paymentGateway;
            // $payment->save();
            
            if ($paymentGateway == 'credimax') {
                $url = 'https://afs.gateway.mastercard.com/api/rest/version/60/merchant/' . $this->credimaxMerchantID . '/session';
                $postData = array(
                    "apiOperation" => "CREATE_CHECKOUT_SESSION",
                    "order" => array(
                        "currency"   => 'BHD',
                        "id"         => $transactionID,
                        "reference"  => $transactionID,
                        "amount"     => $amount,
                    ),
                    "interaction" => array(
                        "operation" =>  'PURCHASE',
                        "returnUrl" => secure_url('/').'/api/credimax-response',
                        "cancelUrl" => secure_url('/').'/api/cancel-payment'
                    ),
                    "transaction"   => array(
                        "reference" => $transactionID
                    )
                );

                $username = 'merchant.' . $this->credimaxMerchantID;
                $password = $this->credimaxPassword;

                $data_string = json_encode($postData);
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_VERBOSE, 1);
                curl_setopt($ch, CURLOPT_HEADER, 1);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
                curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
                $response = curl_exec($ch);

                $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
                $header = substr($response, 0, $header_size);
                $result = substr($response, $header_size);

                curl_close($ch);

                $data['credimaxJSON'] = json_decode($result);

                if($data['credimaxJSON']->result == "SUCCESS"){
                    $credimax                   = new Credimax();
                    $credimax->successIndicator = $data['credimaxJSON']->successIndicator;
                    $credimax->sessionID        = $data['credimaxJSON']->session->id;
                    $credimax->sessionVersion   = $data['credimaxJSON']->session->version;
                    $credimax->orderID          = $transactionID;
                    $credimax->type             = $type;
                    $credimax->save();
                }
                
                $gatewayData['credimaxJSON'] = json_decode($result);
                $gatewayData['customerInfo'] = Customer::where("CST_ID",$userid)->first();

                // print_r($gatewayData); die;

            } else if ($paymentGateway == 'benefit') { 
                
                
                $customerInfo = Customer::where("CST_ID",$userid)->first();
                
                $myObj = new \App\Benefit\iPayBenefitPipe;
				
				//initialization
				$resourcePath = base_path() . "/resources/benefit/"; 
				$keystorePath = base_path() . "/resources/benefit/";
				
				$ResponseURL    = 'http://103.127.31.70:8000/api/benefit_response';
				$errorURL       = 'http://103.127.31.70:8000/api/benefit_response';
				
				$action = "1"; // 1–Purchase
				$aliasName = $this->benefitAliasName; 
				$currency = "048";
				$language = "USA"; 
				$amount = $amount;
				$trackid = $transactionID;
				
				//User Defined Fields.
				$Udf2 = $customerInfo->first_name.' '.$customerInfo->last_name;
                $Udf2 = $type;
				$Udf3 = $amount;
				$Udf4 = $transactionID;
				$Udf5 = "Udf5";
				
				$myObj->setResourcePath( $resourcePath );
				$myObj->setKeystorePath( $keystorePath );
				$myObj->setAlias( $aliasName );
				$myObj->setAction( $action );
				$myObj->setCurrency( $currency );
				$myObj->setLanguage( $language );
				$myObj->setResponseURL( $ResponseURL );
				$myObj->setErrorURL( $errorURL );
				$myObj->setAmt( $amount );
				$myObj->setTrackId( $trackid );
				
                $myObj->setUdf2( $Udf2 );
				$myObj->setUdf3( $Udf3 );
				$myObj->setUdf4( $Udf4 );

				if(trim($myObj->performPaymentInitializationHTTP())!=0){
                    print_r($myObj->getDebugMsg());
				    echo("ERROR OCCURED! SEE CONSOLE FOR MORE DETAILS");
				    return;
				}else{
				    $url = $myObj->getwebAddress();
				    //echo "<meta http-equiv='refresh' content='0;url=$url'>";
				    $gatewayData['benefit_url'] = $url;
				}
            } else if ($paymentGateway == 'benefit_pay'){
                $args = array(
                    'appId' => $this->benefitPayAppID,
                    'merchantId' => $this->benefitPayMerchant, 
                    'referenceNumber' => $transactionID,
                    'transactionAmount' => number_format($amount, 3), 
                    'transactionCurrency' => 'BHD'
                );
                $gatewayData['benefitPayArgs'] = $args;

                $merchant_data = '';
                $i = 0;
                foreach ($args as $key => $value){
                    if($i != 0 )
                        $merchant_data.= ',';
                    $merchant_data.= $key.'="'.$value.'"';
                    $i++;
                }
                $gatewayData['customerInfo'] = Customer::where("CST_ID",$userid)->first();
                $gatewayData['benfitPaySecureHash'] = base64_encode( hash_hmac("sha256", $merchant_data, $this->benefitPaySecureKey, true) );
            }
            return response()->json(['success'=>true,'getWayData'=>$gatewayData]);
        }
    }

    public function credimax_response(){
        if($_GET){

            $resultIndicator = $_GET['resultIndicator'];
            $sessionVersion = $_GET['sessionVersion'];


            $whereData = [ ['successIndicator', $resultIndicator], ['sessionVersion', $sessionVersion] ];
            $credimaxOrderDetails = Credimax::where( 'successIndicator', $resultIndicator )->first();

		    // $orderID = '20181010034226';
		    $orderID = $credimaxOrderDetails->orderID;
            $type    = $credimaxOrderDetails->type;

		    $url = 'https://ap-gateway.mastercard.com/api/rest/version/60/merchant/'.$this->credimaxMerchantID.'/order/'.$orderID;

		    $username = 'merchant.'.$this->credimaxMerchantID;
		    $password = $this->credimaxPassword;

		    $ch = curl_init($url);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		    curl_setopt($ch, CURLOPT_VERBOSE, 1);
		    curl_setopt($ch, CURLOPT_HEADER, 1);
		    curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
		    $response = curl_exec($ch);

		    $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		    $header = substr($response, 0, $header_size);
		    $result = substr($response, $header_size);

		    curl_close($ch);

		    $jsonResult = json_decode($result);
            
            $credimaxOrderDetails->status = $jsonResult->status;
            $credimaxOrderDetails->save();

			$invoiceID      = $jsonResult->id;
			$amount         = $jsonResult->totalAuthorizedAmount;
			$paymentReponse = $jsonResult->status;
			$responseCode   = '';
			$gateway        = 'credimax';

			$response = $this->complete_payment_method($invoiceID, $amount, $paymentReponse, $responseCode, $gateway, $type); //$invoiceID, $amount, $paymentReponse, $responseCode, $type

            //$payment = Payment::where('payment_id', $invoiceID)->first();

            if($response == 'success'){
                return response()->json(["success"=>true,"message"=>"payment completed successfully."]);
            }
            //return Redirect::to('https://lazerbahrain.com/payment/'.$response.'/'.$invoiceID);
            //return response()->json(["success"=>false,"message"=>"payment failed, try again."]);

	    } else {
            return response()->json(["success"=>false,"message"=>"payment failed, try again."]);
        }
    }
    public function benefit_response(Request $request){
        
        $currentContext = secure_url('/').'/';
    
        $myObj = new \App\Benefit\iPayBenefitPipe;
    	
    	$myObj->setAlias($this->benefitAliasName);
    	$myObj->setResourcePath( base_path() . "/resources/benefit/" );
    	$myObj->setKeystorePath( base_path() . "/resources/benefit/" );
    	
    	$trandata       =   "";
    	$paymentID      =   "";
    	$result         =   "";
    	$responseCode   =   "";
    	$response       =   "";
    	$transactionID  =   "";
    	$referenceID    =   "";
    	$trackID        =   "";
    	$amount         =   "";
    	$UDF1           =   "";
    	$UDF2           =   "";
    	$UDF3           =   "";
    	$UDF4           =   "";
    	$UDF5           =   "";
    	$authCode       =   "";
    	$postDate       =   "";
    	$errorCode      =   "";
    	$errorText      =   "";
    	
    	$trandata       =   isset($_POST["trandata"]) ? $_POST["trandata"] : "";
    	
    	if ($trandata != "")
    	{
    		$returnValue = $myObj->parseEncryptedRequest($trandata);
    		
    		if ($returnValue == 0)
    		{
    			$paymentID      = $myObj->getPaymentId();
    			$result         = $myObj->getResult();
    			$responseCode   = $myObj->getAuthRespCode();
    			$transactionID  = $myObj->getTransId();
    			$referenceID    = $myObj->getRef();
    			$trackID        = $myObj->getTrackId();
    			$amount         = $myObj->getAmt();
    			$UDF1           = $myObj->getUdf1();
    			$UDF2           = $myObj->getUdf2();
    			$UDF3           = $myObj->getUdf3();
    			$UDF4           = $myObj->getUdf4();
    			$UDF5           = $myObj->getUdf5();
    			$authCode       = $myObj->getAuth();
    			$postDate       = $myObj->getDate();
    			$errorCode      = $myObj->getError();
    			$errorText      = $myObj->getError_text();
    			
    			$referenceID    = $trackID;
    		    $paymentReponse = $result;
    		    $gateway        = 'benefit';
                $invoiceID      = $UDF2;
    
    		}
    		else
    		{
    			$errorText = $myObj->getError_text();
    		}
    	}
    	else if (isset($_POST["ErrorText"]))
        {
            $paymentID  = $_POST["paymentid"];
            $trackID    = $_POST["trackid"];
            $amount     = $_POST["amt"];
            $UDF1       = $_POST["udf1"];
            $UDF2       = $_POST["udf2"];
            $UDF3       = $_POST["udf3"];
            $UDF4       = $_POST["udf4"];
            $UDF5       = $_POST["udf5"];
            $errorText  = $_POST["ErrorText"];
        }
        else
        {
            $errorText = "Unknown Exception";
        }
        
        if($errorText){
            return response()->json(["success"=>false,"message"=>"payment failed."]);
        }
    	if ($myObj->getResult() == "CAPTURED")
    	{
    	    $response = $this->complete_payment_method($invoiceID, $amount, $paymentReponse, $responseCode, $gateway, $referenceID);
            return response()->json(["success"=>true,"message"=>"payment completed successfully."]);
    	}
    	else if ($myObj->getResult() == "NOT CAPTURED" || $myObj->getResult() == "CANCELED" || $myObj->getResult() == "DENIED BY RISK" || $myObj->getResult() == "HOST TIMEOUT")
    	{
    		if ($myObj->getResult() == "NOT CAPTURED")
    		{
    			switch ($myObj->getAuthRespCode())
    			{
    				case "05":
    					$response = "Please contact issuer";
    					break;
    				case "14":
    					$response = "Invalid card number";
    					break;
    				case "33":
    					$response = "Expired card";
    					break;
    				case "36":
    					$response = "Restricted card";
    					break;
    				case "38":
    					$response = "Allowable PIN tries exceeded";
    					break;
    				case "51":
    					$response = "Insufficient funds";
    					break;
    				case "54":
    					$response = "Expired card";
    					break;
    				case "55":
    					$response = "Incorrect PIN";
    					break;
    				case "61":
    					$response = "Exceeds withdrawal amount limit";
    					break;
    				case "62":
    					$response = "Restricted Card";
    					break;
    				case "65":
    					$response = "Exceeds withdrawal frequency limit";
    					break;
    				case "75":
    					$response = "Allowable number PIN tries exceeded";
    					break;
    				case "76":
    					$response = "Ineligible account";
    					break;
    				case "78":
    					$response = "Refer to Issuer";
    					break;
    				case "91":
    					$response = "Issuer is inoperative";
    					break;
    				default:
    					// for unlisted values, please generate a proper user-friendly message
    					$response = "Unable to process transaction temporarily. Try again later or try using another card.";
    					break;
    			}
    		}
    		else if ($myObj->getResult() == "CANCELED")
    		{
    			$response = "Transaction was canceled by user.";
    		}
    		else if ($myObj->getResult() == "DENIED BY RISK")
    		{
    			$response = "Maximum number of transactions has exceeded the daily limit.";
    		}
    		else if ($myObj->getResult() == "HOST TIMEOUT")
    		{
    			$response = "Unable to process transaction temporarily. Try again later.";
    		}
            return response()->json(["success"=>false,"message"=>$response]);
            
    	}
    	else
    	{
            return response()->json(["success"=>false,"message"=>"Your payment is failed. Reason: Unable to process transaction temporarily. Try again later or try using another card"]);
        }
    }
    
    private function complete_payment_method($transactionID, $amount, $paymentResponse, $responseCode, $gateway, $type){
        if($type == 'service')
            $orderDetails = ServiceFieldReport::where('payment_id', $transactionID)->first();
        else{
            $orderDetails = Order::where('payment_id', $transactionID)->first();
            $cart = Cart::find($orderDetails->cart_id);
            if($cart){
                $cart->delete();
            }
        }

        $orderDetails->payment_method = $gateway;
        $orderDetails->payment_status = 1;
        $orderDetails->PaymentStatus = 'paid';

        // $payment = Payment::where('payment_id', $transactionID)->first();
        // $payment->response   = $paymentResponse;
        // $payment->save();

        /*$payment = new Payment();
        $payment->payment_id = $transactionID;
        $payment->type       = $type;
        $payment->method     = $gateway;
        $payment->response   = $paymentResponse;
        $payment->save();*/

        
        if($paymentResponse == 'CAPTURED' || $paymentResponse == 'AUTHORIZED'){
            $orderDetails->payment_status = 1;
            $response = 'success';

            //$this->calculateLoyalty( $amount, $orderDetails->user_id );

            /*$userDetails = User::where('id', $orderDetails->user_id)->first();
            $emailData = array(
                'orderDetails' => $orderDetails,
                'userDetails' => $userDetails
            );
            try
            {
                Mail::send('email.order', $emailData, function($message) use($emailData) {
                    $message->to($emailData['userDetails']->email);
                    $message->cc('info@dietdelightbh.com');
                    $message->bcc('saikumar@webtreeonline.com');
                    $message->subject('Order Confirmation #'.$emailData['orderDetails']->payment_id);
                });
            }
            catch(\Exception $e)
            {
                //
            }

            /*(Mail::send('email.order', $emailData, function($message) use($emailData) {
                $message->to( $emailData['userDetails']->email );
                $message->subject('Order Confirmation #'.$emailData['orderDetails']->payment_id);
            });*/


        }else{
            $orderDetails->payment_status = 0;
            $response = 'failed';
        }

        $orderDetails->save();
        return $response;
        
	}

    public function success($id = null){
        return view('payment.success', compact('id'));
    }
    public function failed($message = null){
       return view('payment.failed', compact('message'));
    }
    public function cancelled(){
        return view('payment.failed');
    }
    public function hold(){
        return view('payment.hold');
    }


}
