<?php

/**
 * 获取当前页面完整URL地址
 *
 * @create 2016-9-12
 * @author zlw
 */
function get_url() {
    $sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' 
		? 'https://' : 'http://';
    $php_self = $_SERVER['PHP_SELF'] 
		? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
    $path_info = isset($_SERVER['PATH_INFO']) 
		? $_SERVER['PATH_INFO'] : '';
    $relate_url = isset($_SERVER['REQUEST_URI']) 
		? $_SERVER['REQUEST_URI'] : $php_self.(isset($_SERVER['QUERY_STRING']) ? '?'.$_SERVER['QUERY_STRING'] : $path_info);
    return $sys_protocal.(isset($_SERVER['HTTP_HOST']) 
		? $_SERVER['HTTP_HOST'] : '').$relate_url;
}


/**
 * Discuz 加密/解密
 *
 * @param [type]  $string    [description]
 * @param string  $operation [description]
 * @param string  $key       [description]
 * @param integer $expiry    [description]
 * @return [type]            [description]
 */
function authcode( $string, $operation = 'DECODE', $key = '', $expiry = 0 ) {
    $ckey_length = 4;
    $key = md5( $key != '' ? $key : C( 'AUTH_CODE' ) );
    $keya = md5( substr( $key, 0, 16 ) );
    $keyb = md5( substr( $key, 16, 16 ) );
    $keyc = $ckey_length ? ( $operation == 'DECODE' ? substr( $string, 0, $ckey_length ): substr( md5( microtime() ), -$ckey_length ) ) : '';

    $cryptkey = $keya.md5( $keya.$keyc );
    $key_length = strlen( $cryptkey );

    $string = $operation == 'DECODE' ? base64_decode( substr( $string, $ckey_length ) ) : sprintf( '%010d', $expiry ? $expiry + time() : 0 ).substr( md5( $string.$keyb ), 0, 16 ).$string;
    $string_length = strlen( $string );

    $result = '';
    $box = range( 0, 255 );

    $rndkey = array();
    for ( $i = 0; $i <= 255; $i++ ) {
        $rndkey[$i] = ord( $cryptkey[$i % $key_length] );
    }

    for ( $j = $i = 0; $i < 256; $i++ ) {
        $j = ( $j + $box[$i] + $rndkey[$i] ) % 256;
        $tmp = $box[$i];
        $box[$i] = $box[$j];
        $box[$j] = $tmp;
    }

    for ( $a = $j = $i = 0; $i < $string_length; $i++ ) {
        $a = ( $a + 1 ) % 256;
        $j = ( $j + $box[$a] ) % 256;
        $tmp = $box[$a];
        $box[$a] = $box[$j];
        $box[$j] = $tmp;
        $result .= chr( ord( $string[$i] ) ^ ( $box[( $box[$a] + $box[$j] ) % 256] ) );
    }

    if ( $operation == 'DECODE' ) {
        if ( ( substr( $result, 0, 10 ) == 0 || substr( $result, 0, 10 ) - time() > 0 ) && substr( $result, 10, 16 ) == substr( md5( substr( $result, 26 ).$keyb ), 0, 16 ) ) {
            return substr( $result, 26 );
        } else {
            return '';
        }
    } else {
        return $keyc.str_replace( '=', '', base64_encode( $result ) );
    }
}

/**
 * 对称加密
 *
 * @create 2016-9-13
 * @author zlw
 */
function rsa_encode($string = '', $skey = 'key') {
	$strArr = str_split(base64_encode($string));
	$strCount = count($strArr);
	
	foreach (str_split($skey) as $key => $value) {
		$key < $strCount && $strArr[$key] .= $value;
	}
	return str_replace(
		array('=', '+', '/'), 
		array('O0O0O', 'o000o', 'oo00o'), 
		join('', $strArr)
	);
}


/**
 * 对称加密 - 解密
 *
 * @create 2016-9-13
 * @author zlw
 */
function rsa_decode($string = '', $skey = 'yourkey') {
	$strArr = str_split(
		str_replace(
			array('O0O0O', 'o000o', 'oo00o'), 
			array('=', '+', '/'), 
			$string
		), 2
	);
	$strCount = count($strArr);
	foreach (str_split($skey) as $key => $value) {
		$key <= $strCount && $strArr[$key][1] === $value && $strArr[$key] = $strArr[$key][0];
	}
	
	return base64_decode(join('', $strArr));
}


