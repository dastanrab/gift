<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Traits\phone_validate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;


class UserManage extends Controller
{
    //
    use phone_validate;
    public function getphone($phone=null){

       return  $this->check($phone);
    }
    public function smscheck(Request $request){
        $customMessages = [
            'required' => 'وجود این فیلد ضروری می باشد',
            'digits' => 'عدد را نا مناسب وارد کردید'
        ];
        $rules = [
        'token' => 'required|digits:5',
    ];
        $validator = Validator::make($request->only(['token']), $rules,$customMessages);
         if ($validator->passes()) {

             if (Redis::exists($request->input('token'))){
                 $data=json_decode(Redis::get($request->input('token')));
                 $user=new User();
                 $user=$user->where('phone','=',$data->phone)->first();
                 if (Auth::loginUsingId($user->id)){
                     $authUser = Auth::user();
                     $authUser->tokens->each(function($token, $key) {
                         $token->delete();
                     });
                     $token=$authUser->createToken('MyAuthApp')->plainTextToken;
                     return response()->json($token);
                 }
                 else{
                     return response()->json("خطا در وزود");
                 }

             }
             else{
                 return response()->json('رمز عبور نادرست است');
             }


         } else {
          return response()->json($validator->errors()->all());
          }


    }
}
