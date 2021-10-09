<?php
	header('Content-Type:text/html;charset=utf-8');
	error_reporting(E_ALL);
	include_once('Wechat.class.php');
	define("TOKEN", "weixin");
    // echo 111;
    // exit;
	$wechatObj = new wechatCallbackapiTest();
	if (!isset($_GET['echostr'])) {
	    $wechatObj->responseMsg();
	}else{
	    $wechatObj->valid();
	}
	//自定义菜单
	$appid='wx1c5c585786725e27';
	$appsecret='64bf7ae6e5b8496da0aebefc0f17f8e2';

	// 1.获得access_token的值
	$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";
	$output = https_request($url);
	$jsoninfo = json_decode($output, true);
	$access_token = $jsoninfo["access_token"];

	// 2.设置自定义菜单的内容
	$jsonmenu = '{
      "button":[
      {
            "name":"天气预报",
           	"sub_button":[
            {
               "type":"click",
               "name":"广州天气",
               "key":"天气广州"
            },
            {
               "type":"click",
               "name":"深圳天气",
               "key":"天气深圳"
            },
            {
               "type":"view",
               "name":"地理位置",
               "url":"http://wd1900093.pro.wdcase.com/progorm5/wechat/address.php"
            },
            {
               "type":"view",
               "name":"网站",
               "url":"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx1c5c585786725e27&redirect_uri=http://wd1900093.pro.wdcase.com/progorm5/index.php/home/index/home&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect"
            },
            {
                "type":"view",
                "name":"干货首页",
                "url":"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx1c5c585786725e27&redirect_uri=http://wd1900093.pro.wdcase.com/progorm5/wechat/home.php&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect"
            }]
      

       },
       {
            "name":"📊扫码发图",
            "sub_button":[
                {
                    "type":"scancode_waitmsg",
                    "name":"扫码带提示",
                    "key":"SCANCODE_WAITMSG"
                },
                {
                    "type":"scancode_push",
                    "name":"扫码推事件",
                    "key":"SCANCODE_PUSH"
                },
                {
                    "type":"pic_sysphoto",
                    "name":"系统拍照发图",
                    "key":"PIC_SYSPHOTO"
                },
                {
                    "type":"pic_photo_or_album",
                    "name":"拍照或相册发图",
                    "key":"PIC_PHOTO_OR_ALBUM"
                },
                {
                    "type":"pic_weixin",
                    "name":"微信相册发图",
                    "key":"PIC_WEIXIN"
                }
            ]
        }
       
 }';
 	$url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$access_token;
$result = https_request($url, $jsonmenu);
var_dump($result);

function https_request($url,$data = null){
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    if (!empty($data)){
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    }
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($curl);
    curl_close($curl);
    return $output;
}

?>