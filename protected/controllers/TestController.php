<?php
class TestController extends Controller
{
    public function actionTest1()
    {
        echo request()->getQuery('test');
        
        exit;
//         var_dump(app()->session->isStarted);
//         session_start();
        var_dump(app()->session);
    }
}