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
Class Code {
    private $codes = array();

    // 获取所有CODE列表
    public function getAllCodes($pdo) {
      $result = $pdo->query('strun_code_type');
      $listAll = $result->fetchAll(PDO::FETCH_ASSOC);
      $resultList = array();
      foreach($listAll as $key => $value) {
        $temp = array();
        foreach($value as $subKey => $subValue) {
            $trans_subkey = str_replace('_', '', strtolower($subKey));
            $subtemp = array(
              $trans_subkey => $subValue
            );
            // if ($subkey != 'password') {
            $temp = array_merge($temp, $subtemp);
            // }
        }
        array_push($resultList, $temp);
      }
      return $resultList;
    }
    // 按类型所属查询code
    public function getCodeByType($pdo, $params){
      $result = $pdo->querybykey('strun_code_type','CODE_TYPE', $params);
      $listAll = $result->fetchAll(PDO::FETCH_ASSOC);
      $resultList = array();
      $i = 0;
      $resultList = $listAll;
      // $resultList['title'] = $listAll[$i]['title'];
      return $resultList;
    }
}
?>
