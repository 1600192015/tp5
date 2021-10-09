<?php
	header('Content-Type:text/html;charset=utf-8');
	$appid='wx1c5c585786725e27';
	$appsecret='64bf7ae6e5b8496da0aebefc0f17f8e2';
	//µÚÒ»²½:»ñÈ¡code
	if (isset($_GET['code'])){
		$code=$_GET['code'];
	}else{
		echo "NO CODE";die;
	}
	//echo $code;die;
	//µÚ¶þ²½:Ê¹ÓÃcode»»ÇøACCESS_TOKEN
	$arr=file_get_contents("https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$appsecret&code=$code&grant_type=authorization_code");
	//var_dump($arr);//·µ»ØÒ»¸öJSON¸ñÊ½µÄ×Ö·û´®
	$data=json_decode($arr,true);//½«JSON¸ñÊ½µÄ×Ö·û´®×ª»»ÎªÊý×é
	//echo '<pre>';
	//print_r($data);
	$access_token=$data['access_token'];
	$openid=$data['openid'];
	//µÚÈý²½:Ê¹ÓÃcodeºÍaccess_token»»È¡ÓÃ»§ÏêÏ¸ÐÅÏ¢
	$user_arr=file_get_contents("https://api.weixin.qq.com/sns/userinfo?access_token=$access_token&openid=$openid");
	$user=json_decode($user_arr,true);
	echo '<pre>';
	print_r($user);
	
	
	
	
	
	
	
	

?>