<?php
/*
    方倍工作室
    http://www.fangbei.org/
    CopyRight 2011-2017 All Rights Reserved
*/

header('Content-type:text');
define("TOKEN", "weixin");

$wechatObj = new wechatCallbackapiTest();
if (!isset($_GET['echostr'])) {
    $wechatObj->responseMsg();
} else {
    $wechatObj->valid();
}

class wechatCallbackapiTest
{
    public function valid()
    {
        $echoStr = $_GET["echostr"];
        if ($this->checkSignature()) {
            echo $echoStr;
            exit;
        }
    }

    private function checkSignature()
    {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);

        if ($tmpStr == $signature) {
            return true;
        } else {
            return false;
        }
    }

    public function responseMsg()
    {
        // $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        $postStr = file_get_contents("php://input");
        if (!empty($postStr)) {
            $this->logger("R " . $postStr);
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $RX_TYPE = trim($postObj->MsgType);

            switch ($RX_TYPE) {
                case "event":
                    $result = $this->receiveEvent($postObj);
                    break;
                case "text":

                    $result = $this->receiveText($postObj);
                    break;
            }
            $this->logger("T " . $result);
            echo $result;
        } else {
            echo "";
            exit;
        }
    }

    private function receiveEvent($object)
    {
        $content = "";
        switch ($object->Event) {
            case "subscribe":
                $content = "欢迎关注幻想乡";
                break;
            case "unsubscribe":
                $content = "取消关注";
                break;
            case "CLICK" :
                if ($object->EventKey == 'V1001_HELLO_WORLD') {
                    $content = '请输入要查询的城市，比如：北京天气';
                } else {
                    $content = '此功能暂时不开放';
                }
                if ($object->EventKey == 'V1001_GOOD') {

                }
                break;
        }
        $result = $this->transmitText($object, $content);
        return $result;
    }


    //接收文本消息
    private function receiveText($object)
    {
        $keyword = trim($object->Content);
        if (strstr($keyword, "天气")) {
            $city = str_replace('天气', '', $keyword);//这里用空格取代$keyword中的天气二字。
            $content = $this->getWeatherInfo($city);
            //判断笑话
            $result = $this->transmitNews($object, $content);
        } else {
            $content = $this->callTuling($keyword);
            $result = $this->transmitText($object, $content);
        }

        return $result;
    }

    //
    private function transmitText($object, $content)
    {
        $textTpl = "<xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[text]]></MsgType>
                    <Content><![CDATA[%s]]></Content>
                    </xml>";
        $result = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), $content);
        return $result;
    }

    //返回图文信息
    private function transmitNews($object, $arr_item)
    {
        if (!is_array($arr_item))
            return;

        $itemTpl = "    <item>
                <Title><![CDATA[%s]]></Title>
                <Description><![CDATA[%s]]></Description>
                <PicUrl><![CDATA[%s]]></PicUrl>
                <Url><![CDATA[%s]]></Url>
                </item>
                ";
        $item_str = "";
        foreach ($arr_item as $item)
            $item_str .= sprintf($itemTpl, $item['Title'], $item['Description'], $item['PicUrl'], $item['Url']);

        $newsTpl = "<xml>
                <ToUserName><![CDATA[%s]]></ToUserName>
                <FromUserName><![CDATA[%s]]></FromUserName>
                <CreateTime>%s</CreateTime>
                <MsgType><![CDATA[news]]></MsgType>
                <Content><![CDATA[]]></Content>
                <ArticleCount>%s</ArticleCount>
                <Articles>
                $item_str</Articles>
                </xml>";

        $result = sprintf($newsTpl, $object->FromUserName, $object->ToUserName, time(), count($arr_item));
        return $result;
    }

    private function transmitMusic($object, $musicArray)
    {
        $itemTpl = "<Music>
    <Title><![CDATA[%s]]></Title>
    <Description><![CDATA[%s]]></Description>
    <MusicUrl><![CDATA[%s]]></MusicUrl>
    <HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
</Music>";

        $item_str = sprintf($itemTpl, $musicArray['Title'], $musicArray['Description'], $musicArray['MusicUrl'], $musicArray['HQMusicUrl']);

        $textTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[music]]></MsgType>
