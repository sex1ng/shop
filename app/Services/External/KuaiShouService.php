<?php


namespace App\Services\External;


use Curl\Curl;
use Exception;

class KuaiShouService
{

    private $miniProgram;

    public function __construct($config)
    {
        $this->miniProgram = $config;
    }

    /**
     * 根据code获取用户信息
     * @param $code
     * @return array|mixed
     */
    public function getUserInfoByCode($code)
    {
        $app    = $this->miniProgram;
        $url    = 'https://open.kuaishou.com/oauth2/mp/code2session';
        $params = array_merge(['js_code' => $code], $app);
        try {
            $curl = new Curl();
            $curl->setHeader('Content-Type', 'application/x-www-form-urlencoded');
            $curl->post($url, $params);
            $res = json_decode($curl->response, true);
            $curl->close();
        } catch (Exception $e) {
            return [];
        }

        return $res;
    }

}