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
                    ->where('name = :uesrname', array(':username'=>$username))
                    ->queryRow();
                $data = array(
                    'errno'=>'OK',
                    'userinfo' => $user,
                );
            }
            else
                $data = array('errno'=>'failed');
        }
        else
            $data = array('errno'=>'failed');
        
        return $data;
    }
}