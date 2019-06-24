<?php


namespace DeveloperH\Knet\SDK;


use Config;

class Request extends Client
{

    public $params='';

    public function __construct()
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

    public function addParam($key, $value){
        $this->params.="&{$key}={$value}";
        return $this;
    }

    public function url()
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


}
