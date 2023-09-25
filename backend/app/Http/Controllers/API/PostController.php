<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class PostController extends BaseController
{

    public function __construct()
    {
    }

    public function index(Request $request)
    {
        if (!$request->isMethod('GET')) {
            return response()->json(['status' => false, 'code' => 901, 'message' => 'Invalid request method'], 401);
        }
        try {
            $search = $request->get('search');
            $sortBy = $request->get('sort_by');
            $sortType = $request->get('sort_type');
            $perPage = (int) $request->get('per_page');

            if(!empty($sortBy) && !empty($sortType)){

                $data =  Post::orderBy($sortBy,$sortType);
            }else{
                $data = Post::orderBy('created_at', 'desc');
            }

            if(!empty($search)){
                $data =   $data->where(DB::raw('lower(title)'), 'LIKE', '%' . strtolower($search) . '%');
            }

            $data =$data->paginate($perPage);


            if ($data) {
                $response =  $this->sendSuccess('Login successfully done.',  $data);
            } else {
                $response =  $this->sendError(401, 'There is no data');
            }

        } catch (Exception $e) {
            $response = $this->sendError(99, 'Something went wrong.',$e->getMessage());
        }
        return $response;
    }

    public function view(Request $request, $slug='')
    {
        if (!$request->isMethod('GET')) {
            return response()->json(['status' => false, 'code' => 901, 'message' => 'Invalid request method'], 401);
        }
        try {
            $data = Post::where('slug', $slug)->first();

            if ($data) {
                $response =  $this->sendSuccess('Login successfully done.',  $data);
            } else {
                $response =  $this->sendError(401, 'There is no data');
            }

        } catch (Exception $e) {
            $response = $this->sendError(99, 'Something went wrong.',$e->getMessage());
        }
        return $response;
    }

    /*public function store(Request $request)
    {
        if (!$request->isMethod('POST')) {
            return response()->json(['status' => false, 'code' => 901, 'message' => 'Invalid request method'], 401);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'no' => 'required',
            'type_id' => 'required',
            'ip_wise' => 'required',
            'mac_wise' => 'required',
            'active_yn' => 'required',
        ]);

        if ($validator->fails()) {
            foreach ($validator->messages()->getMessages() as $messages) {
                return response()->json(['status' => false, 'code' => 902, 'message' => $messages[0]], 401);
            }
        } else {
            try {
                $data = $this->boothManager->storeUpdate(null, $request, auth()->user()->data());
                if ($data['o_STATUS_CODE'] == 1) {
                    return response()->json(['status' => true, 'code' => 1, 'message' => $data['o_STATUS_MESSAGE'], 'data' => array_change_key_case($data, CASE_LOWER)], Response::HTTP_ACCEPTED);
                } else {
                    return response()->json(['status' => false, 'code' => 999, 'message' => $data['o_STATUS_MESSAGE']], 401);
                }
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
            return response()->json(['status' => false, 'code' => 999, 'message' => 'Something went wrong.','error'=>$error], 401);
        }
    }

    public function show(Request $request, $id)
    {
        if (!$request->isMethod('GET')) {
            return response()->json(['status' => false, 'code' => 901, 'message' => 'Invalid request method'], 401);
        }
        try {
            $data = BoothInfo::where('booth_id',$id)->with(['counters'])->first();
            if ($data) {
                $response = response()->json(['status' => true, 'code' => 1, 'message' => 'Data found.', 'data' => $data], Response::HTTP_ACCEPTED);
            } else {
                $response = response()->json(['status' => false, 'code' => 801, 'message' => 'There is no data'], 401);
            }

        } catch (Exception $e) {
            $error = $e->getMessage();
            $response = response()->json(['status' => false, 'code' => 999,'message' => 'Something went wrong.','error'=>$error], 401);
        }
        return $response;
    }

    public function update(Request $request, $id)
    {
        if (!$request->isMethod('PUT')) {
            return response()->json(['status' => false, 'code' => 901, 'message' => 'Invalid request method'], 401);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'no' => 'required',
            'type_id' => 'required',
            'ip_wise' => 'required',
            'mac_wise' => 'required',
            'active_yn' => 'required',
        ]);

        if ($validator->fails()) {
            foreach ($validator->messages()->getMessages() as $messages) {
                return response()->json(['status' => false, 'code' => 902, 'message' => $messages[0]], 401);
            }
        } else {
            try {
                $data = $this->boothManager->storeUpdate($id, $request, auth()->user()->data());
                if ($data['o_STATUS_CODE'] == 1) {
                    return response()->json(['status' => true, 'code' => 1, 'message' => $data['o_STATUS_MESSAGE'], 'data' => array_change_key_case($data, CASE_LOWER)], Response::HTTP_ACCEPTED);
                } else {
                    return response()->json(['status' => false, 'code' => 999, 'message' => $data['o_STATUS_MESSAGE']], 401);
                }
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
            return response()->json(['status' => false, 'code' => 999, 'message' => 'Something went wrong.','error'=>$error], 401);
        }
    }

    public function destroy(Request $request, $id)
    {
        return response()->json(['status' => false, 'code' => 901, 'message' => 'Procedure not done yet. Need to do.'], 401);

        if (!$request->isMethod('PUT')) {
            return response()->json(['status' => false, 'code' => 901, 'message' => 'Invalid request method'], 401);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'address' => 'required',
            'division_id' => 'required',
            'district_id' => 'required',
            'thana_id' => 'required',
            'active_yn' => 'required',
        ]);

        if ($validator->fails()) {
            foreach ($validator->messages()->getMessages() as $messages) {
                return response()->json(['status' => false, 'code' => 902, 'message' => $messages[0]], 401);
            }
        } else {
            try {
                $data = $this->boothManager->storeUpdate($id, $request, auth()->user()->data());
                if ($data['o_STATUS_CODE'] == 1) {
                    return response()->json(['status' => true, 'code' => 1, 'message' => $data['o_STATUS_MESSAGE'], 'data' => array_change_key_case($data, CASE_LOWER)], Response::HTTP_ACCEPTED);
                } else {
                    return response()->json(['status' => false, 'code' => 999, 'message' => $data['o_STATUS_MESSAGE']], 401);
                }
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
            return response()->json(['status' => false, 'code' => 999, 'message' => 'Something went wrong.','error'=>$error], 401);
        }
    }


    public function getInspectionBooth(Request $request)
    {
        if(!$request->isMethod('GET'))
        {
            return response()->json(['status' => false, 'code' => 999, 'message' => 'Invalid request method'], 401);
        }


        try{
            $data = BoothInfo::with(['counters'])->where('booth_type_id',2)->get();

            if ($data) {
                return response()->json(['status' => true, 'code' => 1, 'message' => 'Data found.', 'data' => $data], Response::HTTP_ACCEPTED);
            } else {
                return response()->json(['status' => false, 'code' => 801, 'message' => 'There is no data'], 401);
            }
        }catch(Exception $e)
        {
            $error = $e->getMessage();
            return response()->json(['status' => false, 'code' => 999, 'message' => 'Something went wrong.','error'=>$error], 401);
        }
    }*/


}
