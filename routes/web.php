<?php


Route::get('knet/request', function(\Illuminate\Http\Request $request){
    return
        KNet::request()
        ->addParam('amt', $request->get('amount'))
        ->addParam('trackid', $request->get('track_id',mt_rand()))
        ->url();

});
Route::post('knet', function(\Illuminate\Http\Request $request){
  return new \DeveloperH\Knet\SDK\Response($request);
});
Route::get('knet', function(\Illuminate\Http\Request $request){
  return new \DeveloperH\Knet\SDK\Response($request);
});
