<?php
ini_set('display_errors',1);
date_default_timezone_set('Asia/Shanghai');

$servername = "rm-wz93ji56k9zc58jr5lo.mysql.rds.aliyuncs.com";
$username = "yunxk_zs";
$password = "Yunxk_zs1209";
//用于测试
$servername = "127.0.0.1";
$username = "root";
$password = "SLyun-xk21";

//$dsn = "mysql:dbname=xk;host=$servername;charset=UTF8";
//用于测试
$dsn = "mysql:dbname=xk_hnhl;host=$servername;charset=UTF8";

function percentEncode($string) {
    $string = urlencode ( $string );
    $string = preg_replace ( '/\+/', '%20', $string );
    $string = preg_replace ( '/\*/', '%2A', $string );
    $string = preg_replace ( '/%7E/', '~', $string );
    return $string;
}
function computeSignature($parameters, $accessKeySecret)
{
    ksort ( $parameters );
    $canonicalizedQueryString = '';
    foreach ( $parameters as $key => $value ) {
        $canonicalizedQueryString .= '&' . percentEncode ( $key ) . '=' . percentEncode ( $value );
    }
    $stringToSign = 'GET&%2F&' . percentencode ( substr ( $canonicalizedQueryString, 1 ) );
    $signature = base64_encode ( hash_hmac ( 'sha1', $stringToSign, $accessKeySecret . '&', true ) );
    return $signature;
};
// 创建连接
$isauto=false;
while ($isauto)
{
    try
    {
        $conn = new Pdo($dsn, $username, $password);

        $sql = 'select id,code,sms_send,belong_phone,belong_real_name,project_name,build_name,unit_no,room_room from xk_order_house_order where sms_send = 0';

        foreach ($conn->query($sql,PDO::FETCH_ASSOC) as $item)
        {
            if(empty($item))
            {
                sleep(1);
                break;
            }
            //提交参数
            $params = array (
                'SignName' => '云销控',
                'Format' => 'JSON',
                'Version' => '2017-05-25',
                'AccessKeyId' => 'LTAIm5O6hgHs2Jdh',
                'SignatureVersion' => '1.0',
                'SignatureMethod' => 'HMAC-SHA1',
                'SignatureNonce' => uniqid (),
                'Timestamp' => gmdate ( 'Y-m-d\TH:i:s\Z' ),
                'Action' => 'SendSms',
                'TemplateCode' => 'SMS_125117045',
                'PhoneNumbers' => $item['belong_phone'],
                'TemplateParam' => json_encode([
                    'cstname'=>$item['belong_real_name']
                    ,'rinfo'=>"${item['project_name']}${item['build_name']}${item['unit_no']}单元${item['room_room']}"
                    ,'code'=>$item['code']        
                ])
            );

            // 计算签名并把签名结果加入请求参数
            $params ['Signature'] = computeSignature( $params, 'rW0AsJlM8N9E7StxjyZAx4cg9k9piV' );

            $url = 'http://dysmsapi.aliyuncs.com/?' . http_build_query ( $params );

            $ch = curl_init ();
            curl_setopt ( $ch, CURLOPT_URL, $url );
            curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
            curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, FALSE );
            curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
            curl_setopt ( $ch, CURLOPT_TIMEOUT, 10 );
            $result = curl_exec ( $ch );
            curl_close ( $ch );
            $result = json_decode ( $result, true );

            if ($result['Code']=="OK")
            {
                $update = $conn->prepare(
                    'update xk_order_house_order set sms_send = 1 where id = ?'
                );
                $update->execute([$item['id']]);
            }
        }
    }
    catch (\Exception $e)
    {
        print_r($e->getMessage());
    }
    finally
    {
        sleep(1);
    }

}

exit;

// 检测连接


