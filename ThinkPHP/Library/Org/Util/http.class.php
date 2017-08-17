<?php  
namespace Org\Util;
/**  
 * Created by PhpStorm.  
 * User: lry  
 * Date: 2017/6/28  
 * Time: 13:24  
 */  
class http
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
           
            $opts[CURLOPT_URL] = $url;
            $opts[CURLOPT_POST] = 1;
            $opts[CURLOPT_POSTFIELDS] = $params;
            break;
        default:
            throw new \Exception('不支持的请求方式！');
    }
    /* 初始化并执行curl请求 */
    $ch = curl_init();
    curl_setopt_array($ch, $opts);
    $data  = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);
    if($error) throw new \Exception('请求发生错误：' . $error);
    return  $data;
}
/************************************************************** 
 * 
 *  使用特定function对数组中所有元素做处理 
 *  @param  string  &$array     要处理的字符串 
 *  @param  string  $function   要执行的函数 
 *  @return boolean $apply_to_keys_also     是否也应用到key上 
 *  @access public 
 * 
 *************************************************************/
  static function arrayRecursive(&$array, $function, $apply_to_keys_also = false)  
    {  
      static $recursive_counter = 0;  
      if (++$recursive_counter > 1000) {  
          die('possible deep recursion attack');  
      }  
      foreach ($array as $key => $value) {  
          if (is_array($value)) {  
              self::arrayRecursive($array[$key], $function, $apply_to_keys_also);  
          } else {  
              $array[$key] = $function($value);  
          }  
     
          if ($apply_to_keys_also && is_string($key)) {  
              $new_key = $function($key);  
              if ($new_key != $key) {  
                  $array[$new_key] = $array[$key];  
                  unset($array[$key]);  
              }  
          }  
      }  
      $recursive_counter--;  
    } 
/************************************************************** 
 * 
 *  将数组转换为JSON字符串（兼容中文） 
 *  @param  array   $array      要转换的数组 
 *  @return string      转换得到的json字符串 
 *  @access public 
 * 
 *************************************************************/ 
  static function JSON($array) {  
      self::arrayRecursive($array, 'urlencode', true);  
      $json = json_encode($array);  
      return urldecode($json);  
  } 
}  