<?php 
/*
 * 一个简单的 RESTful web services 基类
 * 我们可以基于这个类来扩展需求
*/
class Rest {
    
    private $httpVersion = "HTTP/1.1";
 
    public function setHttpHeaders($contentType, $statusCode){
        //header('Access-Control-Allow-Origin:*');
		//header('Access-Control-Allow-Methods', 'POST, GET, OPTIONS');
        // header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
        //header("Access-Control-Allow-Headers: Content-Type, Accept, Authorization, X-Requested-With, Origin");
        
        // header('Access-Control-Allow-Origin', '*');
        $statusMessage = $this -> getHttpStatusMessage($statusCode);
        
        header($this->httpVersion. " ". $statusCode ." ". $statusMessage);
        // header("Content-type:application/json;charset=utf-8");
        // print_r($contentType);
        header("Content-Type:". $contentType);
    }
    
    public function getHttpStatusMessage($statusCode){
        $httpStatus = array(
            100 => 'Continue',  
            101 => 'Switching Protocols',  
            200 => 'OK',
            201 => 'Created',  
            202 => 'Accepted',  
            203 => 'Non-Authoritative Information',  
            204 => 'No Content',  
            205 => 'Reset Content',  
            206 => 'Partial Content',  
            300 => 'Multiple Choices',  
            301 => 'Moved Permanently',  
            302 => 'Found',  
            303 => 'See Other',  
            304 => 'Not Modified',  
            305 => 'Use Proxy',  
            306 => '(Unused)',  
            307 => 'Temporary Redirect',  
            400 => 'Bad Request',  
            401 => 'Unauthorized',  
            402 => 'Payment Required',  
            403 => 'Forbidden',  
            404 => 'Not Found',  
            405 => 'Method Not Allowed',  
            406 => 'Not Acceptable',  
            407 => 'Proxy Authentication Required',  
            408 => 'Request Timeout',  
            409 => 'Conflict',  
            410 => 'Gone',  
            411 => 'Length Required',  
            412 => 'Precondition Failed',  
            413 => 'Request Entity Too Large',  
            414 => 'Request-URI Too Long',  
            415 => 'Unsupported Media Type',  
            416 => 'Requested Range Not Satisfiable',  
            417 => 'Expectation Failed',  
            500 => 'Internal Server Error',  
            501 => 'Not Implemented',  
            502 => 'Bad Gateway',  
            503 => 'Service Unavailable',  
            504 => 'Gateway Timeout',  
            505 => 'HTTP Version Not Supported');
        return ($httpStatus[$statusCode]) ? $httpStatus[$statusCode] : $status[500];
    }
    // 返回单挑数据
    public function resultSingleData($rawData, $notFoundRes) {
        // print_r($rawData);
        // print_r($rawData);
      if (empty($rawData)) {
            $statusCode = 417;
            $resData = $notFoundRes;
        } else {
            $statusCode = 200;
            $resData = $this->transformResponseData($rawData);
            $resData = $resData[0];
        }
        // $requestContentType = $_SERVER['HTTP_ACCEPT'];
        $requestContentType = 'application/json;charset=UTF-8';
        $this->setHttpHeaders($requestContentType, $statusCode);
        return $resData;
    }

    public function resultDatas($rawData, $notFoundRes) {
        // print_r($rawData);
        // print_r($rawData);
      if (empty($rawData)) {
            $statusCode = 417;
            $resData = $notFoundRes;
        } else {
            $statusCode = 200;
            $resData = $this->transformResponseData($rawData);
        }
        // $requestContentType = $_SERVER['HTTP_ACCEPT'];
        $requestContentType = 'application/json;charset=UTF-8';
        $this->setHttpHeaders($requestContentType, $statusCode);
        return $resData;
    }
    // 转化数据库key
    public function transformResponseData($listArr) {
      $artList = array();
      foreach($listArr as $key => $value) {
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
      return $artList;
    }
}
?>