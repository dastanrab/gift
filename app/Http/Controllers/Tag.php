<?php

namespace App\Http\Controllers;

use App\Http\Requests\TagRules;
use App\Http\Requests\updateTag;
use App\Models\Country;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use App\Models\Tag as T;

use App\Models\Product;
use Intervention\Image\Facades\Image;

class Tag extends Controller
{
    //
    public function index(): string
    {


        if (T::has('product')->first()){

            return response()->json(T::with(['product'])->get());
        }
        else{
            return response()->json('false');
        }

    }
    public function add_show(){
        $countries=new Country();
        $countries=$countries->setVisible(['id','name']);
        $countries=$countries->select(['id','name'])->get();
        $tags_name=new T();
        $tags_name=$tags_name->select('name')->distinct()->get();
        return response()->json(['country'=>$countries,'tag'=>$tags_name]);
    }
    public function add(TagRules $request){

      if(!T::where('name',$request->input('name'))->where('country_id',$request->input('country_id'))->first()){
          if($request->hasFile('image')){
              $file=$request->file('image');
              $name=time().".".$file->extension();
              $img=Image::make($file->getRealPath());
              $img->resize(400, 400, function ($constraint) {
                  $constraint->aspectRatio();
              });
              if(Storage::disk('local')->put('/tags/'.$name,  (string) $img->encode(), 'public')){

                  if ($tag = T::create([
                      'name' => $request->input('name'),
                      'country_id'=>$request->input('country_id'),
                      'image'=> '/tags/'.$name
                  ])){
                      return response()->json(['status'=>'ذخیره شد','tag'=>$tag]);
                  }
                  else{
                      return response()->json(['status'=>'خطا در ذخیره سازی']);
                  }

              }
              else{
                  return response()->json('خطا در ذخیره سازی');
              }
          }

      }
      else{
          return response()->json("its exist");
      }
    }
    public function destroy($id = null): JsonResponse
    {
        if ($id==null)
        {
            return response()->json('لطفا id مورد نظر را باور کنید');
        }
        else{
            $tag=T::find($id);
            if($tag){
                $product=Product::where('tag_id','=',$id)->first();
                if ($product){
                    return response()->json("این دسته در چند محصول استفاده شده و قابل حذف نیست");
                }
                else{
                    if(Storage::disk('local')->exists($tag->image))
                    {
                        if (Storage::disk('local')->delete($tag->image))
                        {
                            if ($tag->delete() ){

                                return response()->json("حذف شد");
                            }
                            else{
                                return response()->json("اشکال در حذف از جدول");
                            }

                        }
                        else{

                            return response()->json("اشکال در حذف فایل");
                        }
                    }
                    else{
                        if ( $tag->delete() ){
                            return response()->json("حذف شد");
                        }
                        else{
                            return response()->json("اشکال در حذف از جدول");
                        }
                    }
                }


            }
            else{
                return response()->json("مورد یافت نشد");
            }
        }

    }
    public function update(updateTag $request){
        $tag=T::find($request->input('id'));
        if ($tag){

            if ($request->input('name')!=null or $request->input('name')!=0 ){
                $tag->name=$request->input('name');
            }
            if ( $request->input('country_id')!=null or $request->input('country_id')!=0 ){
                $tag->country_id=$request->input('country_id');
            }
            $find=T::where('name',$tag->name)->where('country_id',$tag->country_id)->first();
            if(!$find or $find->id==$tag->id){
                if ($request->hasFile('image')){
                    if(Storage::disk('local')->exists($tag->image))
                    {
                        if (Storage::disk('local')->delete($tag->image))
                        {
                            $file=$request->file('image');
                            $name=time().".".$file->extension();
                            $img=Image::make($file->getRealPath());
                            $img->resize(400, 400, function ($constraint) {
                                $constraint->aspectRatio();
                            });
                            //->stream()
                            if(Storage::disk('local')->put('/tags/'.$name,  (string) $img->encode(), 'public')){
                                $tag->image='/tags/'.$name;
                            }

                        }
                        else{

                            return response()->json("اشکال در حذف فایل");
                        }
                    }
                    else{
                        $file=$request->file('image');
                        $name=time().".".$file->extension();
                        $img=Image::make($file->getRealPath());
                        $img->resize(400, 400, function ($constraint) {
                            $constraint->aspectRatio();
                        })->stream();
                        if(Storage::disk('local')->put('/tags/'.$name, $img, 'public')){
                            $tag->image='/tags/'.$name;
                        }
                    }
                }

                if ($tag->save()){

                    return response()->json("انجام شد") ;
                }
            }
            else{
                return response()->json("این مورد موجود است") ;
            }

        }
        else{

            return response()->json("دسته بندی مورد نظز یافت نشد");
        }


    }
}