$item_str
</xml>";

        $result = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }

    private function logger($log_content)
    {
        if (isset($_SERVER['HTTP_APPNAME'])) {   //SAE
            sae_set_display_errors(false);
            sae_debug($log_content);
            sae_set_display_errors(true);
        } else if ($_SERVER['REMOTE_ADDR'] != "127.0.0.1") { //LOCAL
            $max_size = 10000;
            $log_filename = "log.xml";
            if (file_exists($log_filename) and (abs(filesize($log_filename)) > $max_size)) {
                unlink($log_filename);
            }
            file_put_contents($log_filename, date('H:i:s') . " " . $log_content . "\r\n", FILE_APPEND);
        }
    }

    //创建函数调用图灵机器人接口
    private function callTuling($keyword)
    {
        $apiKey = "b8f575b3c1224d259b7813f89def350e"; //填写后台提供的key
        $apiURL = "http://www.tuling123.com/openapi/api?key=KEY&info=INFO";

        $reqInfo = $keyword;
        $url = str_replace("INFO", $reqInfo, str_replace("KEY", $apiKey, $apiURL));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $file_contents = curl_exec($ch);
        curl_close($ch);
        //获取图灵机器人返回的数据，并根据code值的不同获取到不用的数据
        $message = json_decode($file_contents, true);
        $result = "";
        if ($message['code'] == 100000) {
            $result = $message['text'];
        } else if ($message['code'] == 200000) {
            $text = $message['text'];
            $url = $message['url'];
            $result = $text . " " . $url;
        } else if ($message['code'] == 302000) {
            $text = $message['text'];
            $url = $message['list'][0]['detailurl'];
            $result = $text . " " . $url;
        } else {
            $result = "好好说话我们还是基佬";
        }
        return $result;
    }

    //获取天气
    function getWeatherInfo($cityName)
    {
        if ($cityName == "" || (strstr($cityName, "+"))) {
            return "发送天气+城市，例如'天气深圳'";
        }//用户查询天气,回复关键词 规则
        $url = "http://api.map.baidu.com/telematics/v3/weather?location=" . urlencode($cityName) . "&output=json&ak=QqMBUR5doRNG2QDSeuX6usPEDNVPe5y6";
        //构建通过百度车联API V3.0查询天气url链接
        $ch = curl_init();
        //初始化会话
        curl_setopt($ch, CURLOPT_URL, $url);
        //设置会话参数
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //设置会话参数
        $output = curl_exec($ch);
        //执行curl会话
        curl_close($ch);
        //关闭curl会话
        $result = json_decode($output, true);//函数json_decode() 的功能时将json数据格式转换为数组。
        if ($result["error"] != 0) {
            return $result["status"];
        }
        $curHour = (int)date('H', time());
        $weather = $result["results"][0];
        //按照微信公众号开发文档,组建设多图文回复信息
        $weatherArray[] = array(
            "Title" => $weather['currentCity'] . "当前天气:" . "温度:" . $weather['weather_data'][0]['temperature'] . "," . $weather['weather_data'][0]['weather'] . "," . "风力:" . $weather['weather_data'][0]['wind'] . ".",
            "Description" => "",
            "PicUrl" => "http://weixin.51pcjq.com/img/weather_bg.jpg",
            "Url" => "");
        for ($i = 0; $i < count($weather["weather_data"]); $i++) {
            $weatherArray[] = array(
                "Title" => $weather["weather_data"][$i]["date"] . "\n" . $weather["weather_data"][$i]["weather"] . " " . $weather["weather_data"][$i]["wind"] . " " . $weather["weather_data"][$i]["temperature"] . "",
                "Description" => "",
                "PicUrl" => (($curHour >= 6) && ($curHour < 18)) ? $weather["weather_data"][$i]["dayPictureUrl"] : $weather["weather_data"][$i]["nightPictureUrl"],
                "Url" => "");
        }
        return $weatherArray;
    }


}

?>