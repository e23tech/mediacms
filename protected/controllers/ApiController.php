<?php
class ApiController extends Controller
{
    public function actionIndex()
    {
        $api = new AppApi($_REQUEST);
        $api->run();
    }
    
    public function actionJsonp()
    {
        $api = new AppApi($_REQUEST);
        $api->run();
    }
}