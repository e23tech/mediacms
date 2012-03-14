<?php
class Api_Album extends ApiBase
{
    public function latest(/*$count=20*/)
    {
        $count = 18;
        $where = array('and', 'post_type = :posttype', 'state = :state');
        $params = array(':state'=>Post::STATE_ENABLED, ':posttype'=>Post::TYPE_ALBUM);
        $cmd = app()->getDb()->createCommand()
            ->select(array('title', 'thumbnail'))
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
    
    public function posts(/*$specialid*/)
    {
        $sid = $this->getQuery('specialid');
        
        if (empty($sid)) return array();
        
        $count = 40;
        $cmd = app()->getDb()->createCommand()
            ->select('p.*')
            ->from('{{special2post}} sp')
            ->where('sp.special_id = :sid', array(':sid' => $sid))
            ->join('{{post}} p', 'p.id = sp.post_id')
            ->order(array('p.create_time desc', 'p.id desc'))
            ->limit($count);
        
        $rows = $cmd->queryAll();
        
        foreach ($rows as $index => $row) {
            $row['create_time_text'] = date('Y-m-d H:i', $row['create_time']);
            unset($row['create_ip'], $row['contributor_id'], $row['contributor'], $row['contributor_site'], $row['contributor_email']);
            unset($row['hottest'], $row['recommend'], $row['istop'], $row['state']);
        
            app()->getController()->layout = 'phone';
            $row['content'] = app()->getController()->render('/post/iphoneshow', array(
            'content'=>$row['content'],
            'title' => $row['title'],
            ), true);
        
            $rows[$index] = $row;
            unset($row);
        }
        
        return $rows;
    }
}