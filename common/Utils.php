<?php
  class Utils {
    public function getParams($key, $def = null) {
      $post     = file_get_contents('php://input');
      $postData = json_decode($post, true);
      return isset($postData[$key]) ? trim($postData[$key]) : $def;
    }
    public function getGetParams($key, $def = null) {
      $get     = $_GET;
      return isset($get[$key]) ? trim($get[$key]) : $def;
    }
  }
?>