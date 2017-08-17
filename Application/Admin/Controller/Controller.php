 <?php
	
		$data = array("uname"=>'admin',"passwd"=>"sendou","token"=>"xiaowei");//register
		define('selectUrl','http://localhost:8080/yzt_service/testDemo/getJDk');
	 	
	 	echo "==============================";
	 	//$test = new \Org\Util\UrlUtil();
	 	$result = \Org\Util\UrlUtil::http(selectUrl,$data,'POST');
?>