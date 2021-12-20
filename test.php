<?php
use App\Models\Tag as T;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
//use App\Models\User;
//use App\Models\Product as P;
Route::middleware('auth:sanctum')->get('test',function (){

    $products = T::has('product')->with(['product' => function($q){
        $q->withCount('codes');
    }])->get();
    return response()->json($products);

});
Route::middleware('auth:sanctum')->get('check',function (){
    $user=User::where('phone','09388985617')->first();

    if ($user)
    {

        if(Auth::loginUsingId($user->id)){
            $authUser = Auth::user();
            $token=$authUser->createToken('MyAuthApp')->plainTextToken;
            return response()->json($token);
        }
        else{

            return "baddd";
        }


    }
    else{
        return "fail";
    }

});
Route::middleware('auth:sanctum')->get('test',function (){
    $user=User::has('reviews')->with(['reviews','reviews.product'])->withCount('reviews')->get();
    return response()->json($user);
});

Route::middleware('auth:sanctum')->post('ajax',function (Request $request){
    $customMessages = [

        'required' => 'وجود این فیلد ضروری می باشد',
        'numeric' => 'عدد را نا مناسب وارد کردید'
    ];
    $rules = [
        'p_id' => 'required|numeric',
        'off' => 'Integer|Nullable',
        'date' => 'Nullable|date_format:Y-m-d',
        'time'=> 'Integer|Nullable',
        'one_day'=>'boolean|Nullable'

    ];
    $validator = Validator::make($request->only(['off','time','p_id','date','one_day']), $rules,$customMessages);
    if ($validator->passes()){
        // $dt = Carbon::now();
        // $date=new DateTime($request->input('date'));
        // return response()->json($dt->diff($date));
        if ($request->has('one_day') and $request->input('one_day')==true){
            return "its true";
        }
        else{
            return "its false";
        }
    }
    else{
        return response()->json($validator->errors()->all());
    }

    //return response()->json($request->input('date'));

});
Route::middleware('auth:sanctum')->get('timezone',function (){
    // return date_default_timezone_get();
    // $user=new User();
    //  $expire=new Carbon('2021-10-19');
    //  $user->where('created_at','<',$expire)->delete();
    $now=Carbon::now();
    //تا پایان روز
    //$expire=new Carbon('2021-10-22');
    //  $expire->setTime(23,59,59);
    //ساعتی
    //  $expire=Carbon::now();
    // $expire=new Carbon('2021-10-22');
    // $time=11;
    //if(24-$now->hour > $time){
    //   $expire->setTime($now->hour,$now->minute,$now->second)->addHour($time);
    //   return response()->json($expire->toDateTime());
    // }
    //else {
    //    $expire->day += 1;
    //  $expire->setTime($time - (24 - $now->hour), $now->minute, $now->second);
    //   return response()->json($expire->toDateTime());
    //  }
    //روزانه
    $expire=new Carbon('2021-10-25');
    if ($expire->toDateString()<=$now->toDateString() ){
        return response()->json('نباید با تاریخ امروز یکی باشد' );

    }
    else{
        $expire->setTime($now->hour,$now->minute,$now->second);
        $offer=new \App\Models\Offer();
        $offer->off=50;
        $offer->product_id=39;
        $offer->finish=$expire;
        $offer->save();
        return "ok";
    }

});
