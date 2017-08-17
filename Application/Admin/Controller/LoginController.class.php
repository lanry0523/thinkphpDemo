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
		 $test = new \Org\Util\UrlUtil();
		 $list1 = array("uname"=>"张三","pwd"=>"1234qwer","token"=>"xiaowei");
		 $dataArray = 
		 array("uname"=>"admin","passwd"=>"张三","token"=>"xiaowei");//register				

    	$str=$test->JSON($dataArray);
		//$str = '?uname=xs&age=6&token=xiaowei';
		
		 
		define('loginUrl','http://localhost:8080/yzt_service/testDemo/land');

	 	$result = $test->http(loginUrl,$str,'POST');
		
		// echo json_encode($dataArray),'<br>';
		 if (strcmp($result,'SUCCESS')==0) {
		 	$this->success('登录成功',U("Login/homeList"),1);//redirect:""
		 } else {
		 	$this->error('登录失败返回登陆页.....',U('Login/index'));
		 }		 
		 
	 }
 
	 public function addUser(){
		 $uid = I('id');
		 $uName = I('username');
		 $uPass = md5(I('password'));
		 
		 $data['id'] = $uid;
		 $data['username'] = $uName;
		 $data['password'] = $uPass;
		 $db = M('admin');		 
		 
		 $result = $db -> add($data);
		 
		 if($result){
			$this->redirect("Login/homeList","添加成功"); 
		 }else{
			 $this->error("添加失败");
		 }
		 
	 }

	 public function getString(){
		$test = new \Org\Util\UrlUtil();	 	
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
	 
	 
 }
