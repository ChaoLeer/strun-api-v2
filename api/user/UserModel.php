<?php

require_once ("../common/PubFun.php");
class UserModel extends Rest {
    public function getAllUsers() {
        $user = new User();
        $rawData = $user->getAllUsers();
        $pubfun = new PubFun();
        $notFoundRes = array(
            'error' => 'No users found!'
        );
        $pubfun -> responseDatas($rawData, $notFoundRes);
    }
    public function getUser($id) {
        $user = new User();
        $rawData = $user->getUser($id);
        $pubfun = new PubFun();
        $notFoundRes = array(
            'error' => 'No users found!'
        );
        $pubfun -> responseDatas($rawData, $notFoundRes);
    }
    public function login($lnm, $psw) {
        $user = new User();
        $rawData = $user->login($lnm, $psw);
        // print_r($rawData);
        $pubfun = new PubFun();
        $notFoundRes = array(
            'message' => '用户名或密码不正确！'
        );
        $pubfun -> responseDatas($rawData, $notFoundRes);
    }
}
?>