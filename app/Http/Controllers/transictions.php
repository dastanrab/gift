<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class transictions extends Controller
{
    //
    function index(){
        DB::beginTransaction();
        try {
           //something done here
        }catch (\Exception $exception){
            DB::rollBack();
            return $exception->getMessage();
        }
        DB::commit();
    }
}
