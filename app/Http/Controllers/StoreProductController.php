<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\StoreProduct;
use App\Models\StoreProductBrand;
use App\Models\StoreProductCategory;
use Illuminate\Support\Facades\Hash;


class StoreProductController extends Controller
{
    //


    public function GetStoreProductById(Request $request)
    {
        $storeproduct = array();
        $id = $request->id;
        try {
            $storeproduct = StoreProduct::
                join("master_store_product_category", "master_store_product_category.id", "storeproduct.product_category")
                ->where("storeproduct.id", $id)->first(["storeproduct.id as productId", "storeproduct.*", "master_store_product_category.*"]);
        } catch (Illuminate\Database\QueryException $ex) {
            return $ex->errorInfo;
        }
        return $storeproduct;
    }
    public function GetStoreProducts(Request $request)
    {
        $storeproducts = array();
        try {
            $storeproducts = StoreProduct::leftJoin("master_store_product_category", "master_store_product_category.id", "storeproduct.product_category")
                ->get(["storeproduct.id as productId", "master_store_product_category.*", "storeproduct.*"]);
            foreach ($storeproducts as $storeproduct) {
                $storeproduct->Edit = "/spareproduct/edit-product?id=" . $storeproduct->id;
                $storeproduct->View = "/spareproduct/view-product?id=" . $storeproduct->id;
            }
        } catch (Illuminate\Database\QueryException $ex) {
            //return $ex->errorInfo;
        }
        return $storeproducts;
    }
    public function getCategoryList(Request $request)
    {
        $categorys = array();
        try {
            $categorys = StoreProductCategory::all();
        } catch (Illuminate\Database\QueryException $ex) {
            return $ex->errorInfo;
        }
        return $categorys;
    }
    public function getBrandList(Request $request)
    {
        $brands = array();
        try {
            $brands = StoreProductBrand::all();
        } catch (Illuminate\Database\QueryException $ex) {
            return $ex->errorInfo;
        }
        return $brands;
    }
    public function UpdateProductImage(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                "product_name" => "required",
                "productId" => "required",
            ]
        );

        if ($validator->fails()) {
            return response()->json(["success" => false, "message" => "data missing, refresh and try again."]);
        }
        $upload = $this->UploadProductImage($request);
        if ($upload != "") {
            try {
                $product = StoreProduct::where("id", $request->productId)->update([
                    'product_image_url' => $upload,
                ]);
                if ($product) {
                    return response()->json(['success' => true, 'message' => 'Product Image Updated.']);
                } else {
                    return response()->json(['success' => false, 'message' => 'Action failed, Try again.']);
                }
            } catch (Illuminate\Database\QueryException $ex) {
                return response()->json(['success' => false, 'message' => $ex->errorInfo]);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'Product Image Update Failed.']);
        }
    }
    public function UploadProductImage($request)
    {
        $imagesName = "";
        if ($request->has('product_image_url_path')) {
            $image = $request->product_image_url_path;
            $productName = str_replace(' ', '', $request->product_name);
            $productName = str_replace('+', '', $request->product_name);
            $image_path = "/images/products/Product_" . $productName . '.png';
            $imagesName = "/app/public" . $image_path;
            $path = storage_path() . $imagesName;
            if (file_exists($path)) {
                unlink($path);
            }
            $img = substr($image, strpos($image, ",") + 1);
            $data = base64_decode($img);
            $success = file_put_contents($path, $data);
            if ($success) {
                $imagesName = "/storage" . $image_path;
            } else {
                $imagesName = "";
            }
        } else {
            $imagesName = "";
        }
        return $imagesName;
    }

    public function UpdateStoreProduct(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                "product_name" => "required",
                "product_category" => "required",
                "product_price_mrp" => "required",
                "product_price_sell" => "required",
                "product_description" => "required",
            ]
        );

        if ($validator->fails()) {
            return response()->json(["success" => false, "message" => "all * marked fields required.", "validation_error" => $validator->errors()]);
        }
        try {
            $product = StoreProduct::where("id", $request->productId)->update([
                'product_name' => $request->product_name,
                'product_brand' => $request->product_brand,
                'product_category' => $request->product_category,
                'product_qty' => $request->product_qty,
                'product_price_mrp' => $request->product_price_mrp,
                'product_price_sell' => $request->product_price_sell,
                'product_offer_price' => $request->product_offer_price,
                'is_offer_active' => $request->is_offer_active,
                'product_is_active' => $request->product_is_active,
                'product_description' => $request->product_description,

            ]);
            if ($product) {
                return response()->json(['success' => true, 'message' => 'Product Updated.']);
            } else {
                return response()->json(['success' => false, 'message' => 'Action failed, Try again.']);
            }
        } catch (Illuminate\Database\QueryException $ex) {
            return response()->json(['success' => false, 'message' => $ex->errorInfo]);
        }

    }
    public function AddStoreProduct(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                "product_name" => "required",
                "product_category" => "required",
                "product_price_mrp" => "required",
                "product_description" => "required",
            ]
        );

        if ($validator->fails()) {
            return response()->json(["success" => false, "message" => "all * marked fields required.", "validation_error" => $validator->errors()]);
        }
        try {
            $upload = $this->UploadProductImage($request);
            if ($upload != "") {
                $product = StoreProduct::create([
                    'product_name' => $request->product_name,
                    'product_brand' => $request->product_brand,
                    'product_category' => $request->product_category,
                    'product_qty' => $request->product_qty,
                    'product_price_mrp' => $request->product_price_mrp,
                    'product_price_sell' => 0,
                    'product_offer_price' => 0,
                    'is_offer_active' => 0,
                    'product_is_active' => $request->product_is_active,
                    'product_description' => $request->product_description,
                    'product_image_url' => $upload
                ]);
                if ($product) {
                    return response()->json(['success' => true, 'message' => 'Product Created.']);
                } else {
                    return response()->json(['success' => false, 'message' => 'Action failed, Try again.']);
                }
            } else {
                return response()->json(['success' => false, 'message' => 'product image upload failed, try again']);
            }

        } catch (Illuminate\Database\QueryException $ex) {
            return response()->json(['success' => false, 'message' => $ex->errorInfo]);
        }


    }
    function productUpdate(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    "Eng_Name" => "required",
                ]
            );
            if ($validator->fails()) {
                return response()->json(["success" => false, "validation_error" => $validator->errors()]);
            }
            $engId = $request->engId;
            $loginId = $request->loginId;
            $isuniq = Engineer::where("User_Id", $engId)->where("Client_Id", $loginId)->first();
            if (!is_null($isuniq)) {
                $engineer = Engineer::where("User_Id", $engId)
                    ->where("Client_Id", $loginId)
                    ->update([
                        'Eng_Name' => $request->Eng_Name,
                        'Eng_Mobile' => $request->Eng_Mobile,
                        'Eng_Address' => $request->Eng_Address,
                        'Other_Info' => $request->Other_Info,
                        'Eng_Email' => $request->Eng_Email,
                    ]);
                if ($engineer) {
                    return response()->json(['success' => true, 'message' => 'Updated.']);
                } else {
                    return response()->json(["code" => 500, 'success' => false, 'message' => 'Failed to update engineer, Try again.']);
                }
            } else {
                return response()->json(["code" => 500, 'success' => false, 'message' => 'Engineer not found, Try again.']);
            }
        } catch (Illuminate\Database\QueryException $ex) {
            return response()->json(['success' => false, 'message' => $ex->errorInfo]);
        }
    }
    function deleteProduct(Request $request)
    {

        $engId = $request->engId;
        $loginId = $request->loginId;
        if ($engId != 0 && $loginId != 0 && $engId != "" && $loginId != "") {
            $isuniq = Engineer::join("users", "users.id", "engineers.User_Id")->where("engineers.User_Id", $engId)->where("engineers.Client_Id", $loginId)->first();
            if (!is_null($isuniq)) {
                $isdelete1 = Engineer::where("engineers.User_Id", $engId)->where("engineers.Client_Id", $loginId)->delete();
                if ($isdelete1) {
                    $isdelete2 = User::where("id", $engId)->delete();
                    if ($isdelete2) {
                        return response()->json(['success' => true, 'message' => 'Engineer deleted.']);
                    } else {
                        $restoreDataId = Engineer::withTrashed()->find("User_Id", $loginId);
                        if ($restoreDataId && $restoreDataId->trashed()) {
                            $restoreDataId->restore();
                        }
                        return response()->json(["code" => 500, 'success' => false, 'message' => 'Action failed, Try again.']);
                    }
                } else {

                }
            } else {
                return response()->json(["code" => 500, 'success' => false, 'message' => 'Engineer not found, Try again.']);
            }
        } else {
            return response()->json(['success' => false, 'message' => "Invalid inputs, Try again."]);
        }
    }
    function getEmployeeById(Request $request)
    {

        try {

            $clinetId = $request->loginId;
            $engId = $request->engId;
            if ($clinetId != "" && $clinetId != 0 && $engId != "" && $engId != 0) {
                $engineer = Engineer::join("users", "users.id", "engineers.User_Id")
                    ->where("engineers.User_Id", $engId)->where("engineers.Client_Id", $clinetId)->first();
                return response()->json(['success' => true, 'message' => '' . $engId . "..." . $clinetId, 'engineer' => $engineer]);
            } else {
                return response()->json(['success' => false, 'message' => 'Something went wrong.', 'engineer' => null]);
            }

        } catch (Illuminate\Database\QueryException $ex) {
            return response()->json(['success' => false, 'message' => "Error:" . $ex->errorInfo, 'engineer' => null]);
        }

    }



}