/**
 * 系统加密方法
 * @param string $data 要加密的字符串
 * @param string $key  加密密钥
 * @param int $expire  过期时间 单位 秒
 * @return string
 */
function think_encrypt($data, $key = '', $expire = 0) {
    $key  = md5($key);
    $data = base64_encode($data);
    $x    = 0;
    $len  = strlen($data);
    $l    = strlen($key);
    $char = '';

    for ($i = 0; $i < $len; $i++) {
        if ($x == $l) $x = 0;
        $char .= substr($key, $x, 1);
        $x++;
    }

    $str = sprintf('%010d', $expire ? $expire + time():0);

    for ($i = 0; $i < $len; $i++) {
        $str .= chr(ord(substr($data, $i, 1)) + (ord(substr($char, $i, 1)))%256);
    }
    return str_replace('=', '', base64_encode($str));
}


/**
 * 系统解密方法
 * @param  string $data 要解密的字符串 （必须是think_encrypt方法加密的字符串）
 * @param  string $key  加密密钥
 * @return string
 */
function think_decrypt($data, $key = ''){
    $key    = md5($key);
    $x      = 0;
    $data   = base64_decode($data);
    $expire = substr($data,0,10);
    $data   = substr($data,10);

    if($expire > 0 && $expire < time()) {
        return '';
    }

    $len  = strlen($data);
    $l    = strlen($key);
    $char = $str = '';

    for ($i = 0; $i < $len; $i++) {
        if ($x == $l) $x = 0;
        $char .= substr($key, $x, 1);
        $x++;
    }

    for ($i = 0; $i < $len; $i++) {
        if (ord(substr($data, $i, 1))<ord(substr($char, $i, 1))) {
            $str .= chr((ord(substr($data, $i, 1)) + 256) - ord(substr($char, $i, 1)));
        }else{
            $str .= chr(ord(substr($data, $i, 1)) - ord(substr($char, $i, 1)));
        }
    }
    return base64_decode($str);
}


/**
* 对查询结果集进行排序
* @access public
* @param array $list 查询结果
* @param string $field 排序的字段名
* @param array $sortby 排序类型
* asc正向排序 desc逆向排序 nat自然排序
* @return array
*/
function list_sort_by($list,$field, $sortby='asc') {
   if(is_array($list)){
       $refer = $resultSet = array();
       foreach ($list as $i => $data)
           $refer[$i] = &$data[$field];
       switch (strtolower($sortby)) {
           case 'asc': // 正向排序
                asort($refer);
                break;
           case 'desc':// 逆向排序
                arsort($refer);
                break;
           case 'nat': // 自然排序
                natcasesort($refer);
                break;
       }
       foreach ( $refer as $key=> $val)
           $resultSet[] = &$list[$key];
       return $resultSet;
   }
   return false;
}


/**
 * 判断是否为手机端
 *
 * @create 2016-10-18
 * @author zlw
 */
function is_mobile() { 
    // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
    if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
    {
        return true;
    } 
    // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
    if (isset ($_SERVER['HTTP_VIA']))
    { 
        // 找到为true
		if (stristr($_SERVER['HTTP_VIA'], "wap")) {
			return true;
		}
    } 
    // 脑残法，判断手机发送的客户端标志,兼容性有待提高
    if (isset ($_SERVER['HTTP_USER_AGENT']))
    {
        $clientkeywords = array (
			'nokia',
            'sony',
            'ericsson',
            'mot',
            'samsung',
            'htc',
            'sgh',
            'lg',
            'sharp',
            'sie-',
            'philips',
            'panasonic',
            'alcatel',
            'lenovo',
            'iphone',
            'ipod',
            'blackberry',
            'meizu',
            'android',
            'netfront',
            'symbian',
            'ucweb',
            'windowsce',
            'palm',
            'operamini',
            'operamobi',
            'openwave',
            'nexusone',
            'cldc',
            'midp',
            'wap',
            'mobile'
		); 
		
        // 从HTTP_USER_AGENT中查找手机浏览器的关键字
        if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
        {
            return true;
        } 
    } 
	
    // 协议法，因为有可能不准确，放到最后判断
    if (isset ($_SERVER['HTTP_ACCEPT']))
    { 
        // 如果只支持wml并且不支持html那一定是移动设备
        // 如果支持wml和html但是wml在html之前则是移动设备
        if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) 
			&& (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false 
			|| (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') 
				< strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))
		) {
            return true;
        } 
    }
	
    return false;
} 


