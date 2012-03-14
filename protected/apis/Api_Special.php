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
        
        foreach ($rows as $key => $row) {
            $rows[$key]['create_time_text'] = date(param('formatShortDateTime'), $row['create_time']);
        }
        return $rows;
    }
}