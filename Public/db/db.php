<?php
class MySQLDB {
    private $link = null;   #用于存储连接数据库成功后的“资源”
    protected $host;
    protected $port;
    protected $user;
    protected $password;
    protected $charset;
    protected $dbname;

    /**
    单例实现
    //*/
    private static $instance = null;    #用于存储该类的唯一实例
    private function __clone(){}    #禁止该类的实例对象进行克隆复制对象
    #对外提供一个创建该类实例的方法
    public static function getInstance($config){
        if(!(static::$instance instanceof self)){
            static::$instance = new self($config);
        }
        return static::$instance;
    }
    #实现单例的基础：私有化该类的构造方法
     function __construct($config){
        $this->host = isset($config['DB_HOST'])?$config['DB_HOST']:'localhost';
        $this->port = isset($config['DB_PORT'])?$config['DB_PORT']:'3306';
        $this->user = isset($config['DB_USER'])?$config['DB_USER']:'root';
        $this->password = isset($config['DB_PWD'])?$config['DB_PWD']:'root';
        $this->charset = 'utf8';
        $this->dbname = isset($config['DB_NAME'])?$config['DB_NAME']:'db_mvc';

        $this->link = @mysql_connect(
            "{$this->host}:{$this->port}","{$this->user}","$this->password")
        or die(连接失败！);

        $this->selectDB($this->dbname);
        $this->setCharset($this->charset);
    }

    public function setCharset($charset){#1设置连接环境字符编码
        $sql = "set names {$charset}";
        $this->query($sql);
    }

    public function selectDB($dbname){#2选择要操作的数据库
        $sql = "use {$dbname}";
        $this->query($sql);
    }

    public function closeDB(){#3关闭数据库连接
        if(isset($this->link)){
            mysql_query($this->link);
        }
    }

    public function execute($sql){#增删改
        $this->query($sql);
        return true;
    }

    public function getData($sql){#返回结果是一个标量值
        $result = $this->query($sql);
        $num = mysql_fetch_array($result);
        mysql_free_result($result);
        return $num[0];
    }

    public function getRow($sql){#返回结果是一个一维数组
        $result = $this->query($sql);
        $row = mysql_fetch_array($result);
        mysql_free_result($result);
        return $row;
    }

    public function getRows($sql){#返回结果是一个二维数组
        $result = $this->query($sql);
        $arr = array();
        while($row = mysql_fetch_array($result)){
            $arr[] = $row;
        }

       if(!mysql_free_result($result)){
           echo "代码执行错误！请参考如下提示：";
           echo "<br />错误代号：".mysql_errno();
           echo "<br />错误内容：".mysql_error();
           echo "<br />错误代码：".$sql;

           die();
       }

        return $arr;
    }

    public function query($sql){#错误处理并返回一个结果集
        $result = mysql_query($sql);
        if($result === false){
            echo "代码执行错误！请参考如下提示：";
            echo "<br />错误代号：".mysql_errno();
            echo "<br />错误内容：".mysql_error();
            echo "<br />错误代码：".$sql;

            die();
        }
        return $result;
    }
}
?>