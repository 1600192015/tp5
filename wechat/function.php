<?php
	
	//公共函数库
	/**
	 * 字符截取
	 * @param string $string  需要截取的字符串
	 * @param int 	 $start	  截取的开始位置
	 * @param int 	 $length  截取的长度
	 * @param string $charset 编码
	 * @param string $dot	  如果截取的长度小于总长度就加这个字符
	 */
	//字符串截取
	function str_cut(&$string, $start, $length, $charset = "utf-8", $dot = '...') {
		if(function_exists('mb_substr')) {
			if(mb_strlen($string, $charset) > $length) {
				return mb_substr ($string, $start, $length, $charset) . $dot;
			}
			return mb_substr ($string, $start, $length, $charset);
		}else if(function_exists('iconv_substr')) {
			if(iconv_strlen($string, $charset) > $length) {
				return iconv_substr($string, $start, $length, $charset) . $dot;
			}
			return iconv_substr($string, $start, $length, $charset);
		}
		$charset = strtolower($charset);
		switch ($charset) {
			case "utf-8" :
				preg_match_all("/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/", $string, $ar);
				if(func_num_args() >= 3) {
					if (count($ar[0]) > $length) {
						return join("", array_slice($ar[0], $start, $length)) . $dot;
					}
					return join("", array_slice($ar[0], $start, $length));
				} else {
					return join("", array_slice($ar[0], $start));
				}
				break;
			default:
				$start = $start * 2;
				$length   = $length * 2;
				$strlen = strlen($string);
				for ( $i = 0; $i < $strlen; $i++ ) {
					if ( $i >= $start && $i < ( $start + $length ) ) {
						if ( ord(substr($string, $i, 1)) > 129 ) $tmpstr .= substr($string, $i, 2);
						else $tmpstr .= substr($string, $i, 1);
					}
					if ( ord(substr($string, $i, 1)) > 129 ) $i++;
				}
				if ( strlen($tmpstr) < $strlen ) $tmpstr .= $dot;
				
				return $tmpstr;
		}
	}
	//打印函数
	function p($arr){
		echo '<pre>';
		print_r($arr);
		echo '</pre>';
		die;
	}
	//换行
	function b(){
		echo '<br>';
	}
	//跳转函数
	// 参数$msg,提醒的语言
	// 参数$url,跳转到的页面,默认为空
	function show_msg($msg,$url=null){
		if($url){
			echo "<script>alert('".$msg."');location.href='".$url."'</script>";
		}else{
			echo "<script>alert('".$msg."');history.go(-1)</script>";
		}
		die;
	}
	//大小
	function my_filesize($path){
		$size=filesize($path);//以B为单位的大小
		$str='';//储存换算后的结果
		if($size<1024){
			$str=$size.'B';
		}else if($size>=1024 && $size<pow(2,20)){
			$str=sprintf('%.2fKB',$size/1024);//保留两位小数输出
		}else if($size>=pow(2,20) && $size<pow(2,30)){
			$str=sprintf('%.2fMB',$size/pow(2,20));
		}else if($size>=pow(2,30) && $size<pow(2,40)){
			$str=sprintf('%.2fGB',$size/pow(2,30));
		}else if($size>=pow(2,40) && $size<pow(2,50)){
			$str=sprintf('%.2fTB',$size/pow(2,40));
		} 
		return $str;
	}
	//删除文件夹
	function my_rmdir($path){
		//先读取文件夹里面的内容放进数组内
		$arr=scandir($path);
		if(is_array($arr)){
			foreach($arr as $v){
				if($v=='.' || $v=='..'){
					continue;//终止当前循环
				}
				//echo $v.'<br>';
				//拼接好路径
				$file=$path.'/'.$v;
				//echo $file.'<br>';
				if(is_dir($file)){//如果是文件夹
					my_rmdir($file);
					//递归函数,继续使用当前函数的功能
				}else{//如果是文件
					unlink($file);
				}
			}
		}else{
				unlink($arr);
		}
		rmdir($path);
	}
	
	
?>