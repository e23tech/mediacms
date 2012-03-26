<?php
class Api_User extends ApiBase
{
    public function login()
    {
        if (request()->getIsPostRequest()) {
            $username = strip_tags(trim($_POST['username']));
            $password = strip_tags(trim($_POST['password']));
            
            $identity = new UserIdentity($username, $password);
            if ($identity->authenticate())
                $data = array('errno'=>'OK');
            else
                $data = array('errno'=>'failed');
        }
        else
            $data = array('errno'=>'failed');
    }
}