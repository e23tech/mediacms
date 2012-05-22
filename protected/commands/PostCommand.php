<?php
class PostCommand extends CConsoleCommand
{
    public function actionSyncLatestNews($count)
    {
        var_dump(app()->newsdb);
    }
}