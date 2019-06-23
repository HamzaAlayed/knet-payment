<?php


namespace DeveloperH\Knet\SDK;


use Config;

class Request
{

    public $params='';

    function __construct()
    {
        $this
            ->addParam('id', Config::get('knet.transport_id'))
            ->addParam('password', Config::get('knet.transport_password'))
            ->addParam('action', Config::get('knet.action_code'))
            ->addParam('langid', Config::get('knet.language'))
            ->addParam('currencycode', Config::get('knet.currency'))
            ->addParam('responseURL', Config::get('knet.response_url'))
            ->addParam('errorURL', Config::get('knet.error_url'));
    }

    function addParam($key, $value){
        $this->params.="&{$key}={$value}";
        return $this;
    }

    function url()
    {

        $url=Config::get('knet.development_url');

        if (strtolower(Config::get('app.env')) == 'production') {
            $url= Config::get('knet.production_url');
        }
        $encrypt=$this->encryptAES(substr($this->params, 1),Config::get('knet.resource_key'));
        $this->params='';
        $this
            ->addParam('param', 'paymentInit')
            ->addParam('trandata', $encrypt)
            ->addParam('tranportalId', Config::get('knet.transport_id'))
            ->addParam('responseURL', Config::get('knet.response_url'))
            ->addParam('errorURL', Config::get('knet.error_url'));
        return $url."?{$this->params}";
    }

    function encryptAES($str, $key)
    {
        $str = $this->pkcs5_pad($str);
        $encrypted = openssl_encrypt($str, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $key);
        $encrypted = base64_decode($encrypted);
        $encrypted = unpack('C*', ($encrypted));
        $encrypted = $this->byteArray2Hex($encrypted);
        $encrypted = urlencode($encrypted);
        return $encrypted;
    }

    function pkcs5_pad($text)
    {
        $blocksize = 16;
        $pad = $blocksize - (strlen($text) % $blocksize);
        return $text . str_repeat(chr($pad), $pad);
    }

    function byteArray2Hex($byteArray)
    {
        $chars = array_map("chr", $byteArray);
        $bin = join($chars);
        return bin2hex($bin);
    }
}
