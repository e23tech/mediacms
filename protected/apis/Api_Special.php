<?php
class Api_Special extends ApiBase
{
    public function latest(/*$count=20*/)
    {
        $cmd = app()->getDb()->createCommand()
            ->from(Special::model()->tableName())
            ->order(array('create_time desc', 'id desc'))
            ->limit(20);
        $rows = $cmd->queryAll();
        return $rows;
    }
}