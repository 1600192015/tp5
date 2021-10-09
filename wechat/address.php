<?php
	header('Content-Type:text/html;charset=utf-8');
	//获取地理位置
	include('jssdk.class.php');
	$appid='wx1c5c585786725e27';
	$appsecret='64bf7ae6e5b8496da0aebefc0f17f8e2';
	$jssdk=new JSSDK($appid,$appsecret);
	//调用SignPackage方法,看查看方法里面return的数组
	$signPackage=$jssdk->getSignPackage();
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title></title>
	<script src="api.js"></script>
</head>
<body>
	<div id="container"></div>
	<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
	<script>
		//通过config接口注入权限验证配置
		wx.config({
			debug: false,
			appId: '<?php echo $signPackage["appId"];?>',
			timestamp: <?php echo $signPackage["timestamp"];?>,
			nonceStr: '<?php echo $signPackage["nonceStr"];?>',
			signature: '<?php echo $signPackage["signature"];?>',
			jsApiList: [
				// 所有要调用的 API 都要加到这个列表中
				'checkJsApi',
				'openLocation',
				'getLocation'
			  ]
		});
		//处理成功的代码
		wx.ready(function () {
			//判断当前客户端版本是否支持指定获取地理位置
			wx.checkJsApi({
				jsApiList: [
					'getLocation'
				],
				success: function (res) {
					// alert(JSON.stringify(res));
					// alert(JSON.stringify(res.checkResult.getLocation));
					if (res.checkResult.getLocation == false) {
						alert('你的微信版本太低，不支持微信JS接口，请升级到最新的微信版本！');
						return;
					}
				}
			});
			//获取地理位置坐标
			wx.getLocation({
				success: function (res) {
					var latitude = res.latitude; // 纬度，浮点数，范围为90 ~ -90
					var longitude = res.longitude; // 经度，浮点数，范围为180 ~ -180。
					var speed = res.speed; // 速度，以米/每秒计
					var accuracy = res.accuracy; // 位置精度
					alert(latitude+'\r\n'+longitude+'\r\n'+speed+'\r\n'+accuracy);
					var map = new BMap.Map("container");
					// 创建地图实例
					var point = new BMap.Point(longitude,latitude); 
					map.centerAndZoom(point,12); 
					var geoc = new BMap.Geocoder(); 
					geoc.getLocation(point,function(rs){ 
						var addComp = rs.addressComponents; 
						alert(addComp.province + ", " + addComp.city + ", " + addComp.district + ", " + addComp.street + ", " + addComp.streetNumber);
					});
				},
				cancel: function (res) {
					alert('用户拒绝授权获取地理位置');
				}
			});
		});
	</script>
</body>
</html>