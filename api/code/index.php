<?php
  include('../../common/Header.php');
  include('./CodeController.php');
  $utils = new Utils();
  $response = new Response();
  $header = new Header();
  $code = new CodeController();

  $method = $_SERVER['REQUEST_METHOD'];
  $path = '';
  // if (isset($_SERVER['PATH_INFO'])) {
  //   $path = $_SERVER['PATH_INFO'];
  // }
  // $pathArr = explode('/', $path);
  // exit($_GET['type']);
  // $userId = $header->getUserId();
  $method = $header->getMethod();
  $apiUrl = $header->getApiUrl();
  switch ($method) {
    case 'GET':
      if ($_GET['redict']) {
        if($_GET['redict'] == 'type') {
          // if (count($pathArr) <= 2) {
          //   $response->responseExeption('缺少code类别参数type');
          // } else {
          //   $code -> getCodeByType($pdo, $pathArr[2]);
          // }
          $code -> getCodeByType($pdo, $_GET['type']);
        } else {
          $response->responseExeption('404服务路径');
        }
      } else {
        $code -> getAllCodes($pdo);
      }
      break;
    default:
      # code...
      break;
  }
  // echo json_encode($_REQUEST);
  // echo json_encode($_SERVER['REQUEST_METHOD']);
?>