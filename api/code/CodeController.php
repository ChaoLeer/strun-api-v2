<?php
require_once ("./Code.php");
class CodeController extends Rest {
  // 获取所有code列表
  public function getAllCodes($pdo) {
      $code = new Code();
      $rawData = $code->getAllCodes($pdo);
      $Response = new Response();
      $notFoundRes = array(
          'error' => 'No code found!'
      );
      $Response -> responseDatas($rawData, $notFoundRes);
  }
  // 分页获取
  // public function getAllArticleListByPage($page,$userId,$classify,$searchInfo) {
  //   $articles = new Article();
  //   $rawData = $articles->getAllArticleListByPage($page,$userId,$classify,$searchInfo);
  //   $Response = new Response();
  //   $notFoundRes = array(
  //       'error' => 'No articless found!'
  //   );
  //   $Response -> responseDatas($rawData, $notFoundRes);
  // }
  // 通过code type查code
  public function getCodeByType($pdo, $parmas) {
      $code = new Code();
      $rawData = $code->getCodeByType($pdo, $parmas);
      $Response = new Response();
      $notFoundRes = array(
          'error' => 'No code found!'
      );
      $Response -> responseDatas($rawData, $notFoundRes);
  }
  // // 新增文章
  // public function insertArticle($userid, $title,$author, $articleintro,$content, $classify) {
  //     $articles = new Article();
  //     $insertResult = $articles->insertArticle($userid, $title,$author, $articleintro,$content, $classify);
  //     // echo ($insertResult);
  //     $Response = new Response();
  //     $notFoundRes = array(
  //         'message' => '提交失败！'
  //     );
  //     $Response -> responseInsertResult($insertResult, $notFoundRes);
  // }
  // // 更新修改文章
  // public function updateArticle($articleid,$userid, $title,$author, $articleintro,$content, $classify) {
  //     $articles = new Article();
  //     $updateResult = $articles->updateArticle($articleid,$userid, $title,$author, $articleintro,$content, $classify);
  //     // echo ($updateResult);
  //     $Response = new Response();
  //     $notFoundRes = array(
  //         'message' => '提交失败！'
  //     );
  //     $Response -> responseUpdateResult($updateResult, $notFoundRes);
  // }
}

?>