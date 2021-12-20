<?php

//use App\Models\Product as kala;
//use App\Models\Tag;

//views
// $offs=DB::table('products')->join('tags','products.tag_id','=','tags.id')
//  ->join('credits','products.credit_id','=','credits.id')
//   ->join('offers','products.offer_id','=','offers.id')
//   ->select(['products.id','products.name','products.price','products.total_vote','products.total_avg','products.tag_id','tags.name as tag_name','tags.country','tags.image','credits.type','credits.time','offers.off','offers.offer_hour'])
//   ->orderByDesc('offers.off');
// $prices=$prices->orderByDesc('price')->groupBy('price')->pluck('price')->get();
//$offs=Offer::has('products')->with(['products'
// ,'products.tag','products.credit'])->where('id','<>',1)->orderByDesc('off')->get();
//public function v1(){

    //$tags=Tag::all();


    //$fav=kala::with(['credit','tag','offer'])->orderByDesc('total_avg')->take(6)->get();

    // ->select('tags.name',DB::raw('count(tags.name) as total'))->groupBy('tags.name')->get();


//}
// $fav_tags=DB::table('products')->join('tags','tags.id',"=",'products.tag_id')->orderByDesc('products.total_avg')->select(['products.tag_id','tags.name','tags.country'])->distinct()->take(4)->get();

//public function extra(){
    //$sabad=[1=>3,2=>3,4=>1,8=>7];
  //  $k=1;
    //با لاراول
  //  $c=collect($sabad);
  //  $new = $c->map(function ($item, $key) use($k){
    //    if ($key == $k){
        //    return $item+1;
      //  }
      //  else{
      //      return $item;
     //   }
   // });
    //با php
  //  if (array_key_exists($k,$sabad)){
   //     $sabad[$k]++;
   // }
  //  return response()->json(['laravel'=>$new->all(),'php'=>$sabad]);
//}
//}
