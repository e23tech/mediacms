<?php
class ApiController extends Controller
{
    
    public function actionIndex()
    {
        header('content-type:application/json; charset=' . app()->charset);
        
        $api = new AppApi($_REQUEST);
        $api->run();
        exit(0);
    }
    
    public function actionJsonp()
    {
        $api = new AppApi($_REQUEST);
        $api->run();
    }
}