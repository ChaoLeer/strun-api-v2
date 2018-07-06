<?php
  /**
   * 图片上传处理
   * @author ChaoLee
   */
  header('Access-Control-Allow-Origin: *');
  // header("Content-type:text/html;charset=utf-8");
  // header("Access-Control-Allow-Methods:GET,POST");  
  $sourcePath = 'http://118.24.53.34/api/upload/';
  // 配置文件需要上传到服务器的路径，需要允许所有用户有可写权限，否则无法上传成功
  $uploadPath = 'source/images/';

  // 获取提交的图片数据
  $file = $_FILES['file'];
  // print_r($file);
  if (!isset($file)){
    $result = array('code' => 417, 'msg' => '缺少数据');
    exit(json_encode($result));
    return;  
  }
  // 获取图片回调路径
  // $callbackUrl = $_POST['callbackUrl'];
  // print_r(dirname(__file__));
  if($file['error'] > 0) {
    $result = array('code' => 417, 'msg' => '请检查图片命名或格式错误' )
    exit(json_encode($result));
  } else {
    // chmod($uploadPath, 0777);
    // print_r($file);
    // exit(json_encode($file));
    if(file_exists($uploadPath.$file['name'])){
      $result = array('code' => 417, 'msg' => '文件已经存在！' );
      // $msg = $file['name'] . "文件已经存在！";
      exit(json_encode($result));
    } else {
      if(move_uploaded_file($file['tmp_name'], $uploadPath.$file['name'])) {
        $img_url = $uploadPath.$file['name'];
        // $img_url = urlencode($img_url);
        // $url = $callbackUrl."?img_url={$img_url}";
        // 跳转
        // header("location:{$url}");
        $result = array('code' => 0, 'msg' => '上传成功', 'url' => $sourcePath.$img_url );
        chmod($uploadPath, 0777);
        exit(json_encode($result));
      } else {
        $result = array('code' => 417, 'msg' => '上传失败！' );
        exit(json_encode($result));
      }
    }
  }
?>
