<?php


namespace DeveloperH\Knet\SDK;


use Config;

class Response
{
    /**
     * @var \Request
     */
    private $request;
    private $result=[];

    /**
     * Response constructor.
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(\Illuminate\Http\Request $request)
    {
        $this->request = $request;
        $ResTranData=$request->get('trandata');
        $decryptedData=explode('&',$this->decrypt($ResTranData,Config::get('knet.resource_key')));
        foreach ($decryptedData as $datum){
            $temp=explode('=',$datum);
            if(isset($temp[1])){
                if($temp[0]=='result'){
                    $temp[1]=implode(' ',explode('+',$temp[1]));
                    $this->result['paid']=$temp[1]=='CAPTURED';
                }

                $this->result[$temp[0]]=$temp[1];
            }

        }
    }

    public function __toString()
    {
        return json_encode($this->result);
    }

    public function toArray()
    {
        return $this->result;
    }

    function decrypt($code,$key) {
        $code =  $this->hex2ByteArray(trim($code));
        $code=$this->byteArray2String($code);
        $iv = $key;
        $code = base64_encode($code);
        $decrypted = openssl_decrypt($code, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $iv);
        return $this->pkcs5_unpad($decrypted);
    }

    function hex2ByteArray($hexString) {
        $string = hex2bin($hexString);
        return unpack('C*', $string);
    }


    function byteArray2String($byteArray) {
        $chars = array_map("chr", $byteArray);
        return join($chars);
    }


    function pkcs5_unpad($text) {
        $pad = ord($text{strlen($text)-1});
        if ($pad > strlen($text)) {
            return false;
        }
        if (strspn($text, chr($pad), strlen($text) - $pad) != $pad) {
            return false;
        }
        return substr($text, 0, -1 * $pad);
    }
}
