<?php
class Api_Category extends ApiBase
{
    public function get_list()
    {
        $cmd = app()->getDb()->createCommand()
            ->from(Category::model()->tableName())
            ->order(array('orderid desc', 'id asc'));
        $rows = $cmd->queryAll();
        return $rows;
    }
}



