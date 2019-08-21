<?php

namespace DeveloperH\Knet\SDK;

use Config;

class Response extends Client
{
    /**
     * @var \Illuminate\Http\Request
     */
    private $request;
    private $result = [];

    /**
     * Response constructor.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(\Illuminate\Http\Request $request)
    {
        $this->request = $request;
        $ResTranData = $request->get('trandata');
        if ($ResTranData) {
            $decryptedData = explode('&', $this->decrypt($ResTranData, Config::get('knet.resource_key')));
            foreach ($decryptedData as $datum) {
                $temp = explode('=', $datum);
                if (isset($temp[1])) {
                    if ($temp[0] == 'result') {
                        $temp[1] = implode(' ', explode('+', $temp[1]));
                        $this->result['paid'] = $temp[1] == 'CAPTURED';
                    }

                    $this->result[$temp[0]] = $temp[1];
                }
            }

            return true;
        }
        $this->result = explode('-', $this->request->get('ErrorText'));

        return false;
    }

    public function __toString()
    {
        return json_encode($this->result);
    }

    public function toArray()
    {
        return $this->result;
    }
}
