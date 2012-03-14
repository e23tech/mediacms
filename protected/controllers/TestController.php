<?php
class TestController extends Controller
{
    public function actionTest1()
    {
        $str = <<<EOD
 <div class="sn-container">
            <p id="login-info" class="sn-login-info">
                                                             <script>
	                            if (TB && TB.Global&& TB.Global.writeLoginInfo) {
                                      TB.Global.writeLoginInfo({
                                        isApp: true,
                                        passCookie:true
                                   });
                                 }
                        </script>
                                                  </p>
EOD;
        $pattern = '/\s*<script.*?writeLoginInfo.*?<\/script>\s*/is';
        $new = preg_replace($pattern, '123', $str);
        
        var_dump($new);
        exit;
        
//         var_dump(app()->session->isStarted);
//         session_start();
        var_dump(app()->session);
    }

    public function actionTest()
    {
//         phpinfo();
//         exit;
//         $check = user()->checkAccess('enterAdminSystem');
//         var_dump($check);
//         exit;
    
        $auth=Yii::app()->authManager;
    
        $auth->createOperation('createPost','create a post');
        $auth->createOperation('updatePost','update a post');
        $auth->createOperation('deletePost','delete a post');
        $auth->createOperation('enterAdminSystem','login into admin system');
    
        $bizRule='return Yii::app()->user->id==$params["post"]->user_id;';
        $task=$auth->createTask('updateOwnPost','update a post by author himself',$bizRule);
        $task->addChild('updatePost');
         
        $role=$auth->createRole('author');
        $role->addChild('createPost');
        $role->addChild('updateOwnPost');
         
        $role=$auth->createRole('editor');
        $role->addChild('updatePost');
        $role->addChild('enterAdminSystem');
         
        $role=$auth->createRole('admin');
        $role->addChild('editor');
        $role->addChild('author');
        $role->addChild('deletePost');
         
        $auth->assign('admin','1');
        //         $auth->assign('author','2');
    
    
    }
}