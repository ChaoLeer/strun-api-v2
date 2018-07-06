<?php
include "conn_sql.php";
include "header.php";
$pdo = ConnMySQL::makeConnect('qdm169152214.my3w.com', 'qdm169152214', 'loveqin277', 'qdm169152214_db');
date_default_timezone_set("PRC");
$now = date('yyyy-mm-dd');

function Options($subType, $pdo, $artTag = null, $artContent = null, $now, $artTitle = null, $artId = null) {
    switch ($subType) {
        case 'type_0':
            $result = $pdo->query('article');
            $artListAll = $result->fetchAll(PDO::FETCH_ASSOC);
            $artList = array();
            for($i = 0; $i < count($artListAll); $i++) {
                $artList[$i]['title'] = $artListAll[$i]['title'];
                $artList[$i]['tag'] = $artListAll[$i]['tag'];
                $artList[$i]['content'] = $artListAll[$i]['content'];
                $artList[$i]['time'] = $artListAll[$i]['time'];
                $artList[$i]['id'] = $artListAll[$i]['id'];
            }
            echo json_encode($artList);
            break;
        case 'type_1':
            $result = $pdo->insert("article", "id, tag, content, time, title", "'', '$artTag', '$artContent', '$now', '$artTitle'");
            echo $result;
            break;
        case 'type_2':
            $result = $pdo->updata("article", "tag='$artTag', content='$artContent', time='$now', title='$artTitle'", "id='$artId'");
            echo $result;
            break;
        case 'type_3':
            $result = $pdo->delete("article", "id='$artId'");
            echo $result;
            break;
        // 通过id查找
        case 'type_4':
            // $result = $pdo->querybykey('article','id',$artId);
            // $artListAll = $result->fetchAll(PDO::FETCH_ASSOC);
            // $artList = array();
            // for($i = 0; $i < count($artListAll); $i++) {
                // $artList[$i]['title'] = $artListAll[$i]['title'];
                // $artList[$i]['tag'] = $artListAll[$i]['tag'];
                // $artList[$i]['content'] = $artListAll[$i]['content'];
                // $artList[$i]['time'] = $artListAll[$i]['time'];
                // $artList[$i]['id'] = $artListAll[$i]['id'];
            // }
            // echo json_encode($artList);
            $result = $pdo->querybykey('article','id',$artId);
            $artListAll = $result->fetchAll(PDO::FETCH_ASSOC);
            $artList = array();
			$i = 0;
			$artList['title'] = $artListAll[$i]['title'];
			$artList['tag'] = $artListAll[$i]['tag'];
			$artList['content'] = $artListAll[$i]['content'];
			$artList['time'] = $artListAll[$i]['time'];
			$artList['id'] = $artListAll[$i]['id'];
            echo json_encode($artList);
            break;
        // 通过标签查找
        case 'type_5':
            $result = $pdo->query('article','tag',$artTag);
            $artListAll = $result->fetchAll(PDO::FETCH_ASSOC);
            $artList = array();
            for($i = 0; $i < count($artListAll); $i++) {
                $artList[$i]['title'] = $artListAll[$i]['title'];
                $artList[$i]['tag'] = $artListAll[$i]['tag'];
                $artList[$i]['content'] = $artListAll[$i]['content'];
                $artList[$i]['time'] = $artListAll[$i]['time'];
                $artList[$i]['id'] = $artListAll[$i]['id'];
            }
            echo json_encode($artList);
            break;
        // 通过时间查找
        case 'type_6':
            $result = $pdo->query('article','time',$artTag);
            $artListAll = $result->fetchAll(PDO::FETCH_ASSOC);
            $artList = array();
            for($i = 0; $i < count($artListAll); $i++) {
                $artList[$i]['title'] = $artListAll[$i]['title'];
                $artList[$i]['tag'] = $artListAll[$i]['tag'];
                $artList[$i]['content'] = $artListAll[$i]['content'];
                $artList[$i]['time'] = $artListAll[$i]['time'];
                $artList[$i]['id'] = $artListAll[$i]['id'];
            }
            echo json_encode($artList);
            break;
        // 通过题目查找
        case 'type_7':
            $result = $pdo->query('article','title',$artTag);
            $artListAll = $result->fetchAll(PDO::FETCH_ASSOC);
            $artList = array();
            for($i = 0; $i < count($artListAll); $i++) {
                $artList[$i]['title'] = $artListAll[$i]['title'];
                $artList[$i]['tag'] = $artListAll[$i]['tag'];
                $artList[$i]['content'] = $artListAll[$i]['content'];
                $artList[$i]['time'] = $artListAll[$i]['time'];
                $artList[$i]['id'] = $artListAll[$i]['id'];
            }
            echo json_encode($artList);
            break;
        default:
            echo 'subType参数为空';
            break;
    }
}
Options($_POST['subType'], $pdo, $_POST['artTag'], $_POST['artContent'], $now, $_POST['artTitle'], $_POST['artId']);
$pdo->destruct();
?>