/**
 * 判断是否为手机号码
 *
 * @create 2016-10-27
 * @author zlw
 */
function is_phone_number($mobile) { 
	if (preg_match("/^1[34578]\d{9}$/", $mobile)) {
		return true;
	}
	
	return false;
}


/**
 * 保存远程图片到本地
 *
 * @create 2016-11-8
 * @author zlw
 */
function grab_image($url, $filename = "") { 
	if ($url == "") {
		return false; 
	}

	if ($filename == "") { 
		return false; 
	}

	$img = '';
	
	ob_start(); 
	$readfile_status = readfile($url);
	if (false !== $readfile_status) {
		$img = ob_get_contents(); 
		ob_end_clean(); 
		$size = strlen($img); 
	} else {
		if (function_exists('file_get_contents')) {
			$img = file_get_contents($url);
		} else {
			$ch = curl_init();
			$timeout = 5; 
			curl_setopt ($ch, CURLOPT_URL, $url);
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); 
			curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			$img = curl_exec($ch);
			curl_close($ch);
		}
	}
	
	if (false === $img || $img == '') {
		return false;
	}

	$fp2 = @fopen($filename, "w"); 
	if (false === $fp2) {
		return false;
	}
	
	if (false === fwrite($fp2, $img)) {
		return false;
	}
	
	fclose($fp2);

	return $filename; 
} 


/**
 * 循环删除目录和文件函数
 *
 * @create 2016-11-8
 * @author zlw
 */
