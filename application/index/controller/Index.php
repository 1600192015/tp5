<?php

namespace app\index\controller;

use org\wechat\jssdk;
class Index
{
    public function __construct()
    {
        $appID = 'wx1c5c585786725e27';
        $appsecret = '64bf7ae6e5b8496da0aebefc0f17f8e2';
        $this->jssdk = new JSSDK($appID, $appsecret);
    }
    public function index()
    {
        $jssdk = $this->jssdk->getSignPackage();
        $access_token = $this->jssdk->AccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/user/get?access_token=$access_token&next_openid";
        $data = [];
        $res = patchurl($url, $data);
        var_dump($res);
        return view();
    }

    public function hello($name = 'ThinkPHP5')
    {
        return 'hello,' . $name;
    }
}
