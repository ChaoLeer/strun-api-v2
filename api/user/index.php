<?php
include '../../common/Header.php';
include './UserController.php';
$utils = new Utils();
$response = new Response();
$header = new Header();
$userController = new UserController();

// $method = $_SERVER['REQUEST_METHOD'];
// $path   = '';
// if (isset($_SERVER['PATH_INFO'])) {
//   $path = $_SERVER['PATH_INFO'];
// }
// $pathArr = explode('/', $path);
// if (count($pathArr) >= 1) {
// }
// print_r($header->getUserId());
$method = $header->getMethod();
$apiUrl = $header->getApiUrl();
$redict  = $utils -> getGetParams('redict');
// exit($_GET['id']);
// $apiUrl = count($pathArr) == 1 ? null : $pathArr[1];
switch ($method) {
  // 获取文章
  case 'GET':
    if ($_GET['redict']) {
      // 分页、条件查询获取文章
      if ($_GET['redict'] == 'page') {
        $page       = $utils -> getGetParams('page', 1);
        $authorId     = $utils -> getGetParams('authorId', '');
        $classify   = $utils -> getGetParams('classify', '');
        $searchInfo = $utils -> getGetParams('searchInfo', '');
        $row        = $utils -> getGetParams('row', 10);
        $userController->getAllUserListByPage($pdo, $page, $row, $authorId, $classify, $searchInfo);
      } else {
        // 通过id获取单个
        $id = $_GET['id'];
        $userController->getUserByUserId($pdo, $id);
      }
    } else {
      // 获取全部
      $userController->getAllUsers($pdo);
    }
    break;
  // 新增
  case 'POST':
    $modifyType = $utils -> getParams('type', '');
    if ($apiUrl) {
      $response->responseExeption('路径404');
    } else {
      if ($modifyType == 'login') {
        $username = $utils -> getParams('username', '');
        $password = $utils -> getParams('password', '');
        if (empty($username)) {
          $response->responseExeption('用户名不能为空');
        }
        if (empty($password)) {
          $response->responseExeption('密码不能为空');
        }
        $userController->login($pdo, $username, $password);
      }
      // $authorId = $utils -> getParams('authorId', '');
      // $title = $utils -> getParams('title', '');
      // $author = $utils -> getParams('author', '');
      // $userintro = $utils -> getParams('userintro', '');
      // $content = $utils -> getParams('content', '');
      // $classify = $utils -> getParams('classify', '');
      // if (empty($authorId)) {
      //   $response->responseExeption('缺少参数authorId');
      // }
      // $userController->insertUser($pdo, $authorId, $title,$author, $userintro,$content, $classify);
    }
    break;
    // 新增
  case 'PUT':
    if ($apiUrl) {
      $userId = $header->getUserId();
      // $userId = $utils -> getParams('userId', '');
      // $userId = $utils -> getParams('userId', '');
      $userId = $apiUrl[1];
      $title = $utils -> getParams('title', null);
      $author = $utils -> getParams('author', null);
      $authorId = $utils -> getParams('authorId', null);
      $userIntro = $utils -> getParams('userIntro', null);
      $content = $utils -> getParams('content', null);
      $classify = $utils -> getParams('classify', null);
      if (empty($userId)) {
        $response->responseExeption('缺少参数userId');
      }
      if (empty($authorId)) {
        $response->responseExeption('缺少参数authorId');
      }
      if ($userId !== $authorId) {
        $response->responseExeption('修改失败，请联系文章作者修改！');
      }
      $userController -> updateUser($pdo, $userId, $title, $userIntro, $content, $classify);
    } else {
      $response->responseExeption('缺少参数userId');
    }
    // $userController->insertUser($pdo, $userId, $title,$author, $userintro,$content, $classify);
  break;
  // 删除文章
  case 'DELETE':
    if ($apiUrl) {
      $userId = $header->getUserId();
      $userId = $apiUrl[1];
      if ($userId) {
        $userController -> deleteUser($pdo, $userId, $userId);
      }
    } else {
      $response->responseExeption('缺少参数userId');
    }
    // $userController->insertUser($pdo, $userId, $title,$author, $userintro,$content, $classify);
  break;
  default:
    # code...
    break;
}
?>