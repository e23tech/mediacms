<?php
class Api_Topic extends ApiBase
{
    public function get_list()
    {
        $cmd = app()->getDb()->createCommand()
            ->from(Topic::model()->tableName())
            ->order(array('orderid desc', 'id asc'));
        $rows = $cmd->queryAll();
        return $rows;
    }
}