<?php
/**
 * Created by PhpStorm.
 * User: jhh
 * Date: 2018/10/23
 * Time: 11:14
 */

namespace App\Services\External\Tencent;
use Curl\Curl;
use Cache;


class TencentCaptcha
{
    private $appid;

    private $appSecretKey;

    private $url = "https://ssl.captcha.qq.com/ticket/verify";

    public function __construct($config)
    {
        $this->appid        = $config['appid'];
        $this->appSecretKey = $config['appSecretKey'];
    }

    /**
     * 校验验证码
     * @param string $ticket 验证码ticket
     * @param string $randStr 验证码randstr
     * @param string $userIp 用户请求ip
     * @return array
     */
    public function checkCaptcha($ticket,$randStr,$userIp)
    {
        $params = array(
            "aid" => $this->appid,
            "AppSecretKey" => $this->appSecretKey,
            "Ticket" => $ticket,
            "Randstr" => $randStr,
            "UserIP" => $userIp
        );
        $paramstring = http_build_query($params);
        $content = $this->_txcurl($this->url,$paramstring);
        \Log::info($content);
        $result = json_decode($content,true);
        if($result){
            if($result['response'] == 1){
                return ['status'=>1,'message'=>'请求失败'];
            }else{
                return ['status'=>0,'message'=>$result['response'].":".$result['err_msg']];
            }
        }else{
            \Log::ERROR('腾讯验证码请求失败');
            return ['status'=>0,'message'=>'请求失败'];
        }
    }

    /**
     * 腾讯方提供的curl方法
     * @param $url
     * @param bool $params
     * @param int $isPost
     * @return bool|mixed
     */
    public function _txcurl($url, $params = false, $isPost = 0)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HTTP_VERSION , CURL_HTTP_VERSION_1_1 );
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT , 60 );
        curl_setopt($ch, CURLOPT_TIMEOUT , 60);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER , true );
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //不验证证书下同
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        if( $isPost )
        {
            curl_setopt( $ch , CURLOPT_POST , true );
            curl_setopt( $ch , CURLOPT_POSTFIELDS , $params );
            curl_setopt( $ch , CURLOPT_URL , $url );
        }
        else
        {
            if($params){
                curl_setopt( $ch , CURLOPT_URL , $url.'?'.$params );
            }else{
                curl_setopt( $ch , CURLOPT_URL , $url);
            }
        }
        $response = curl_exec( $ch );
        curl_close( $ch );
        return $response;
    }

}