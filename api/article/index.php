<?php
include '../../common/Header.php';
include './ArticleController.php';
$utils = new Utils();
$response = new Response();
$header = new Header();
$articleController = new ArticleController();

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
        $articleController->getAllArticleListByPage($pdo, $page, $row, $authorId, $classify, $searchInfo);
      } else {
        // 通过id获取单个
        $id = $_GET['id'];
        $articleController->getArticleByArticleId($pdo, $id);
      }
    } else {
      // 获取全部
      $articleController->getAllArticles($pdo);
    }
    break;
  // 新增
  case 'POST':
    if ($apiUrl) {
      $response->responseExeption('url路径404');
    } else {
      $authorId = $utils -> getParams('authorId', '');
      $title = $utils -> getParams('title', '');
      $author = $utils -> getParams('author', '');
      $articleintro = $utils -> getParams('articleintro', '', true);
      $content = $utils -> getParams('content', '', true);
      $classify = $utils -> getParams('classify', '');
      if (empty($authorId)) {
        $response->responseExeption('缺少参数authorId');
      }
      $articleController->insertArticle($pdo, $authorId, $title,$author, $articleintro,$content, $classify);
    }
    // if ($pathArr[1]) {
    // } else  {
    //   $page       = getParams('page', 1);
    //   $userId     = getParams('userId', '');
    //   $classify   = getParams('classify', '');
    //   $searchInfo = getParams('searchInfo', '');
    //   $row        = getParams('row', 10);
    //   $articleController->getAllArticleListByPage($pdo, $page, $row, $userId, $classify, $searchInfo);
    // }
    break;
    // 新增
  case 'PUT':
    if ($apiUrl) {
      $userId = $header->getUserId();
      // $userId = $utils -> getParams('userId', '');
      // $articleId = $utils -> getParams('articleId', '');
      $articleId = $apiUrl[1];
      $title = $utils -> getParams('title', null);
      $author = $utils -> getParams('author', null);
      $authorId = $utils -> getParams('authorId', null);
      $articleIntro = $utils -> getParams('articleIntro', null);
      $content = $utils -> getParams('content', null);
      $classify = $utils -> getParams('classify', null);
      if (empty($articleId)) {
        $response->responseExeption('缺少参数articleId');
      }
      if (empty($authorId)) {
        $response->responseExeption('缺少参数authorId');
      }
      if ($userId !== $authorId) {
        $response->responseExeption('修改失败，请联系文章作者修改！');
      }
      $articleController -> updateArticle($pdo, $articleId, $title, $articleIntro, $content, $classify);
    } else {
      $response->responseExeption('缺少参数articleId');
    }
    // $articleController->insertArticle($pdo, $userId, $title,$author, $articleintro,$content, $classify);
  break;
  // 删除文章
  case 'DELETE':
    if ($apiUrl) {
      $userId = $header->getUserId();
      $articleId = $apiUrl[1];
      if ($articleId) {
        $articleController -> deleteArticle($pdo, $userId, $articleId);
      }
    } else {
      $response->responseExeption('缺少参数articleId');
    }
    // $articleController->insertArticle($pdo, $userId, $title,$author, $articleintro,$content, $classify);
  break;
  default:
    # code...
    break;
}
?>