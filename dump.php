<?php

use Illuminate\Support\Facades\DB;

$top=DB::table('products')->join('tags','products.tag_id','=','tags.id')
    ->join('credits','products.credit_id','=','credits.id')
    ->select(['products.id','products.name','products.price','products.total_vote','products.total_avg','products.total_sold','products.tag_id','tags.name as tag_name','tags.country','tags.image','credits.type','credits.time'])
    ->orderByDesc('products.total_sold');
if ($id==null){
    $top=$top->take(30)->get();
    return response()->json(['tops'=>$top]);
}
elseif(!is_numeric($id)){
    $top=$top->take(30)->get();
    return response()->json(['tops'=>$top]);
}
else{
    $top=$top->take($id)->get();
    return response()->json(['tops'=>$top]);
}
