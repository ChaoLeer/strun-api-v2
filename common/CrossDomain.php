<?php
  /**
   * 跨域处理
   */
  header('Access-Control-Allow-Origin: *');
  header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, USERID");
  header('Access-Control-Allow-Methods: GET, POST, PUT,DELETE,OPTIONS');
  header("Content-Type:application/json;charset=UTF-8");
?>