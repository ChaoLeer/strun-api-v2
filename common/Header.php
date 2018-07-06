<?php
  include "CrossDomain.php";
  include "ConnMySQL.php";
  include "Config.php";
  include "Rest.php";
  include "Response.php";
  include "Utils.php";
  $pdo = ConnMySQL::makeConnect(MYSQL_HOST, MYSQL_USER, MYSQL_PWD, MYSQL_DBNAME);
  // print_r(NOW);
  date_default_timezone_set("PRC");
  $now = date('yyyy-mm-dd');
  class Header extends Response{
    // 获取头信息userid
    public function getUserId() {
      $userId = '';
      $method = $this->getMethod();
      if (isset($_SERVER['HTTP_USERID'])) {
        $userId = $_SERVER['HTTP_USERID'];
        return $userId;
      }
      if (!$userId && $method !== 'OPTIONS') {
        # code...
        $this->responseExeption('缺少头信息USERID');
      }
    }
    // 获取请求类型
    public function getMethod() {
      return $_SERVER['REQUEST_METHOD'];
    }
    // 获取router
    public function getApiUrl() {
      $path = '';
      if (isset($_SERVER['PATH_INFO'])) {
        $path = $_SERVER['PATH_INFO'];
      }
      // $path = $_SERVER['PATH_INFO'];
      $pathArr = explode('/', $path);
      return count($pathArr) <= 1 ? null : $pathArr;
    }
    // public static function getUserId() {
    //   return $_SERVER['HTTP_USERID'];
    // }
  }
?>