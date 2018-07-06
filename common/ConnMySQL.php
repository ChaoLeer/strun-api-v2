<?php
// 连接数据库（单例模式）
class ConnMySQL {
  protected static $_connect = null;
  protected $dbName;
  protected $dsn;
  protected $pdoObj;

  // 初始化
  private function __construct($host, $user, $pwd, $dbName) {
    try {
      $this->dsn = 'mysql:host='.$host.';dbname='.$dbName;
      $this->pdoObj = new PDO($this->dsn, $user, $pwd);
      $this->pdoObj->query("set names utf8");
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }

  // 防止克隆
  private function __clone(){}

  // 返回一个实例化的PDO对象
  public static function makeConnect($host, $user, $pwd, $dbName) {
    if (self::$_connect === null) {
      self::$_connect = new self($host, $user, $pwd, $dbName);
    }
    return self::$_connect;
  }

  // 定义查询方法
  public function query($db, $sqlState = null, $sqlVal=null) {
    if(!$sqlState) {
      $_result = $this->pdoObj->query("select * from $db;");
    } else {
      $_result = $this->pdoObj->query("select * from $db where $sqlState like '%".trim($sqlVal)."%';");
    }
    return $_result;
  }
  // 分页查询
  public function queryPage($db, $start = null, $end=null, $term="") {
    if(empty($term)) {
      $_result = $this->pdoObj->query("select * from $db ORDER BY CREATE_DATE DESC LIMIT $start , $end;");
    } else {
      $_result = $this->pdoObj->query("select * from $db $term ORDER BY CREATE_DATE DESC LIMIT $start , $end;");
    }
    // print_r("select * from $db $term ORDER BY CREATE_DATE DESC LIMIT $start , $end;");
    return $_result;
  }

  // 定义查询方法
  public function querybykey($db, $sqlState = null, $sqlVal=null) {
    if(!$sqlState) {
      $_result = $this->pdoObj->query("select * from $db;");
    } else {
      $_result = $this->pdoObj->query("select * from $db where $sqlState = '".trim($sqlVal)."';");
    }
    // print_r("select * from $db where $sqlState = '".trim($sqlVal)."'");
    return $_result;
  }
  // 自定义SQL语句查询
  public function queryBySql($sql) {
    $_result = $this->pdoObj->exec($sql);
    print_r($sql);
    return $_result;
  }

  // 定义添加方法
  public function insert($db, $where, $what) {
    $_result = $this->pdoObj->exec("insert into $db ($where) values ($what);");
    return $_result;
  }
  // 自定义SQL语句插入
  public function insertBySql($db, $sql) {
    $_result = $this->pdoObj->exec("insert into $db $sql;");
    // print_r("insert into $db $sql;");
    return $_result;
  }
  // 定义删除方法
  public function delete($db, $where) {
    $_result = $this->pdoObj->exec("delete from $db where $where;");
    return $_result;
  }

  // 定义更新方法
  public function updata($db, $what, $where) {
    $_result = $this->pdoObj->exec("update $db set $what where $where;");
    return $_result;
  }
  // 自定义SQL语句更新方法
  public function updataBySql($db, $sql, $where=null) {
    if(!$where) {
      $_result = $this->pdoObj->exec("update $db set $sql;");
    } else {
      $_result = $this->pdoObj->exec("update $db set $sql where $where;");
    }
    print_r("update $db set $sql where $where;");
    return $_result;
  }

  // 断开和数据库链接
  public function destruct() {
    $this->pdoObj = null;
  }
}
?>