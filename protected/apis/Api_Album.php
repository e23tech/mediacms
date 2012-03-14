<?php
class Api_Album extends ApiBase
{
    public function latest(/*$count=20*/)
    {
        $count = 18;
        $where = array('and', 'post_type = :posttype', 'state = :state');
        $params = array(':state'=>Post::STATE_ENABLED, ':posttype'=>Post::TYPE_ALBUM);
        $cmd = app()->getDb()->createCommand()
            ->select(array('id', 'title', 'thumbnail'))
            ->from(Post::model()->tableName())
            ->order(array('create_time desc', 'id desc'))
            ->where($where, $params)
            ->limit($count);
        $rows = $cmd->queryAll();
        
        foreach ($rows as $key => $row) {
            $rows[$key]['create_time_text'] = date(param('formatShortDateTime'), $row['create_time']);
        }
        return $rows;
    }
    
    public function pictures(/*$albumid*/)
    {
        $albumid = $this->getQuery('albumid');
        
        if (empty($albumid)) return array();
        
        $count = 30;
        $cmd = app()->getDb()->createCommand()
            ->from('{{upload}} up')
            ->where('file_type = :type_image and post_id = :albumid', array(':type_image' => Upload::TYPE_PICTURE, ':albumid'=>$albumid))
            ->order('id asc')
            ->limit($count);
        
        $rows = $cmd->queryAll();
        
        foreach ($rows as $index => $row) {
            $row['create_time_text'] = date('Y-m-d H:i', $row['create_time']);
            $rows[$index] = $row;
            unset($row);
        }
        
        return $rows;
    }
}