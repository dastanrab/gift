<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class cart extends Controller
{
    //
    public function show(Request $request){
        $ip=$request->ip();
        if (!Redis::exists($ip))
        {
            return response()->json('شما سبدی ندارید');
        }
        else{
            $data=unserialize(Redis::get($ip));
            $now=Carbon::now();
            $basket=[];
            $total=0;

            if (!is_null($data)){
                foreach ($data as $key => $value){
                    $p=\App\Models\Product::select('id','name','price','tag_id')->with(['offer'=> function($q) use($now){
                        $q->where('finish','>',$now->setDate(2021,10,3));
                    }])->where('id','=',$key)->first();
                    if ($p){
                        $s=collect($p);
                        if (is_null($p->offer)){
                            $item=$s->put('quantity',$value)->put('price_with_off',$p->price)->put('total',$p->price*$value);
                            $total+=($p->price*$value);
                        }
                        else{

                            $off_price=($p->price*(100-$p->offer->off))/100;
                            $item=$s->put('quantity',$value)->put('price_with_off',$off_price)->put('total',$off_price*$value);
                            $total+=($off_price*$value);
                        }


                        array_push($basket,$item);
                    }
                    else{
                        session()->forget('cart.'.$key);
                    }
                }
                //$serial=serialize($data);
                //unserialize($serial)
                return response()->json(['basket'=>$basket,'total'=>$total]);
            }
            else{
                return response()->json("سبد خالی است");
            }
        }

    }
    public function increase(Request $request,$id){
        $ip=$request->ip();
        if (!is_null($ip)){
           if (\App\Models\Product::find($id)) {
               if (!Redis::exists($ip))
               {
                   $basket=[];
                   $basket[$id]=1;
                   Redis::setex($ip,1800, serialize($basket)
                   );
                   Redis::bgSave();
                   return response()->json("محصول به سبد اضافه شد");

               }
               else{
                   $arr=unserialize(Redis::get($ip));
                   if (isset($arr[$id])){
                       $arr[$id]++;
                       Redis::setex($ip,1800,serialize($arr));
                       Redis::bgSave();
                       return response()->json("به تعداد محصول اضافه شد");
                   }
                   else{
                       $arr[$id]=1;
                       Redis::setex($ip,1800, serialize($arr)
                       );
                       Redis::bgSave();
                       return response()->json("محصول اضافه شد");
                   }

               }
           }
           else{
               if (Redis::exists($ip)){
                   $arr=unserialize(Redis::get($ip));
                   if (isset($arr[$id])){
                       unset($arr[$id]);
                       if (count($arr)<=0){
                           Redis::del($ip);
                           return response()->json('سبد شما خالی شد');
                       }
                       else{
                           Redis::setex($ip,1800, serialize($arr)
                           );
                           Redis::bgSave();
                           return response()->json(' محصول مورد نظز یافت نشد و سبد بروز زسانی شد');
                       }
                   }
                   else{
                       return response()->json(' محصول مورد نظز یافت نشد');
                   }
               }
               else{
                   return response()->json(' محصول مورد نظز یافت نشد و سبد شما خالی است');
               }
           }
        }
        else{
            return response()->json('ای پی صحیح نیست');
        }

    }
    public function decrements(Request $request,$id){
        $ip=$request->ip();
        if (!is_null($ip)){
            if (\App\Models\Product::find($id)) {
                if (!Redis::exists($ip))
                {
                    return response()->json('شما سبدی ندارید');
                }
                else{
                    $basket=unserialize(Redis::get($ip));
                    if (isset($basket[$id])){
                        $basket[$id]--;
                        if ($basket[$id]<=0){
                            unset($basket[$id]);
                            if (count($basket)<=0){
                                Redis::del($ip);
                                return response()->json('سبد شما خالی شد');
                            }
                            else{
                                Redis::setex($ip,1800, serialize($basket)
                                );
                                Redis::bgSave();
                                return response()->json(' تعداد محصول مورد نظر کم شد');
                            }
                        }
                        else{
                            Redis::setex($ip,1800, serialize($basket)
                            );
                            Redis::bgSave();
                            return response()->json(' تعداد محصول مورد نظر کم شد');
                        }

                    }
                    else{
                        return response()->json('محصول یافت نشد');
                    }
                }
            }
            else{
                if (Redis::exists($ip)){
                    $arr=unserialize(Redis::get($ip));
                    if (isset($arr[$id])){
                        unset($arr[$id]);
                        if (count($arr)<=0){
                            Redis::del($ip);
                            return response()->json('سبد شما خالی شد');
                        }
                        else{
                            Redis::setex($ip,1800, serialize($arr)
                            );
                            Redis::bgSave();
                            return response()->json(' محصول مورد نظز یافت نشد و سبد بروز زسانی شد');
                        }
                    }
                    else{
                        return response()->json(' محصول مورد نظز یافت نشد');
                    }
                }
                else{
                    return response()->json(' محصول مورد نظز یافت نشد و سبد شما خالی است');
                }
            }
        }
        else{
            return response()->json('ای پی صحیح نیست');
        }
    }
    public function flush(Request $request){
        $ip=$request->ip();
        if (!is_null($ip)){
            if (Redis::exists($ip)){
                Redis::del($ip);
                return response()->json("سبد خالی شد");
            }
            else{
                return response()->json("شما سبدی ندارید");
            }

        }
        else{
            return response()->json('ای پی صحیح نیست');
        }

    }
    public function delete(Request $request,$id){
        $ip=$request->ip();
        if (!is_null($ip)){

            if (!Redis::exists($ip))
            {
                return response()->json('شما سبدی ندارید');
            }
            else{
                $basket=unserialize(Redis::get($ip));
                if (isset($basket[$id])){
                    unset($basket[$id]);
                    if (count($basket)<=0){
                        Redis::del($ip);
                        return response()->json('سبد شما خالی شد');
                    }
                    else{
                        Redis::setex($ip,1800, serialize($basket)
                        );
                        Redis::bgSave();
                        return response()->json('محصول مورد نظر حذف شد');
                    }
                }
                else{
                    return response()->json('محصول یافت نشد');
                }
            }

        }
        else{
            return response()->json('ای پی شما مشخص نیست');
        }
    }
}
