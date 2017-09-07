<?php
/*
 * 后台登录控制器
 */
 namespace Admin\Controller;
 use Think\controller;
 class LoginController extends Controller{
	 
	 /*登录页视图*/
	 public function index(){
		 $this->display();
	 }
	 public function homeList(){
		 $this->display("homeList");
	 }
	 public function loginout(){
		 session(null);
		 $this->success('正在退出............',U('Login/index'),2);
	 }
	 /*登录处理*/
	 public function loginfo(){
		 if(!IS_POST) $this->error('访问页面不存在');
		 header("Content-Type: text/html;charset=utf-8"); 
		 $name = I('username');
		 $pwd = md5(I('password'));
		 /*$db = M('admin');
		 $admin = $db->where(array('username'=>$name))->find();

		 if(!$admin || $admin['password'] != $pwd){
			 $this->error('账号或密码错误');
		 }

		
		 session('uid',$admin['id']);
		 session('username',$admin['username']);*/
		 $test = new \Org\Util\http();
		 $list1 = array("uname"=>"张三","pwd"=>"1234qwer","token"=>"xiaowei");
		 $dataArray = 
		 array("uname"=>"admin","passwd"=>"张三","token"=>"xiaowei");//register
        $user_list = $GLOBALS['db']->getRows("select * from yzt_user");
        echo $user_list;
		//$str = '?uname=xs&age=6&token=xiaowei';
       //  session_destroy();
		define('loginUrl','http://localhost:8080/yzt_service/testDemo/land');

	 	/*$result = $test->http(loginUrl,$str,'POST');
		
		// echo json_encode($dataArray),'<br>';
		 if (strcmp($result,'SUCCESS')==0) {
		 	$this->success('登录成功',U("Login/homeList"),1);//redirect:""
		 } else {
		 	$this->error('登录失败返回登陆页.....',U('Login/index'));
		 }		*/
		// $this->sendToMQ('test-phpMqTest',"1111");
         //$this->display("homeList");//redirect:""
	 }
	 /**
	 *destination 队列名称
	 *msg_data 数据
	 *persistent 是否同步
	 **/
	 protected function sendToMQ($destination, $msg_data, $persistent = false)
    {
		/*$link = stomp_connect('tcp://127.0.0.1:61616','','');
		stomp_begin($link,'Transaction');
		$flg=stomp_send($link,$destination,$msg_data );
		if(!$flg){
			throw new \Exception($flg);
		}
		stomp_commit($link,'Transaction');*/
	/* connection */
	$brokerURL = "tcp://127.0.0.1:61616";
	$link = stomp_connect($brokerURL,'','');

	/* check connection */
	if (!$link) {
		die('Connection failed: ' . stomp_connect_error());
	}

	/* close connection */
	stomp_close($link);
		
	}
	 
	 
	 
     private function getWxAccessToken(){
         $test = new \Org\Util\http();
         if ( $_SESSION['access_token'] && $_SESSION['expire_time'] > time() ) {
             //未过期
             return $_SESSION['access_token'];
         }else {
             $appid        = "wx7ebc59cd66cd5ac1";
             $appsecret = "964bfd7b19d406c0b7fe26f28ea28917";
             $url          = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential";
             $data ='&appid='.$appid.'&secret='.$appsecret;
             $res =$test->http($url,$data,'GET');
             $jsoninfo = json_decode($res, true);
             $access_token = $jsoninfo["access_token"];
             //将重新获取到的access_token存到session里
             $_SESSION['access_token']=$access_token;
             $_SESSION['expire_time']=time()+7200;
             return $access_token;
         }
     }
	 public function addUser(){
         header("Content-type: text/html; charset=utf-8");
         $http = new \Org\Util\http();
         $data = '{
             "button":[
             {
                  "type":"click",
                  "name":"首页",
                  "key":"home"
              },
              {
                   "type":"click",
                   "name":"简介",
                   "key":"introduct"
              },
              {
                   "name":"菜单",
                   "sub_button":[
                    {
                       "type":"click",
                       "name":"天气",
                       "key":"V1001_HELLO_WORLD"
                    },
                    {
                       "type":"click",
                       "name":"地图",
                       "key":"V1001_GOOD"
                    }]
               }]
            }';
        $assess_token = $this->getWxAccessToken();
        define("ACCESS_TOKEN","iQt7e45SEtvOy925VL46on5zGooori6X8adaH1wSq6q7Baf4Op2PvgmV0P_u1geRk91jeuzWozP5AyWyKyzAJYA4HFG7PyvXfnVv8A3EJxCqiJbdYG65aE8ZetwJpCsyOMPfACAGEH");
        $id = intval($_REQUEST['id']);
        switch ($id){
            case 1 :
                $createMenu = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token='.$assess_token;
                $result = $http->http($createMenu,$data,'POST');
                break;
            case 2 :
                $str='';
                $deleteMenu = 'https://api.weixin.qq.com/cgi-bin/menu/delete?access_token='.$assess_token;
                $result = $http->http($deleteMenu,$str,'GET');
                break;
            case 3 :
                $weatherArray = $this->getWeatherInfo("北京天气");
                break;
            case 4 :
                $SA_IP=$this->getip();
                $city = $this->getIPLoc_sina($SA_IP);
                break;
        }

         $this->display("elements");
	 }

     function getWeatherInfo($cityName){
         if ($cityName == "" || (strstr($cityName, "+"))) {
             return "发送天气+城市，例如'天气深圳'";
         }//用户查询天气,回复关键词 规则
         $url = "http://api.map.baidu.com/telematics/v3/weather?location=" . urlencode($cityName) . "&output=json&ak=QqMBUR5doRNG2QDSeuX6usPEDNVPe5y6";//QqMBUR5doRNG2QDSeuX6usPEDNVPe5y6   yToPd6SecHAXD8x0uU8zzkyn3iO4U44H
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
         $weatherArray[] = array("Title" => $weather['currentCity'] . "当前天气:" . "温度:" . $weather['weather_data'][0]['temperature'] . "," . $weather['weather_data'][0]['weather'] . "," . "风力:" . $weather['weather_data'][0]['wind'] . ".", "Description" => "", "PicUrl" => "http://weixin.51pcjq.com/img/weather_bg.jpg", "Url" => "");
         for ($i = 0; $i < count($weather["weather_data"]); $i++) {
             $weatherArray[] = array("Title" => $weather["weather_data"][$i]["date"] . "\n" . $weather["weather_data"][$i]["weather"] . " " . $weather["weather_data"][$i]["wind"] . " " . $weather["weather_data"][$i]["temperature"] . "", "Description" => "", "PicUrl" => (($curHour >= 6) && ($curHour < 18)) ? $weather["weather_data"][$i]["dayPictureUrl"] : $weather["weather_data"][$i]["nightPictureUrl"], "Url" => "");
         }
         return $weatherArray;
     }

	 public function getString(){
		$test = new \Org\Util\http();
		define('selectUrl','http://localhost:8080/yzt_service/testDemo/getJDk');	 		 	
	 	//$result = $test->http(selectUrl,$data,'POST');


	 	$mysql_hostname = "localhost";
		$mysql_user = "root";
		$mysql_password = "";
		$mysql_database = "think";
		$prefix = "";
		$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Opps some thing went wrong");
		mysql_query("SET NAMES 'UTF8'",$bd);
		mysql_select_db($mysql_database, $bd) or die("Opps some thing went wrong");

		$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;        //获取当前页码 没有的话 就是第一页
		if(!preg_match('/^\d+$/',$page) || $page < 1) $page = 1;        //如果输入的不是数字  或者小于1 默认第一页

		$pageSize = 2;        //每页多少条

		$query_pag_num = "SELECT COUNT(*) AS count FROM `admin`";
		$result_pag_num = mysql_query($query_pag_num);
		$row = mysql_fetch_array($result_pag_num);
		$count = $row['count'];        //返回记录总条数
		$no_of_paginations = ceil($count / $pageSize);        //计算出总页数

		if($page > $no_of_paginations) $page = $no_of_paginations;        //如果请求页码大于总页数 默认最后一页

		$start = ($page - 1) * $pageSize;        //sql查询起始位置

		$query_pag_data = "SELECT id,username,password from `admin` LIMIT $start, $pageSize";
		$result_pag_data = mysql_query($query_pag_data) or die('MySql Error' . mysql_error());
		$arrList = array();        //初始化列表数组
		while($row = mysql_fetch_array($result_pag_data)){
		        array_push($arrList, array("id" => $row['id'],"username" => $row['username'],"password" => $row['password']));        //将每条信息push到列表数组中
		}

		$array = array(
		        "count" => $count,        //总条数
		        "pageSize" => $pageSize,        //每页条数
		        "pageCount" => $no_of_paginations,  //总页数
		        "thisPage" => $page,//当前页码
		        "list" => $arrList        //列表
		);
		echo json_encode ($array);        //输出json






	 	//echo $result;
	 	//$this->ajaxReturn($result);
	 }

     function getip(){
         $user_IP = ($_SERVER["HTTP_VIA"]) ? $_SERVER["HTTP_X_FORWARDED_FOR"] : $_SERVER["REMOTE_ADDR"];
         $user_IP = ($user_IP) ? $user_IP : $_SERVER["REMOTE_ADDR"];
         $URL='http://ip.taobao.com/service/getIpInfo.php?ip='.$user_IP;
         $fcontents = file_get_contents("$URL");
         $contents=json_decode($fcontents);
     }
     function getIPLoc_sina($queryIP){
         $url = 'http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=json&ip=' . $queryIP;
         $ch = curl_init($url);//初始化url地址
         curl_setopt($ch, CURLOPT_ENCODING, 'utf8');//设置一个cURL传输选项
         curl_setopt($ch, CURLOPT_TIMEOUT, 10);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // 获取数据返回
         $location = curl_exec($ch);//执行一个cURL会话
         $location = json_decode($location);//对 JSON 格式的字符串进行编码
         curl_close($ch);//关闭一个cURL会话
         $loc = "";
         if ($location === FALSE) return "地址不正确";
         if (empty($location->desc)) {
             $loc = $location->city;
         } else { $loc = $location->desc;}
         return $loc;
     }
 }
