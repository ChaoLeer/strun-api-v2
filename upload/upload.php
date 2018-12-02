<?php
  header('Access-Control-Allow-Origin: *');
  // header("Content-type:text/html;charset=utf-8");
  $sourcePath = '/upload/';
  //$ENV = 'PRODUCT'
  //if ($_SERVER['SERVER_NAME'] == 'localhost') {
    //$ENV = 'DEV';
  //}
  // header("Content-type:text/html;charset=utf-8");
  // $sourcePath = 'http://118.24.53.34:8888/upload/';
  // $sourcePath = $ENV == 'DEV' ? 'http://localhost:80/upload/' : 'http://118.24.53.34:8888/upload/';
  // 配置文件需要上传到服务器的路径，需要允许所有用户有可写权限，否则无法上传成功
  $uploadPath = 'source/images/';

  // 获取提交的图片数据
  $file = $_FILES['file'];
  $userId = $_POST['userId'];
  $type = $_POST['type'];
  if (!isset($file)) {
    $result = array('code' => 417, 'msg' => '缺少参数' );
    exit(json_encode($result));
  }
  if (!isset($userId)) {
    $result = array('code' => 417, 'msg' => '缺少用户id' );
    exit(json_encode($result));
  }
  if (!isset($type)) {
    $result = array('code' => 417, 'msg' => '缺少参数' );
    exit(json_encode($result));
  }
  // if (!isset($articleId)) {
  //   $result = array('code' => 417, 'msg' => '缺少文章id' );
  //   exit(json_encode($result));
  // }
  // print_r($file);
  // 获取图片回调路径
  // $callbackUrl = $_POST['callbackUrl'];

  if($file['error'] > 0) {
    $result = array('code' => 417, 'msg' => '请检查图片命名或格式错误'.$file['error'] );
    exit(json_encode($result));
  } else {
    if (!file_exists($uploadPath.$userId)) {
      mkdir($uploadPath.$userId);
    }
    // chmod($uploadPath, 0666);
    if(file_exists($uploadPath.$userId.'/'.$file['name'])){
      $result = array('code' => 417, 'msg' => '文件已经存在！', 'userId' => $userId );
      // $msg = $file['name'] . "文件已经存在！";
      exit(json_encode($result));
    } else {
      if(move_uploaded_file($file['tmp_name'], $uploadPath.$userId.'/'.$file['name'])) {
        $img_url = $uploadPath.$userId.'/'.$file['name'];
        // $img_url = urlencode($img_url);
        // $url = $callbackUrl."?img_url={$img_url}";
        // 跳转
        // header("location:{$url}");
        $result = array(
          'code' => 0,
          'msg' => '上传成功', 
          // 'server' => $_SERVER, 
          'url' =>  'http://'.$_SERVER['HTTP_HOST'].$sourcePath.$img_url,
          'filename' => $file['name'],
          'userId' => $userId
        );
        exit(json_encode($result));
      } else {
        $result = array('code' => 417, 'msg' => '上传失败！', 'userId' => $userId );
        exit(json_encode($result));
      }
    }
  }
?>
