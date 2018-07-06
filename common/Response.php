<?php
  /**
  * 公共类
  */
  class Response extends Rest {
    public function encodeHtml($responseData) {
        $htmlResponse = "<table border='1'>";
        foreach ($responseData as $key => $value) {
            $htmlResponse.= "<tr><td>" . $key . "</td><td>" . $value . "</td></tr>";
        }
        $htmlResponse.= "</table>";
        return $htmlResponse;
    }
    public function encodeJson($responseData) {
        $jsonResponse = json_encode($responseData);
        return $jsonResponse;
    }
    public function encodeXml($responseData) {
        // 创建 SimpleXMLElement 对象
        $xml = new SimpleXMLElement('<?xml version="1.0"?><site></site>');
        foreach ($responseData as $key => $value) {
            $xml->addChild($key, $value);
        }
        return $xml->asXML();
    }

    public function setErrorCode ($resInfo, $statusCustomErrorCode) {
        // $siteRestHandler = new SiteHandler();
        $response = $this->encodeJson($resInfo);
        //$requestContentType = $_SERVER['HTTP_ACCEPT'];
        $requestContentType = 'application/json;charset=UTF-8';
        $this->setHttpHeaders($requestContentType, $statusCustomErrorCode);
        echo $response;
    }
    public function responseMysqlError ($faildMessage) {
        $statusCode = 417;
        $responseData = $faildMessage;
        $requestContentType = $_SERVER['HTTP_ACCEPT'];
        $this->setHttpHeaders($requestContentType, $statusCode);
        $response = $this->encodeJson($responseData);
        echo $response;
    }
    // 返回数据
    public function responseDatas ($rawData = array(), $notFoundRes) {
        $responseData = $this->resultDatas($rawData, $notFoundRes);
        $response = $this->encodeJson($responseData);
        exit($response);
    }
    // 返回异常
    function responseExeption($message, $code='0') {
      $res = Array('message' => $message, 'code' => $code);
      $this->responseDatas(array(), $res);
    }
    public function responseArticleTypesResult ($rawData) {
        // print_r($rawData);
        // print_r($rawData);
        $statusCode = 200;
        $requestContentType = $_SERVER['HTTP_ACCEPT'];
        $this->setHttpHeaders($requestContentType, $statusCode);
        $response = $this->encodeJson($rawData);
        echo $response;
    }
    public function responseInsertResult ($resState, $faildMessage) {
        if ($resState) {
            $statusCode = 200;
            $responseData = array('message' => '新增成功');
        } else {
            $statusCode = 417;
            $responseData = $faildMessage;
        }
        // $requestContentType = $_SERVER['HTTP_ACCEPT'];
        $requestContentType = 'application/json;charset=UTF-8';
        $this->setHttpHeaders($requestContentType, $statusCode);
        $response = $this->encodeJson($responseData);
        echo $response;
    }
    public function responseUpdateResult ($resState, $faildMessage) {
        if ($resState) {
            $statusCode = 200;
            $responseData = array('message' => '修改成功');
        } else {
            $statusCode = 417;
            $responseData = $faildMessage;
        }
        // $requestContentType = $_SERVER['HTTP_ACCEPT'];
        $requestContentType = 'application/json;charset=UTF-8';
        $this->setHttpHeaders($requestContentType, $statusCode);
        $response = $this->encodeJson($responseData);
        echo $response;
    }
    public function responseDeleteResult ($resState, $faildMessage) {
        if ($resState) {
            $statusCode = 200;
            $responseData = array('message' => '删除成功');
        } else {
            $statusCode = 417;
            $responseData = $faildMessage;
        }
        // $requestContentType = $_SERVER['HTTP_ACCEPT'];
        $requestContentType = 'application/json;charset=UTF-8';
        $this->setHttpHeaders($requestContentType, $statusCode);
        $response = $this->encodeJson($responseData);
        echo $response;
    }
	public function resResult($res) {
		if ($res) {
			$statusCode = 200;
		} else {
			$statusCode = 417;
		}
		$requestContentType = $_SERVER['HTTP_ACCEPT'];
		$this->setHttpHeaders($requestContentType, $statusCode);
	}
  }

?>
