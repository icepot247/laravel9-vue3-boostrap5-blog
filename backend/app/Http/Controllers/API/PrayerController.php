<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class PrayerController extends BaseController
{

    public function index(Request $request)
    {
        try{
            $user = $request->user()->data();
            return $this->sendSuccess('Data found.', $request->user()->data());
        }catch (\Exception $e){
            return $this->sendError(99, 'Something went wrong. Please try again later', $e->getMessage());
        }

    }




}
