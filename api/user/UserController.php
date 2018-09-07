<?php
require_once ("./User.php");
class UserController extends Rest {
  //  登录
  public function login($pdo, $username, $password) {
      $user = new User();
      $rawData = $user->login($pdo, $username);
      $Response = new Response();
      $validateRes = array();
      if (empty($rawData)) {
        $validateRes = array(
            'message' => 'No users found!'
        );
      } else {
        if ($rawData[0]['PASSWORD'] !== $password) {
          $validateRes = array(
            'message' => 'password is error'
          );
          $rawData = array();
        }
      }
      $Response -> responseSingleData($rawData, $validateRes);
  }
  // 获取所有文章列表
  public function getAllUsers($pdo) {
      $user = new User();
      $rawData = $user->getAllUsers($pdo);
      $Response = new Response();
      $notFoundRes = array(
          'message' => 'No users found!'
      );
      $Response -> responseDatas($rawData, $notFoundRes);
  }
  // 分页获取
  public function getAllUserListByPage($pdo, $page, $row, $userId,$classify,$searchInfo) {
    $user = new User();
    $rawData = $user->getAllUserListByPage($pdo, $page, $row, $userId,$classify,$searchInfo);
    $Response = new Response();
    $notFoundRes = array(
        'message' => 'No users found!'
    );
    $Response -> responseDatas($rawData, $notFoundRes);
  }
  // 通过文章id查文章
  public function getUserByUserId($pdo, $id) {
      $user = new User();
      $rawData = $user->getUserByUserId($pdo, $id);
      $Response = new Response();
      $notFoundRes = array(
          'message' => 'No users found!'
      );
      $Response -> responseDatas($rawData, $notFoundRes);
  }
  // 新增文章
  public function insertUser($pdo, $authorId, $title,$author, $articleintro,$content, $classify) {
      $user = new User();
      $insertResult = $user->insertUser($pdo, $authorId, $title,$author, $articleintro, $content, $classify);
      // echo ($insertResult);
      $Response = new Response();
      $faildMessage = array(
          'message' => '新增失败！'
      );
      $Response -> responseInsertResult($insertResult, $faildMessage);
  }
  // 更新修改文章($pdo, $articleId, $title, $articleintro, $content, $classify)
  public function updateUser($pdo, $articleid, $title, $articleintro,$content, $classify) {
      print_r($title);
      $user = new User();
      $updateResult = $user->updateUser($pdo, $articleid, $title, $articleintro, $content, $classify);
      $Response = new Response();
      $faildMessage = array(
          'message' => '更新失败！'
      );
      $Response -> responseUpdateResult($updateResult, $faildMessage);
  }
  // 删除文章
  public function deleteUser($pdo, $userId, $articleId) {
      $user = new User();
      $deleteResult = $user->deleteUser($pdo, $userId, $articleId);
      $Response = new Response();
      $faildMessage = array(
          'message' => '删除失败！'
      );
      $Response -> responseDeleteResult($deleteResult, $faildMessage);
  }
}

?>