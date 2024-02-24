<?php

namespace App\Http\Controllers;

use App\Models\ProductType;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Designation;
use App\Models\AreaName;
use App\Models\Account_Setting;
use App\Models\ServiceType;
use App\Models\IssueType;
use App\Models\ContractType;
use App\Models\AccessMaster;
use App\Models\StoreProductCategory;
use Illuminate\Support\Facades\Hash;
use App\Models\SystemLog;


class MasterController extends Controller
{
    //
    public function GetRoleAccess(Request $request)
    {
        $accessmaster = array();
        try {

            $accessmaster = AccessMaster::where("id", "!=", 1)->where("id", "!=", 5)->where("id", "!=", 3)
                ->get();

        } catch (Illuminate\Database\QueryException $ex) {
            //return $ex->errorInfo;
        }
        return $accessmaster;

    }
    public function Account_Setting(Request $request)
    {

        $setting = Account_Setting::all();
        return $setting;

    }
    public function GetDesignation(Request $request)
    {
        $designation = array();
        try {

            $designation = Designation::all();

        } catch (Illuminate\Database\QueryException $ex) {
            return $ex->errorInfo;
        }
        return $designation;
    }
    public function GetServiceType()
    {
        $serviceType = array();
        try {

            $serviceType = ServiceType::all();

        } catch (Illuminate\Database\QueryException $ex) {
            return $ex->errorInfo;
        }
        return $serviceType;
    }

