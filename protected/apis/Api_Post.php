<?php
class Api_Post extends ApiBase
{
    const COUNT_OF_PAGE = 15;
    
    /**
     * 获取一篇文章
     * @param integer $id 文章ID
     * @return array
     */
    public function get_one(/*$id*/)
    {
        $postid = (int)$this->param('id');
        $cmd = app()->getDb()->createCommand()
            ->from(Post::model()->tableName())
            ->where(array('and', 'id = :postid', 'state = :enabled'), array(':postid' => $postid, ':enabled' => Post::STATE_ENABLED));
        $row = $cmd->queryRow();
        if ($row === false)
            $row = array();
        else {
            unset($row['create_ip'], $row['contributor_id'], $row['contributor'], $row['contributor_site'], $row['contributor_email']);
            unset($row['hottest'], $row['recommend'], $row['istop'], $row['state']);
            $row['create_time_text'] = date('Y-m-d H:i', $row['create_time']);
        }
        
        return $row;
    }
    
    /**
     * 获取一个分类的文章列表
     * @param integer $categoryid 分类ID
     * @param integer $page 页码
     * @param integer $count 返回数据条数
     */
    public function get_list_of_category(/*$categoryid, $page=0, $count=15*/)
    {
        $categoryid = (int)$this->param('categoryid');
        
        $cmd = app()->getDb()->createCommand()
            ->where(array('and', 'category_id = :categoryid', 'state = :state'), array(':categoryid'=>$categoryid, ':state'=>Post::STATE_ENABLED));
        $rows = $this->fetchPosts($cmd);
        return $rows;
    }
    
    /**
     * 获取一个主题的文章列表
     * @param integer $topicid 主题ID
     * @param integer $page 页码
     * @param integer $count 返回数据条数
     */
    public function get_list_of_topic(/*$topicid, $page=0, $count=15*/)
    {
        $topicid = (int)$this->param('topicid');
        
        $cmd = app()->getDb()->createCommand()
            ->where(array('and', 'topic_id = :topicid', 'state = :state'), array(':topicid'=>$topicid, ':state'=>Post::STATE_ENABLED));
        $rows = $this->fetchPosts($cmd);
        return $rows;
    }
    
    /**
     * 获取一个热门专题的文章列表
     * @param integer $specialid 分类ID
     * @param integer $page 页码
     * @param integer $count 返回数据条数
     */
    public function get_list_of_special(/*$specialid, $page=0, $count=15*/)
    {
        
    }
    
    /**
     * 按时间线获取文章
     * @param integer $page 页码
     * @param integer $count 返回数据条数
     */
    public function get_timeline(/*$page, $count=15*/)
    {
        $cmd = app()->getDb()->createCommand()
            ->where('state = :enabled', array(':enabled' => Post::STATE_ENABLED));
        $rows = $this->fetchPosts();
        return $rows;
    }
    
    private function fetchPosts(CDbCommand $cmd)
    {
        $page = $this->param('page');
        $page = ($page === false) ? 1 : (int)$page;
        $count = $this->param('count');
        $count = ($count === false) ? self::COUNT_OF_PAGE : (int)$count;
        
        $offset = ($page - 1) * $count;
        
        $fields = trim(strip_tags($this->param('fields')));
        if ($fields)
            $cmd->select($fields);
        $cmd->from(Post::model()->tableName())
            ->limit($count)
            ->offset($offset)
            ->order(array('create_time desc', 'id desc'));
        
//         echo $cmd->getText();
        $rows = $cmd->queryAll();
        
        foreach ($rows as $index => $row) {
            $row['create_time_text'] = date('Y-m-d H:i', $row['create_time']);
            unset($row['create_ip'], $row['contributor_id'], $row['contributor'], $row['contributor_site'], $row['contributor_email']);
            unset($row['hottest'], $row['recommend'], $row['istop'], $row['state']);
            $rows[$index] = $row;
            unset($row);
        }
        
        return $rows;
    }
    
}



