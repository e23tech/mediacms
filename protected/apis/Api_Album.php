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
        
        $data = array('error'=>'OK', 'albums'=>$rows);
        return $data;
    }
    
    public function pictures(/*$albumid, $count*/)
    {
        $albumid = (int)$this->getQuery('albumid');
        $count = (int)$this->getQuery('count');
        
        if (empty($albumid)) return array('error'=>'failed');
        
        $count = ($count > 0) ? $count : 30;
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
        
        $data = array('error'=>'OK', 'pictures'=>$rows);
        return $data;
    }
}