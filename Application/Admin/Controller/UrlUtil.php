<?php 
namespace  UrlUtil;
header("Content-Type: text/html;charset=utf-8"); 
/**  
 * Created by PhpStorm.  
 * User: lry  
 * Date: 2017/6/28  
 * Time: 13:24  
 */  
class UrlUtil  
{  
   /**
 * 发送HTTP请求方法
 * @param  string $url    请求URL
 * @param  array  $params 请求参数
 * @param  string $method 请求方法GET/POST
 * @return array  $data   响应数据
 */
static function http($url, $params, $method = 'GET'){
  
  $header = array("Content-Type:application/json; charset=utf-8");  
  
  //echo $params; 
    $opts = array(
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_HTTPHEADER     => $header
    );
    /* 根据请求类型设置特定参数 */
    switch(strtoupper($method)){
        case 'GET':         
          if(!isset($params)){
             $opts[CURLOPT_URL] = $url;
             echo $url,'<br>';
          }
          else{
             $opts[CURLOPT_URL] = $url.$params; 
             echo $url.$params,'<br>';  
          }                           
            break;
        case 'POST':
          $params = self::ArrayJson($params);//中文转码
            $opts[CURLOPT_URL] = $url;
            $opts[CURLOPT_POST] = 1;
            $opts[CURLOPT_POSTFIELDS] = $params;
            break;
        default:
            throw new Exception('不支持的请求方式！');
    }
    /* 初始化并执行curl请求 */
    $ch = curl_init();
    curl_setopt_array($ch, $opts);
    $data  = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);
    if($error) throw new Exception('请求发生错误：' . $error);
    return  $data;
}

/**************************************************************
 *
 *  将数组转换为JSON字符串（兼容中文）
 *  @param  array   $array      要转换的数组
 *  @return string      转换得到的json字符串
 *  @access public
 *
 *************************************************************/
static function ArrayJson($array) {
    foreach ($array as $key => $value) {
      $array[$key] = urlencode($value);
    }
    return urldecode(json_encode($array));
}
}  