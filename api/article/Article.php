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
Class Article {
    // private $articles = array();
    // 获取所有文章列表
    public function getAllArticles($pdo) {
      $result = $pdo->query('strun_article');
      $listAll = $result->fetchAll(PDO::FETCH_ASSOC);
      return $listAll;
    }
    // 分页获取
    public function getAllArticleListByPage($pdo, $page, $row, $authorId, $articleType,$searchInfo) {
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
      if (!empty($articleType)) {
        if (!empty($authorId) || !empty($searchInfo)) {
          $term = $term." AND";
        }
        $term = $term." CLASSIFY='".$articleType."' ";
      }
      if (!empty($searchInfo)) {
        if (!empty($authorId) || !empty($articleType)) {
          $term = $term." AND";
        }
        $term =$term." (TITLE LIKE '%".$searchInfo."%' OR CLASSIFY LIKE '%".$searchInfo."%') ";
      }
      if ($term == "WHERE") {
        $term = "";
      }
      // $get_sql = "SELECT ARTICLE_ID,AUTHOR,CLASSIFY,TITLE,ARTICLE_INTRO,USER_ID,CREATE_DATE FROM strun_article ".$term." ORDER BY CREATE_DATE DESC LIMIT ".$start.",".$end;
      $result = $pdo -> queryPage('strun_article', $start, $end, $term);
      $resultList = $result->fetchAll(PDO::FETCH_ASSOC);
      return $resultList;
    }
    // 通过文章id查文章
    public function getArticleByArticleId($pdo, $id) {
        $result = $pdo->querybykey('strun_article', 'ARTICLE_ID', $id);
        $resultList = $result->fetchAll(PDO::FETCH_ASSOC);
        return $resultList;
    }
    // 判断是否有权限删除当前文章
    public function articleId($pdo, $id, $articleId) {
        $result = $pdo->querybykey('strun_article', 'ARTICLE_ID', $articleId);
        $resultList = $result->fetchAll(PDO::FETCH_ASSOC);
        return $resultList;
    }
    // // 通过用户id查文章列表
    // public function getArticleListByUserId($id) {
    //     $article_sql = "SELECT ARTICLE_ID,AUTHOR,CLASSIFY,TITLE,ARTICLE_INTRO,USER_ID,CREATE_DATE from strun_article WHERE USER_ID='".$id."' ORDER BY CREATE_DATE DESC";
    //     $mysql = new MySQL();
    //     $con = $mysql -> connectSQL();
    //     $article_list_temp = $mysql -> getDatas($con, $article_sql);
    //     $this->articles = $article_list_temp;
    //     return $this->articles;
    // }
    // // 搜索文章
    // public function searchArticle($searchInfo) {
    //     $article_sql = "SELECT ARTICLE_ID,AUTHOR,CLASSIFY,TITLE,ARTICLE_INTRO,USER_ID,CREATE_DATE FROM strun_article WHERE TITLE LIKE '%".$searchInfo."%' OR CLASSIFY LIKE '%".$searchInfo."%' ORDER BY CREATE_DATE DESC";
    //     $mysql = new MySQL();
    //     $con = $mysql -> connectSQL();
    //     $article_list_temp = $mysql -> getDatas($con, $article_sql);
    //     $this->articles = $article_list_temp;
    //     return $this->articles;
    // }
    // // 新增文章
    public function insertArticle($pdo, $authorId, $title,$author, $articleintro,$content, $classify) {
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
                            '".$articleintro."',
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
        $insert_res = $pdo->insertBySql('strun_article', $insert_sql);
        return $insert_res;
    }
    // 更新修改文章
    public function updateArticle($pdo, $articleId, $title, $articleintro, $content, $classify) {
      // print_r($content);
      $update_sql = "";
      if ($title) {
        $update_sql = $update_sql."`TITLE`='".$title."',";
      }
      if ($content) {
        $update_sql = $update_sql."`CONTENT`='".$content."',";
      }
      if ($articleintro) {
        $update_sql = $update_sql."`ARTICLE_INTRO`='".$articleintro."',";
      }
      if ($classify) {
        $update_sql = $update_sql."`CLASSIFY`='".$classify."',";
      }
      $update_sql = substr($update_sql, 0, -1);
      $where = "`ARTICLE_ID`='$articleId'";
      $update_res = $pdo -> updataBySql('strun_article', $update_sql, $where);
      // echo $update_res;
      print_r($update_res);
      return $update_res;
    }
    // 删除文章
    public function deleteArticle($pdo, $userId, $articleId) {
      // print_r($content);
      // $result = $pdo -> querybykey("strun_article", "ARTICLE_ID", $articleId);
      // $queryResult = $result->fetchAll(PDO::FETCH_ASSOC);
      // print_r($queryResult);
      // if ($queryResult['AUTHOR_ID']) {
      //   # code...
      // }
      $where = "`ARTICLE_ID`='$articleId' AND `AUTHOR_ID`='$userId';";
      // $result = $pdo -> queryBySql("select * from strun_article where `ARTICLE_ID`='$articleId' AND `AUTHOR_ID`='$userId';");
      // $queryResult = $result->fetchAll(PDO::FETCH_ASSOC);
      // if (empty($queryResult)) {
      //   # code...
      // } else {
      // }
      $update_res = $pdo -> delete('strun_article', $where);
      return $update_res;
    }
}
?>
