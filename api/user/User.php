<?php
include('../../common/Config.php');

function Options($subType, $pdo, $artTag = null, $artContent = null, $now, $artTitle = null, $artId = null) {
    switch ($subType) {
        case 'type_0':
            $result = $pdo->query('lady_admin_user');
            $artListAll = $result->fetchAll(PDO::FETCH_ASSOC);
            $artList = array();
            foreach($artListAll as $key => $value) {
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
              array_push($artList, $temp);
            }
            echo json_encode($artList);
            break;
        case 'type_1':
            $result = $pdo->insert("lady_admin_user", "id, tag, content, time, title", "'', '$artTag', '$artContent', '$now', '$artTitle'");
            echo $result;
            break;
        case 'type_2':
            $result = $pdo->updata("lady_admin_user", "tag='$artTag', content='$artContent', time='$now', title='$artTitle'", "id='$artId'");
            echo $result;
            break;
        case 'type_3':
            $result = $pdo->delete("lady_admin_user", "id='$artId'");
            echo $result;
            break;
        // 通过id查找
        case 'type_4':
            // $result = $pdo->querybykey('lady_admin_user','id',$artId);
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
            $result = $pdo->querybykey('lady_admin_user','id',$artId);
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
            $result = $pdo->query('lady_admin_user','tag',$artTag);
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
            $result = $pdo->query('lady_admin_user','time',$artTag);
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
            $result = $pdo->query('lady_admin_user','title',$artTag);
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
$artTag = null;
$artContent = null;
$artTitle = null;
$artId = null;
if(isset($_POST['artTag'])) {
  $artTag = $_POST['artTag'];
}
if(isset($_POST['artContent'])) {
  $artContent = $_POST['artContent'];
}
if(isset($_POST['artTitle'])) {
  $artTitle = $_POST['artTitle'];
}
if(isset($_POST['artId'])) {
  $artId = $_POST['artId'];
}
Options($_POST['subType'], $pdo, $artTag, $artContent, $now, $artTitle, $artId);
$pdo->destruct();
?>