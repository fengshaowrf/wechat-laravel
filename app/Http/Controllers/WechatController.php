<?php

namespace App\Http\Controllers;

use App\Events\Wechat\ActionEvent;
use App\Events\Wechat\TextEvent;
use EasyWeChat\Foundation\Application;
use Illuminate\Support\Facades\Request;


class WechatController extends Controller
{

    /**
     * @var Application $app
     */
    protected $app;

    /**
     * WechatController constructor.
     *
     * @param Application $app
     */
    public function __construct(Application $app){
        $this->app = $app;
    }

    public function index()
    {
        $server = $this->app->server;
        if(Request::isMethod('post')){
            event(new TextEvent($server));//监听文本消息
            event(new ActionEvent($server));//监听事件消息
        }
        $content = $server->serve()->getContent();
        if($content=='success' || !$content){
            self::forward(config('wechat.forward_url'),config('wechat.forward_token'),$server->getMessage()['ToUserName']);
        }
        return $server->serve();
    }

    public static function forward($url, $token, $toUserName, $openid = "")
    {
        if(!$url) return false;
        $data = file_get_contents("php://input");
        $time = isset($_GET['timestamp']) ? $_GET['timestamp'] : time();
        $nonce = isset($_GET["nonce"]) ? $_GET["nonce"] : '';
        $signature = self::getSignature($token, '', $time, $nonce);
        $url = $url . "&signature=" . $signature . "&timestamp=" . $time . "&nonce=" . $nonce;
        $result = self::http_post($url, $data);
        $result_xml = simplexml_load_string($result, 'SimpleXMLElement', LIBXML_NOCDATA);
        if (empty($result_xml)) return false;
        if ($result_xml['ToUserName'] == $toUserName) {
            return $result;
        }
        echo $result;
        return false;
    }

    /**
     * POST 请求
     * @param string $url
     * @param array $param
     * @param boolean $post_file 是否文件上传
     * @return string content
     */
    private static function http_post($url, $param, $post_file = false)
    {
        $oCurl = curl_init();
        if (stripos($url, "https://") !== false) {
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($oCurl, CURLOPT_SSLVERSION, 1); //CURL_SSLVERSION_TLSv1
        }
        if (is_string($param) || $post_file) {
            $strPOST = $param;
        } else {
            $aPOST = array();
            foreach ($param as $key => $val) {
                $aPOST[] = $key . "=" . urlencode($val);
            }
            $strPOST = join("&", $aPOST);
        }
        curl_setopt($oCurl, CURLOPT_URL, $url);
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($oCurl, CURLOPT_POST, true);
        curl_setopt($oCurl, CURLOPT_POSTFIELDS, $strPOST);
        $sContent = curl_exec($oCurl);
        $aStatus = curl_getinfo($oCurl);

        curl_close($oCurl);
        if (intval($aStatus["http_code"]) == 200) {
            return $sContent;
        } else {
            return false;
        }
    }


    private static function getSignature($token = "", $str = '', $time, $nonce)
    {
        $timestamp = $time;
        $tmpArr = array($token, $timestamp, $nonce, $str);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);
        return $tmpStr;
    }
}
