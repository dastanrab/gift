<?php

namespace App\Http\Controllers;

use App\Imports\ExelImport;
use App\Models\blog;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Tag;
use Symfony\Component\Console\Input\Input;

class ImportExcel extends Controller
{
    //
    public function import(Request $request)
    {
        if($request->has('tag_name'))
        {
            if ($request->hasFile('select_file')) {

                $array=[];
                $errors=[];

                $rows=Excel::toCollection(new ExelImport(), $request->file('select_file'));
                foreach ($rows[0] as $row)
                {
                   // $data=explode(' ',$row->title_cardnumber_pin);
                   //array_push($array,$data);
                 //   $validator=Validator::make($row, [
                       // 'id' => 'required',
                    //    'sum' => 'required',
                     //   'phone' => 'required',
                  //  ]);
                  //  if ($validator->passes()) {
                      //  array_push($array,$row['id']);
                   // } else {

                    //    array_push($errors,[$row['id'],$validator->errors()->all()]);
                  //  }

                }
                return response()->json($rows);
            }

            else{

                return response()->json(["rows" => "فایل مورد نظز یافت نشد"]);
            }
        }
        else{
            return response()->json("نام دسته بندی الزامی است.");
        }


        }
    public function GetImage($id=null){
       if ($id!=null) {
           if (is_numeric($id)){
               $tag=Tag::find($id);
               if ($tag){
                   if(Storage::disk('local')->exists($tag->image))
                   {
                       $content = Storage::disk('local')->get($tag->image);

                       return response($content)->header('Content-Type','image/jpeg');
                   }
                   else{
                       return response()->json("nothing find");
                   }
               }
               else{
                   return response()->json("موردی یافت نشد");
               }
           }
           else{
               return response()->json("only number");
           }
       }
       else{
           return response()->json("its important");
       }


    }
    public function GetCImage($id=null){
        if ($id!=null) {
            if (is_numeric($id) and $id!=0){
                $country=Country::find($id);
                if ($country){
                    if(Storage::disk('local')->exists($country->image))
                    {
                        $content = Storage::disk('local')->get($country->image);

                        return response($content)->header('Content-Type','image/jpeg');
                    }
                    else{
                        return response()->json("nothing find");
                    }
                }
                else{
                    return response()->json("موردی یافت نشد");

                }
            }
            else{
                return response()->json("فقط عدد");
            }
        }
        else{
            return response()->json("its important");
        }


    }
    public function GetBImage($id=null){
        if ($id!=null) {
            if (is_numeric($id) and $id!=0){
                $blog=blog::find($id);
                if ($blog){
                    if(Storage::disk('local')->exists($blog->image))
                    {
                        $content = Storage::disk('local')->get($blog->image);

                        return response($content)->header('Content-Type','image/jpeg');
                    }
                    else{
                        return response()->json("nothing find");
                    }
                }
                else{
                    return response()->json("موردی یافت نشد");

                }
            }
            else{
                return response()->json("فقط عدد");
            }
        }
        else{
            return response()->json("its important");
        }


    }


}
