<?php


Route::post('knet/request', function(){
    dd((new \DeveloperH\Knet\SDK\Request())->addParam('amt', 100)->addParam('trackid', mt_rand())->url());
    echo 'Hello from the KNet package!';
});
Route::post('knet', function(\Illuminate\Http\Request $request){
  return new \DeveloperH\Knet\SDK\Response($request);
});
