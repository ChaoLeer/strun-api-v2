<?php
  class Utils {
    public function getParams($key, $def = null, $magic = false) {
      $post     = file_get_contents('php://input');
      $postData = json_decode($post, true);
      if ($magic) {
        if (!get_magic_quotes_gpc()) {
          $postData[$key]=addslashes($postData[$key]);
        }
      }
      return isset($postData[$key]) ? trim($postData[$key]) : $def;
    }
    public function getGetParams($key, $def = null) {
      $get     = $_GET;
      return isset($get[$key]) ? trim($get[$key]) : $def;
    }
  }
?>