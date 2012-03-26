<?php
class Api_User extends ApiBase
{
    public function login()
    {
        if (request()->getIsPostRequest()) {
            $username = strip_tags(trim($_POST['username']));
            $password = strip_tags(trim($_POST['password']));
            
            $identity = new UserIdentity($username, $password);
            if ($identity->authenticate()) {
                $user = app()->getDb()->createCommand()
                    ->from('{{user}}')
                    ->where('email = :username', array(':username'=>$username))
                    ->queryRow();
                $data = array(
                    'error'=>'OK',
                    'userinfo' => $user,
                );
            }
            else
                $data = array('error'=>'failed');
        }
        else
            $data = array('error'=>'failed');
        
        return $data;
    }
}