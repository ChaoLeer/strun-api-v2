<?php
require_once ("./Article.php");
class ArticleController extends Rest {
  // 获取所有文章列表
  public function getAllArticles($pdo) {
      $articles = new Article();
      $rawData = $articles->getAllArticles($pdo);
      $Response = new Response();
      $notFoundRes = array(
          'message' => 'No articless found!'
      );
      $Response -> responseDatas($rawData, $notFoundRes);
  }
  // 分页获取
  public function getAllArticleListByPage($pdo, $page, $row, $userId,$classify,$searchInfo) {
    $articles = new Article();
    $rawData = $articles->getAllArticleListByPage($pdo, $page, $row, $userId,$classify,$searchInfo);
    $Response = new Response();
    $notFoundRes = array(
        'message' => 'No articless found!'
    );
    $Response -> responseDatas($rawData, $notFoundRes);
  }
  // 通过文章id查文章
  public function getArticleByArticleId($pdo, $id) {
      $articles = new Article();
      $rawData = $articles->getArticleByArticleId($pdo, $id);
      $Response = new Response();
      $notFoundRes = array(
          'message' => 'No articless found!'
      );
      $Response -> responseDatas($rawData, $notFoundRes);
  }
  // 新增文章
  public function insertArticle($pdo, $authorId, $title,$author, $articleintro,$content, $classify) {
      $articles = new Article();
      $insertResult = $articles->insertArticle($pdo, $authorId, $title,$author, $articleintro, $content, $classify);
      // echo ($insertResult);
      $Response = new Response();
      $faildMessage = array(
          'message' => '新增失败！'
      );
      $Response -> responseInsertResult($insertResult, $faildMessage);
  }
  // 更新修改文章($pdo, $articleId, $title, $articleintro, $content, $classify)
  public function updateArticle($pdo, $articleid, $title, $articleintro,$content, $classify) {
      print_r($title);
      $articles = new Article();
      $updateResult = $articles->updateArticle($pdo, $articleid, $title, $articleintro, $content, $classify);
      $Response = new Response();
      $faildMessage = array(
          'message' => '更新失败！'
      );
      $Response -> responseUpdateResult($updateResult, $faildMessage);
  }
  // 删除文章
  public function deleteArticle($pdo, $userId, $articleId) {
      $articles = new Article();
      $deleteResult = $articles->deleteArticle($pdo, $userId, $articleId);
      $Response = new Response();
      $faildMessage = array(
          'message' => '删除失败！'
      );
      $Response -> responseDeleteResult($deleteResult, $faildMessage);
  }
}

?>