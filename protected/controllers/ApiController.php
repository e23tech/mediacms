<?php
class ApiController extends Controller
{
    public function actionIndex()
    {
        header('content-type', 'application/json');
        $api = new AppApi($_REQUEST);
        $api->run();
    }
    
    public function actionJsonp()
    {
        $api = new AppApi($_REQUEST);
        $api->run();
    }
}