    public function ServiceType(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                "id" => "required",
                "name" => "required",
            ]
        );
        if ($validator->fails()) {
            return response()->json(["success" => false, "message" => "data missing, try again.", "validation_error" => $validator->errors()]);
        }
        if ($request->id > 0) {
            $checkName = ServiceType::where('type_name', $request->name)
                ->where('id', "!=", $request->id)->get();
            if ($checkName->count() > 0) {
                return response()->json(["success" => false, "message" => "duplicate service type.", "validation_error" => $validator->errors()]);
            } else {
                $update = ServiceType::where('id', $request->id)->update([
                    'type_name' => $request->name
                ]);
                if ($update) {
                    return response()->json(["success" => true, "message" => "service type updated.", "validation_error" => $validator->errors()]);
                } else {
                    return response()->json(["success" => false, "message" => "action failed, try again.", "validation_error" => $validator->errors()]);
                }
            }

        } else {
            $checkName = ServiceType::where('type_name', $request->name)->get();
            if ($checkName->count() == 0) {
                $create = ServiceType::create([
                    'type_name' => $request->name
                ]);
                if ($create) {
                    return response()->json(["success" => true, "message" => "Service Type Created", "validation_error" => $validator->errors()]);
                } else {
                    return response()->json(["success" => false, "message" => "action failed, try again.", "validation_error" => $validator->errors()]);
                }
            } else {
                return response()->json(["success" => false, "message" => "duplicate service type.", "validation_error" => $validator->errors()]);
            }
        }
    }
    public function IssueType(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                "id" => "required",
                "name" => "required",
            ]
        );
        if ($validator->fails()) {
            return response()->json(["success" => false, "message" => "data missing, try again.", "validation_error" => $validator->errors()]);
        }
        if ($request->id > 0) {
            $checkName = IssueType::where('issue_name', $request->name)
                ->where('id', "!=", $request->id)->get();
            if ($checkName->count() > 0) {
                return response()->json(["success" => false, "message" => "duplicate issue type.", "validation_error" => $validator->errors()]);
            } else {
                $update = IssueType::where('id', $request->id)->update([
                    'issue_name' => $request->name
                ]);
                if ($update) {
                    return response()->json(["success" => true, "message" => "issue type updated.", "validation_error" => $validator->errors()]);
                } else {
                    return response()->json(["success" => false, "message" => "action failed, try again.", "validation_error" => $validator->errors()]);
                }
            }

        } else {
            $checkName = IssueType::where('issue_name', $request->name)->get();
            if ($checkName->count() == 0) {
                $create = IssueType::create([
                    'issue_name' => $request->name
                ]);
                if ($create) {
                    return response()->json(["success" => true, "message" => "issue type created", "validation_error" => $validator->errors()]);
                } else {
                    return response()->json(["success" => false, "message" => "action failed, try again.", "validation_error" => $validator->errors()]);
                }
            } else {
                return response()->json(["success" => false, "message" => "duplicate issue type.", "validation_error" => $validator->errors()]);
            }
        }
    }
    public function GetIssueType()
    {
        $issueType = array();
        try {
            $issueType = IssueType::all();
        } catch (Illuminate\Database\QueryException $ex) {
            return $ex->errorInfo;
        }
        return $issueType;
    }
    public function ct_saveupdate(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                "id" => "required",
                "name" => "required",
                "flag" => "required",
            ]
        );
        if ($validator->fails()) {
            return response()->json(["success" => false, "message" => "data missing, try again.", "validation_error" => $validator->errors()]);
        }
        if ($request->flag == 1) {
            $checkName = ContractType::where('contract_type_name', $request->name)
                ->where('id', "!=", $request->id)->get();
            if ($checkName->count() > 0) {
                return response()->json(["success" => false, "message" => "duplicate contract type.", "validation_error" => $validator->errors()]);
            } else {
                $update = ContractType::where('id', $request->id)->update([
                    'contract_type_name' => $request->name
                ]);
                if ($update) {
                    return response()->json(["success" => true, "message" => "contract type updated.", "validation_error" => $validator->errors()]);
                } else {
                    return response()->json(["success" => false, "message" => "action failed, try again.", "validation_error" => $validator->errors()]);
                }
            }

        } else {
            $checkName = ContractType::where('contract_type_name', $request->name)->get();
            if ($checkName->count() == 0) {
                $create = ContractType::create([
                    'contract_type_name' => $request->name
                ]);
                if ($create) {
                    return response()->json(["success" => true, "message" => "contract type created", "validation_error" => $validator->errors()]);
                } else {
                    return response()->json(["success" => false, "message" => "action failed, try again.", "validation_error" => $validator->errors()]);
                }
            } else {
                return response()->json(["success" => false, "message" => "duplicate contract type.", "validation_error" => $validator->errors()]);
            }
        }
    }
    public function ContractType(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                "id" => "required",
                "name" => "required",
            ]
        );
        if ($validator->fails()) {
            return response()->json(["success" => false, "message" => "data missing, try again.", "validation_error" => $validator->errors()]);
        }
        if ($request->id > 0) {
            $checkName = ContractType::where('contract_type_name', $request->name)
                ->where('id', "!=", $request->id)->get();
            if ($checkName->count() > 0) {
                return response()->json(["success" => false, "message" => "duplicate contract type.", "validation_error" => $validator->errors()]);
            } else {
                $update = ContractType::where('id', $request->id)->update([
                    'contract_type_name' => $request->name
                ]);
                if ($update) {
                    return response()->json(["success" => true, "message" => "contract type updated.", "validation_error" => $validator->errors()]);
                } else {
                    return response()->json(["success" => false, "message" => "action failed, try again.", "validation_error" => $validator->errors()]);
                }
            }

        } else {
            $checkName = ContractType::where('contract_type_name', $request->name)->get();
            if ($checkName->count() == 0) {
                $create = ContractType::create([
                    'contract_type_name' => $request->name
                ]);
                if ($create) {
                    return response()->json(["success" => true, "message" => "contract type created", "validation_error" => $validator->errors()]);
                } else {
                    return response()->json(["success" => false, "message" => "action failed, try again.", "validation_error" => $validator->errors()]);
                }
            } else {
                return response()->json(["success" => false, "message" => "duplicate contract type.", "validation_error" => $validator->errors()]);
            }
        }
    }
    public function GetContractType()
    {
        $contractType = array();
        try {
            $contractType = ContractType::all();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
        return $contractType;
    }
    public function ct_index(Request $request)
    {
        $contractType = array();
        try {
            $contractType = ContractType::paginate(10)
                ->withQueryString();
        } catch (Exception $ex) {
            // return $ex->getMessage();
        }
        // dd($contractType);
        return view(
            'masters.contract_type.index',
            [
                'contractTypes' => $contractType
            ]
        );
    }
    public function ct_delete(Request $request)
    {
        $id = $request->id ?? 0;
        $res['message'] = 'action failed, try again';
        $res['code'] = 400;
        try {
            $delete = ContractType::where('id', $id)->delete();
            if ($delete) {
                $res['message'] = 'Deleted';
                $res['code'] = 200;
            }
        } catch (Exception $ex) {
            // return $ex->getMessage();
            $res['message'] = 'action failed, try again' . $ex->getMessage();
            $res['code'] = 400;
        }
        return json_encode($res);
    }

    public function pt_index(Request $request)
    {
        $productType = array();
        try {
            $productType = ProductType::paginate(10)
                ->withQueryString();
        } catch (Exception $ex) {
            // return $ex->getMessage();
        }
        return view('masters.product_type.index', ['productTypes' => $productType]);
    }

    public function pt_delete(Request $request)
    {
        $id = $request->id ?? 0;
        $res['message'] = 'action failed, try again';
        $res['code'] = 400;
        try {
            $delete = ProductType::where('id', $id)->delete();
            if ($delete) {
                $res['message'] = 'Deleted';
                $res['code'] = 200;
            }
        } catch (Exception $ex) {
            // return $ex->getMessage();
            $res['message'] = 'action failed, try again' . $ex->getMessage();
            $res['code'] = 400;
        }
        return json_encode($res);
    }
    public function pt_saveupdate(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                "id" => "required",
                "name" => "required",
                "flag" => "required",
            ]
        );
        if ($validator->fails()) {
            return response()->json(["success" => false, "message" => "data missing, try again.", "validation_error" => $validator->errors()]);
        }
        if ($request->flag == 1) {
            $checkName = ProductType::where('type_name', $request->name)
                ->where('id', "!=", $request->id)->get();
            if ($checkName->count() > 0) {
                return response()->json(["success" => false, "message" => "duplicate product type.", "validation_error" => $validator->errors()]);
            } else {
                $update = ProductType::where('id', $request->id)->update([
                    'type_name' => $request->name
                ]);
                if ($update) {
                    return response()->json(["success" => true, "message" => "product type updated.", "validation_error" => $validator->errors()]);
                } else {
                    return response()->json(["success" => false, "message" => "action failed, try again.", "validation_error" => $validator->errors()]);
                }
            }

        } else {
            $checkName = ProductType::where('type_name', $request->name)->get();
            if ($checkName->count() == 0) {
                $create = ProductType::create([
                    'type_name' => $request->name
                ]);
                if ($create) {
                    return response()->json(["success" => true, "message" => "product type created", "validation_error" => $validator->errors()]);
                } else {
                    return response()->json(["success" => false, "message" => "action failed, try again.", "validation_error" => $validator->errors()]);
                }
            } else {
                return response()->json(["success" => false, "message" => "duplicate product type.", "validation_error" => $validator->errors()]);
            }
        }
    }
    public function UploadImage($request)
    {
        $imagesName = "";
        if ($request->has('path')) {
            $image = $request->path;
            $catName = str_replace(' ', '', $request->name);
            $imagesName = "/assets/images/Category_Images/" . $catName . '.png';
            $path = public_path() . $imagesName;
            if (file_exists($path)) {
                unlink($path);
            }
            $img = substr($image, strpos($image, ",") + 1);
            $data = base64_decode($img);
            //  print_r($img);
            //exit;
            $success = file_put_contents($path, $data);
            if ($success) {
                //$imagesName= "/public".$imagesName;   // uncomment for server
                $imagesName = $imagesName;    // comment for server
            } else {
                $imagesName = "";
            }

        } else {
            $imagesName = "";
        }
        return $imagesName;
    }
    public function ProductCategory(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                "id" => "required",
                "name" => "required",
            ]
        );
        if ($validator->fails()) {
            return response()->json(["success" => false, "message" => "data missing, try again.", "validation_error" => $validator->errors()]);
        }
        if ($request->id > 0) {

            $upload = "";
            if ($request->has('path') && $request->path != "") {
                $upload = $this->UploadImage($request);
            } else {
                $upload = $request->image;
            }
            $checkName = StoreProductCategory::where('name', $request->name)
                ->where('id', "!=", $request->id)->get();
            if ($checkName->count() > 0) {
                return response()->json(["success" => false, "message" => "duplicate product category type.", "validation_error" => $validator->errors()]);
            } else {
                $update = StoreProductCategory::where('id', $request->id)->update([
                    'name' => $request->name,
                    'image' => $upload
                ]);
                if ($update) {
                    return response()->json(["success" => true, "message" => "product category updated.", "validation_error" => $validator->errors()]);
                } else {
                    return response()->json(["success" => false, "message" => "action failed, try again.", "validation_error" => $validator->errors()]);
                }
            }

        } else {
            $upload = "";
            if ($request->has('path')) {
                $upload = $this->UploadImage($request);
            } else {
                $upload = $request->image;
            }
            $checkName = StoreProductCategory::where('name', $request->name)->get();
            if ($checkName->count() == 0) {
                $create = StoreProductCategory::create([
                    'name' => $request->name,
                    'image' => $upload
                ]);
                if ($create) {
                    return response()->json(["success" => true, "message" => "product category created", "validation_error" => $validator->errors()]);
                } else {
                    return response()->json(["success" => false, "message" => "action failed, try again.", "validation_error" => $validator->errors()]);
                }
            } else {
                return response()->json(["success" => false, "message" => "duplicate product category.", "validation_error" => $validator->errors()]);
            }
        }
    }
    public function GetProductCategory()
    {
        $StoreProductCategory = array();
        try {
            $StoreProductCategory = StoreProductCategory::all();
        } catch (Illuminate\Database\QueryException $ex) {
            return $ex->errorInfo;
        }
        return $StoreProductCategory;
    }

    public function Designation(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                "id" => "required",
                "name" => "required",
            ]
        );
        if ($validator->fails()) {
            return response()->json(["success" => false, "message" => "Data missing, try again.", "validation_error" => $validator->errors()]);
        }
        if ($request->id > 0) {
            $checkName = Designation::where('designation_name', $request->name)
                ->where('id', "!=", $request->id)->get();
            if ($checkName->count() > 0) {
                return response()->json(["success" => false, "message" => "duplicate designation name.", "validation_error" => $validator->errors()]);
            } else {
                $update = Designation::where('id', $request->id)->update([
                    'designation_name' => $request->name
                ]);
                if ($update) {
                    return response()->json(["success" => true, "message" => "Designation Updated.", "validation_error" => $validator->errors()]);
                } else {
                    return response()->json(["success" => false, "message" => "action failed, try again.", "validation_error" => $validator->errors()]);
                }
            }

        } else {
            $checkName = Designation::where('designation_name', $request->name)->get();
            if ($checkName->count() == 0) {
                $create = Designation::create([
                    'designation_name' => $request->name
                ]);
                if ($create) {
                    return response()->json(["success" => true, "message" => "Designation Created", "validation_error" => $validator->errors()]);
                } else {
                    return response()->json(["success" => false, "message" => "action failed, try again.", "validation_error" => $validator->errors()]);
                }
            } else {
                return response()->json(["success" => false, "message" => "duplicate designation name.", "validation_error" => $validator->errors()]);
            }

        }


    }
    public function GetSiteArea(Request $request)
    {
        $area = array();
        try {
            $area = AreaName::all();

        } catch (Illuminate\Database\QueryException $ex) {
            return $ex->errorInfo;
        }
        return $area;
    }
    public function sa_index(Request $request)
    {
        $area = array();
        try {
            $area = AreaName::paginate(10)
                ->withQueryString();

        } catch (Exception $ex) {
            // return $ex->errorInfo;
        }
        return view("masters.site_area.index", ["siteAreas" => $area]);
    }
    public function sa_delete(Request $request)
    {
        $id = $request->id ?? 0;
        $res['message'] = 'action failed, try again';
        $res['code'] = 400;
        try {
            $delete = AreaName::where('id', $id)->delete();
            if ($delete) {
                $res['message'] = 'Deleted';
                $res['code'] = 200;
            }
        } catch (Exception $ex) {
            // return $ex->getMessage();
            $res['message'] = 'action failed, try again' . $ex->getMessage();
            $res['code'] = 400;
        }
        return json_encode($res);
    }
    public function sa_saveupdate(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                "id" => "required",
                "name" => "required",
                "flag" => "required",
            ]
        );
        if ($validator->fails()) {
            return response()->json(["success" => false, "message" => "data missing, try again.", "validation_error" => $validator->errors()]);
        }
        if ($request->flag == 1) {
            $checkName = AreaName::where('SiteAreaName', $request->name)
                ->where('id', "!=", $request->id)->get();
            if ($checkName->count() > 0) {
                return response()->json(["success" => false, "message" => "duplicate area name.", "validation_error" => $validator->errors()]);
            } else {
                $update = AreaName::where('id', $request->id)->update([
                    'SiteAreaName' => $request->name
                ]);
                if ($update) {
                    return response()->json(["success" => true, "message" => "product type updated.", "validation_error" => $validator->errors()]);
                } else {
                    return response()->json(["success" => false, "message" => "action failed, try again.", "validation_error" => $validator->errors()]);
                }
            }

        } else {
            $checkName = AreaName::where('SiteAreaName', $request->name)->get();
            if ($checkName->count() == 0) {
                $create = AreaName::create([
                    'SiteAreaName' => $request->name
                ]);
                if ($create) {
                    return response()->json(["success" => true, "message" => "area created", "validation_error" => $validator->errors()]);
                } else {
                    return response()->json(["success" => false, "message" => "action failed, try again.", "validation_error" => $validator->errors()]);
                }
            } else {
                return response()->json(["success" => false, "message" => "duplicate area name.", "validation_error" => $validator->errors()]);
            }
        }
    }
    public function SiteArea(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                "id" => "required",
                "name" => "required",
            ]
        );
        if ($validator->fails()) {
            return response()->json(["success" => false, "message" => "Data missing, try again.", "validation_error" => $validator->errors()]);
        }
        if ($request->id > 0) {
            $checkName = AreaName::where('SiteAreaName', $request->name)
                ->where('id', "!=", $request->id)->get();
            if ($checkName->count() == 0) {
                $update = AreaName::where('id', $request->id)->update([
                    'SiteAreaName' => $request->name
                ]);
                if ($update) {
                    return response()->json(["success" => true, "message" => "area name updated"]);
                } else {
                    return response()->json(["success" => false, "message" => "action failed, try again."]);
                }
            } else {
                return response()->json(["success" => false, "message" => "duplicate area name"]);
            }
        } else {
            $checkName = AreaName::where('SiteAreaName', $request->name)
                ->get();
            if ($checkName->count() == 0) {
                $update = AreaName::create([
                    'SiteAreaName' => $request->name
                ]);
                if ($update) {
                    return response()->json(["success" => true, "message" => "area created."]);
                } else {
                    return response()->json(["success" => false, "message" => "action failed, try again."]);
                }
            } else {
                return response()->json(["success" => false, "message" => "duplicate area name"]);
            }
        }


    }
    public function SystemLog(Request $request)
    {

        $log = SystemLog::create([
            "loginId" => $request->loginId,
            "loginRole" => $request->loginRole,
            "ActionDescription" => $request->ActionDescription
        ]);
        if ($log) {
            return response()->json(["success" => true, "message" => "log created"]);
        }
    }



}

