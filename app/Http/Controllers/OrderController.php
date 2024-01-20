<?php

namespace App\Http\Controllers;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User; 
use App\Models\SystemLog; 
use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Support\Facades\Hash;


class OrderController extends Controller
{
    

    public function GetOrderList(Request $request){

        $orders = Order::where("Customer_Id",$request->id)->get();
        if(count($orders)>0){
            foreach($orders as $order){ 
                $order->view = "/pages/view-order?id=".$order->id;
                $order->createdat = date('d-m-Y H:i:s a', strtotime($order->created_at));
            }
            return response()->json(['success' => true, 'message'=> '','orders'=>$orders]); 
        }else {
        return response()->json(['success' => true, 'message'=> '','orders'=>[]]); 
        }
    }
    public function GetOrderListAdmin(Request $request){

        $orders = Order::all();
        if(count($orders)>0){
            foreach($orders as $order){ 
                $order->view = "/pages/view-order?id=".$order->id;
                $order->createdat = date('d-m-Y H:i:s a', strtotime($order->created_at));
            }
            return response()->json(['success' => true, 'message'=> '','orders'=>$orders]); 
        }else {
        return response()->json(['success' => true, 'message'=> '','orders'=>[]]); 
        }
    }
    public function NewOrder(Request $request){

        $validator  =       Validator::make($request->all(),
        [
            "customerId"             =>          "required",
            "address"             =>          "required",
        ]

    );
    if($validator->fails()) {
            return response()->json(["success" => false, "message"=>"all * marked fields required.","validation_error" => $validator->errors()]);
        }
        if(isset($request->product) && sizeof($request->product)>0){

            try {

                $order = Order::create([
                    'Customer_Id'=>$request->customerId,
                    'CustomerName'=>$request->name,
                    'Order_Delivery_Address'=>$request->address,
                    'Order_Billing_Address'=>$request->address,
                    'Order_Amount'=>$request->total,
                    'Order_Payment_Status'=>0,
                    'Order_Payment_Mode'=>0,
                    'Order_Status'=>0,
                    'Order_ContactPerson'=>$request->contactPerson,
                    'Order_Contact'=>$request->contactNumber,
                    "AreaName"=>$request->areaName,
                    "AreaCode"=>$request->areaCode,
                    "Vat"=>$request->vat,
                    "SubTotal"=>$request->subTotal,
                ]);
                $count=0;
                if($order->id>0) {
                    $products = $request->product;
                    foreach($products as $product){

                        $orderProduct = OrderProduct :: create([
                            'Order_Id'=>$order->id,
                            'Product_Id'=>$product['id'],
                            'Product_Name'=>$product['product_name'],
                            'Product_Price'=>$product['product_price_sell'],
                            'Product_Qty'=>$product['product_qty'],
                        ]);
                        if($orderProduct->id>0){
                            $count++;
                        }

                    }
                    if(sizeof($products) == $count) {
                        return response()->json(["success" => true, "message"=>"Order Placed."]);
                    } else {
                        Order::where("id",$order->id)->delete();
                        OrderProduct::where("Order_Id",$order)->delete();
                        return response()->json(["success" => false, "message"=>"Order request failed, try again."]);
                    }
                } else {
                    return response()->json(["success" => false, "message"=>"Something went wrong."]);
                }

            } catch(Exception $exception){

            }

        } else {
            return response()->json(["success" => false, "message"=>"order product missing."]);
        }


    }
    public function UpdateOrder(){
            
    }
    public function UpdateOrderStatus(Request $request){
        
            $validator  =       Validator::make($request->all(),
            [
            "orderId"             =>          "required",
            "orderStatus"             =>          "required",
        ]);
        if($validator->fails()) {
            return response()->json(["success" => false, "message"=>"Order Details Missing"]);
        }
        
        $update = Order::where("id",$request->orderId)->update([
                "Order_Status"=>$request->orderStatus
            ]);
            if($update){
                return response()->json(["success" => true, "message"=>"Order Status Updated"]);
            } else {
                return response()->json(["success" => false, "message"=>"Order Status Updated Failed"]);
            }
        

    }
    public function GetOrderById(Request $request){
        
         $order = Order::where("id",$request->id)->first();
            if($order->id>0){
                $order->view = "/pages/view-order?id=".$order->id;
                $order->createdat = date('d-m-Y H:i:s a', strtotime($order->created_at));
                $order->product = $this->GetOrderProduct($order->id);
                return response()->json(['success' => true, 'message'=> '','orders'=>$order]); 
            } else {
                return response()->json(['success' => true, 'message'=> '','orders'=>$order]); 
            }
    }
    public function GetOrderProduct($orderId){
        
        $products = OrderProduct::where("Order_Id",$orderId)->get();
        return $products;
    }
    public function CreateOrderHistory(){

    }
    

    public function addLog($Id,$action){

        $islog = SystemLog::create([
            "loginId"=>$Id,
             "ActionDescription"=>$action   
        ]);
      }
     
      
      
    
}