function delete_dir_and_file( $dir_name, $is_delete_dir = false )
{
	if ( $handle = opendir( "$dir_name" ) ) {
		while ( false !== ( $item = readdir( $handle ) ) ) {
			if ( $item != "." && $item != ".." ) {
				if ( is_dir( "$dir_name/$item" ) ) {
					delete_dir_and_file( "$dir_name/$item" );
				} else {
					if( !unlink( "$dir_name/$item" ) ) {
						return false;
					}
				}
			}
		}
		
		closedir( $handle );
		
		//删除当前目录
		if ( $is_delete_dir ) {
			rmdir( $dir_name );
		}
	
		return true;
	}
}


    /**
    * 参数加密解密
    **/
    function keyED($txt, $encrypt_key) {
        $encrypt_key = md5($encrypt_key);
        $ctr = 0;
        $tmp = "";
        for ($i = 0; $i < strlen($txt); $i++) {
            if ($ctr == strlen($encrypt_key))
                $ctr = 0;
            $tmp.= substr($txt, $i, 1) ^ substr($encrypt_key, $ctr, 1); 
            $ctr++;
        }
       
        return $tmp;
    }

    function encrypt($txt, $key) {
        $encrypt_key = md5(mt_rand(83, 91));
        $ctr = 0;
        $tmp = "";
        for ($i = 0; $i < strlen($txt); $i++) {
            if ($ctr == strlen($encrypt_key))
                $ctr = 0;
            
            $tmp.=substr($encrypt_key, $ctr, 1) . (substr($txt, $i, 1) ^ substr($encrypt_key, $ctr, 1));
            $ctr++;
        }
        return keyED($tmp, $key);
    }

    function decrypt($txt, $key) {
        $txt = keyED($txt, $key);
        $tmp = "";
        for ($i = 0; $i < strlen($txt); $i++) {
            $md5 = substr($txt, $i, 1);
            $i++;
            $tmp.= (substr($txt, $i, 1) ^ $md5);
        }
        return $tmp;
    }

    function encrypt_url($url, $key) {
        $kk=rawurlencode(base64_encode(encrypt($url, $key) ));
        if (substr ($kk, -3)=="%2F")
                $kk=str_replace("%2F","%252F",$kk);
        return $kk;
    }

    function decrypt_url($url, $key) {
        return decrypt(base64_decode(rawurldecode($url)), $key);
    }

    function geturl($str, $key) {
        $str = decrypt_url($str, $key);
        
        /*$url_array = explode('&', $str);
        if (is_array($url_array)) {
            foreach ($url_array as $var) {
                $var_array = explode("=", $var);
                $vars[$var_array[0]] = $var_array[1];
            }
        }*/
        
        $var_array = explode("/", $str);
        if(count($var_array)>1)
        {
            $i=0;
            foreach ($var_array as $k=>$var) {
                if($i==$k)
                {
                    $vars[$var]=$var_array[$k+1];
                    $i= $i+2;
                }
            }
        }
        else
        {
            $vars=$var_array;
        }
        return $vars;
    }
    
    function getUrlkey(){  
        return C('PROJECT_KEY'); 
    }  
    
     function getChoosekey(){  
        return C('CHOOSE_KEY'); 
    }  

    /**
   * 将ascii码转为字符串
   * @param type $str 要解码的字符串
   * @param type $prefix 前缀，默认:&#
   * @return type
   */
  function strdecode($str, $prefix="") {
    $str = str_replace($prefix, "", $str);
    $a = explode("|", $str);
    foreach ($a as $dec) {
      if ($dec < 128) {
        $utf .= chr($dec);
      } else if ($dec < 2048) {
        $utf .= chr(192 + (($dec - ($dec % 64)) / 64));
        $utf .= chr(128 + ($dec % 64));
      } else {
        $utf .= chr(224 + (($dec - ($dec % 4096)) / 4096));
        $utf .= chr(128 + ((($dec % 4096) - ($dec % 64)) / 64));
        $utf .= chr(128 + ($dec % 64));
      }
    }
    $utf=strrev($utf);
    return $utf;
  }
  
  /**
   * 将字符串转换为ascii码
   * @param type $c 要编码的字符串
   * @param type $prefix 前缀，默认：""
   * @return string
   */
  function strencode($c, $prefix="") {  
    $pattern = '/[^\x00-\x80]/';
    if(preg_match($pattern,$c)){
       return $c;
    }
    $len = strlen($c); 
    $c=strrev($c);
    $a = 0;
    while ($a < $len) {
      $ud = 0;
      if (ord($c{$a}) >= 0 && ord($c{$a}) <= 127) {
        $ud = ord($c{$a});
        $a += 1;
      } else if (ord($c{$a}) >= 192 && ord($c{$a}) <= 223) {
        $ud = (ord($c{$a}) - 192) * 64 + (ord($c{$a + 1}) - 128);
        $a += 2;
      } else if (ord($c{$a}) >= 224 && ord($c{$a}) <= 239) {
        $ud = (ord($c{$a}) - 224) * 4096 + (ord($c{$a + 1}) - 128) * 64 + (ord($c{$a + 2}) - 128);
        $a += 3;
      } else if (ord($c{$a}) >= 240 && ord($c{$a}) <= 247) {
        $ud = (ord($c{$a}) - 240) * 262144 + (ord($c{$a + 1}) - 128) * 4096 + (ord($c{$a + 2}) - 128) * 64 + (ord($c{$a + 3}) - 128);
        $a += 4;
      } else if (ord($c{$a}) >= 248 && ord($c{$a}) <= 251) {
        $ud = (ord($c{$a}) - 248) * 16777216 + (ord($c{$a + 1}) - 128) * 262144 + (ord($c{$a + 2}) - 128) * 4096 + (ord($c{$a + 3}) - 128) * 64 + (ord($c{$a + 4}) - 128);
        $a += 5;
      } else if (ord($c{$a}) >= 252 && ord($c{$a}) <= 253) {
        $ud = (ord($c{$a}) - 252) * 1073741824 + (ord($c{$a + 1}) - 128) * 16777216 + (ord($c{$a + 2}) - 128) * 262144 + (ord($c{$a + 3}) - 128) * 4096 + (ord($c{$a + 4}) - 128) * 64 + (ord($c{$a + 5}) - 128);
        $a += 6;
      } else if (ord($c{$a}) >= 254 && ord($c{$a}) <= 255) { //error
        $ud = false;
      }
      $scill .= $prefix.$ud."|";
    }
    return $scill;
  }

