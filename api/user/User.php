<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | PHP version 5                                                        |
// +----------------------------------------------------------------------+
// | Copyright (c) 1997-2004 The PHP Group                                |
// +----------------------------------------------------------------------+
// | This source file is subject to version 3.0 of the PHP license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available through the world-wide-web at the following url:           |
// | http://www.php.net/license/3_0.txt.                                  |
// | If you did not receive a copy of the PHP license and are unable to   |
// | obtain it through the world-wide-web, please send a note to          |
// | license@php.net so we can mail you a copy immediately.               |
// +----------------------------------------------------------------------+
// | Authors: Original Author <author@example.com>                        |
// |          Your Name <you@example.com>                                 |
// +----------------------------------------------------------------------+
//
// $Id:$
/*
 * RESTful
 * RESTful 服务类
*/
Class User {
    // private $users = array();
    //  登录
    public function login($pdo, $username) {
        $result = $pdo->querybykey('strun_userinfo', 'USER_NAME', $username);
        $resultList = $result->fetchAll(PDO::FETCH_ASSOC);
        return $resultList;
    }
    // 获取所有文章列表
    public function getAllUsers($pdo) {
      $result = $pdo->query('strun_user');
      $listAll = $result->fetchAll(PDO::FETCH_ASSOC);
      return $listAll;
    }
    // 分页获取
    public function getAllUserListByPage($pdo, $page, $row, $authorId, $userType,$searchInfo) {
      if ($page == 1) {
        $start = $page - 1;
      } else {
        $start = ($page - 1)*$row;
      }
      $end = $page*$row;
      $term = "WHERE";
      if (!empty($authorId)) {
        $term = $term." USER_ID='".$authorId."' ";
      }
      if (!empty($userType)) {
        if (!empty($authorId) || !empty($searchInfo)) {
          $term = $term." AND";
        }
        $term = $term." CLASSIFY='".$userType."' ";
      }
      if (!empty($searchInfo)) {
        if (!empty($authorId) || !empty($userType)) {
          $term = $term." AND";
        }
        $term =$term." (TITLE LIKE '%".$searchInfo."%' OR CLASSIFY LIKE '%".$searchInfo."%') ";
      }
      if ($term == "WHERE") {
        $term = "";
      }
      // $get_sql = "SELECT ARTICLE_ID,AUTHOR,CLASSIFY,TITLE,ARTICLE_INTRO,USER_ID,CREATE_DATE FROM strun_user ".$term." ORDER BY CREATE_DATE DESC LIMIT ".$start.",".$end;
      $result = $pdo -> queryPage('strun_user', $start, $end, $term);
      $resultList = $result->fetchAll(PDO::FETCH_ASSOC);
      return $resultList;
    }
    // 通过文章id查文章
    public function getUserByUserId($pdo, $id) {
        $result = $pdo->querybykey('strun_user', 'ARTICLE_ID', $id);
        $resultList = $result->fetchAll(PDO::FETCH_ASSOC);
        return $resultList;
    }
    // 判断是否有权限删除当前文章
    public function userId($pdo, $id, $userId) {
        $result = $pdo->querybykey('strun_user', 'ARTICLE_ID', $userId);
        $resultList = $result->fetchAll(PDO::FETCH_ASSOC);
        return $resultList;
    }
    // // 通过用户id查文章列表
    // public function getUserListByUserId($id) {
    //     $user_sql = "SELECT ARTICLE_ID,AUTHOR,CLASSIFY,TITLE,ARTICLE_INTRO,USER_ID,CREATE_DATE from strun_user WHERE USER_ID='".$id."' ORDER BY CREATE_DATE DESC";
    //     $mysql = new MySQL();
    //     $con = $mysql -> connectSQL();
    //     $user_list_temp = $mysql -> getDatas($con, $user_sql);
    //     $this->users = $user_list_temp;
    //     return $this->users;
    // }
    // // 搜索文章
    // public function searchUser($searchInfo) {
    //     $user_sql = "SELECT ARTICLE_ID,AUTHOR,CLASSIFY,TITLE,ARTICLE_INTRO,USER_ID,CREATE_DATE FROM strun_user WHERE TITLE LIKE '%".$searchInfo."%' OR CLASSIFY LIKE '%".$searchInfo."%' ORDER BY CREATE_DATE DESC";
    //     $mysql = new MySQL();
    //     $con = $mysql -> connectSQL();
    //     $user_list_temp = $mysql -> getDatas($con, $user_sql);
    //     $this->users = $user_list_temp;
    //     return $this->users;
    // }
    // // 新增文章
    public function insertUser($pdo, $authorId, $title,$author, $userintro,$content, $classify) {
        $insert_sql = "(
                        `ARTICLE_ID`,
                        `AUTHOR`,
                        `USER_ID`,
                        `AUTHOR_ID`,
                        `TITLE`,
                        `CONTENT`,
                        `CREATE_DATE`,
                        `ARTICLE_INTRO`,
                        `IS_LOCKED`,
                        `IS_DEL`,
                        `STAR`,
                        `FOLLOW`,
                        `TYPE`,
                        `CLASSIFY`,
                        `EXT1`,
                        `EXT2`,
                        `EXT3`
                      )
                      VALUES
                        (
                          (SELECT
                            REPLACE(UUID(),'-','')),
                            '".$author."',
                            '".$authorId."',
                            '".$authorId."',
                            '".$title."',
							'".$content."',
							(select now()),
                            '".$userintro."',
                            NULL,
                            NULL,
                            NULL,
                            NULL,
                            NULL,
                            '".$classify."',
                            NULL,
                            NULL,
                            NULL
                        )";
        // $mysql = new MySQL();
        // $con = $mysql -> connectSQL();
        // $insert_res = $mysql -> insert($con, $insert_sql);
        $insert_res = $pdo->insertBySql('strun_user', $insert_sql);
        return $insert_res;
    }
    // 更新修改文章
    public function updateUser($pdo, $userId, $title, $userintro, $content, $classify) {
      // print_r($content);
      $update_sql = "";
      if ($title) {
        $update_sql = $update_sql."`TITLE`='".$title."',";
      }
      if ($content) {
        $update_sql = $update_sql."`CONTENT`='".$content."',";
      }
      if ($userintro) {
        $update_sql = $update_sql."`ARTICLE_INTRO`='".$userintro."',";
      }
      if ($classify) {
        $update_sql = $update_sql."`CLASSIFY`='".$classify."',";
      }
      $update_sql = substr($update_sql, 0, -1);
      $where = "`ARTICLE_ID`='$userId'";
      $update_res = $pdo -> updataBySql('strun_user', $update_sql, $where);
      // echo $update_res;
      print_r($update_res);
      return $update_res;
    }
    // 删除文章
    public function deleteUser($pdo, $userId, $userId) {
      // print_r($content);
      // $result = $pdo -> querybykey("strun_user", "ARTICLE_ID", $userId);
      // $queryResult = $result->fetchAll(PDO::FETCH_ASSOC);
      // print_r($queryResult);
      // if ($queryResult['AUTHOR_ID']) {
      //   # code...
      // }
      $where = "`ARTICLE_ID`='$userId' AND `AUTHOR_ID`='$userId';";
      // $result = $pdo -> queryBySql("select * from strun_user where `ARTICLE_ID`='$userId' AND `AUTHOR_ID`='$userId';");
      // $queryResult = $result->fetchAll(PDO::FETCH_ASSOC);
      // if (empty($queryResult)) {
      //   # code...
      // } else {
      // }
      $update_res = $pdo -> delete('strun_user', $where);
      return $update_res;
    }
}
?>
