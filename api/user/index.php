<?php
  include('../../common/Config.php');
  $method = $_SERVER['REQUEST_METHOD'];
  switch ($method) {
    case 'GET':
      # code...
      echo 'get';
      break;
    default:
      # code...
      break;
  }
  echo json_encode($_REQUEST);
  echo json_encode($_SERVER['REQUEST_METHOD']);
?>