<?php
class Api_Post extends ApiBase
{
    const COUNT_OF_PAGE = 15;
    const HOTTEST_POSTS_COUNT_OF_PAGE = 5;
    
    /**
     * 获取一篇文章
     * @param integer $id 文章ID
     * @return array
     */
    public function show(/*$id*/)
    {
        $this->requiredParams(array('id'));
        
        $postid = (int)$this->getParam('id');
        if (empty($postid)) return array();
        
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
            
            app()->getController()->layout = 'phone';
            $row['content'] = app()->getController()->render('/post/iphoneshow', array(
                'content'=>$row['content'],
                'title' => $row['title'],
            ), true);
        }
        
        return $row;
    }
    
    /**
     * 获取一个分类的文章列表
     * @param integer $categoryid 分类ID
     * @param integer $page 页码
     * @param integer $count 返回数据条数
     */
    public function list_of_category(/*$categoryid, $page=0, $count=15*/)
    {
        $this->requiredParams(array('categoryid'));
        
        $categoryid = (int)$this->getParam('categoryid');
        if (empty($categoryid)) return array();
        
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
    public function list_of_topic(/*$topicid, $page=0, $count=15*/)
    {
        $this->requiredParams(array('topicid'));
        
        $topicid = (int)$this->getParam('topicid');
        if (empty($topicid)) return array();
        
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
        $this->requiredParams(array('specialid'));
        
        $specialid = (int)$this->getParam('specialid');
        if (empty($specialid)) return array();
        
        // @todo not complete
    }
    
    /**
     * 按时间线获取文章
     * @param integer $page 页码
     * @param integer $count 返回数据条数
     */
    public function timeline(/*$page, $count=15*/)
    {
        $cmd = app()->getDb()->createCommand()
            ->where('state = :enabled', array(':enabled' => Post::STATE_ENABLED));
        $rows = $this->fetchPosts($cmd);
        return $rows;
    }
    
    public function hottest(/*$count = 5*/)
    {
        $count = (int)$this->getQuery('count');
        $count = ($count < 1) ? self::HOTTEST_POSTS_COUNT_OF_PAGE : $count;
        
        $params = array(':enabled' => Post::STATE_ENABLED, ':hottest'=>BETA_YES);
        $cmd = app()->getDb()->createCommand()
            ->from(Post::model()->tableName())
            ->where(array('and', 'hottest = :hottest', 'state = :enabled'), $params)
            ->limit($count)
            ->order(array('create_time desc', 'id desc'));

        $fields = trim(strip_tags($this->getQuery('fields')));
        if ($fields)
            $cmd->select($fields);
        
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
    
    public function hottest_latest()
    {
        $data['hottest'] = $this->hottest();
        $data['latest'] = $this->timeline();
        return $data;
    }
    
    /**
     * 获取文章内容
     * @param CDbCommand $cmd CDbCommand对象
     * @return array
     */
    private function fetchPosts(CDbCommand $cmd)
    {
        $page = (int)$this->getParam('page');
        $page = ($page < 1) ? 1 : (int)$page;
        $count = (int)$this->getQuery('count');
        $count = ($count < 1) ? self::COUNT_OF_PAGE : (int)$count;
        
        $offset = ($page - 1) * $count;
        
        $fields = trim(strip_tags($this->getQuery('fields')));
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
    
    public function create()
    {
//         $this->requirePost();
        $this->requiredParams(array('content', 'user_id'));

        $row['content'] = $this->getPost('content');
        $row['title'] = mb_substr($row['content'], 0, 15, app()->charset);
        $row['summary'] = mb_substr($row['content'], 0, 50, app()->charset);
        $row['user_id'] = (int)$this->getPost('user_id');
        $row['user_name'] = $this->getPost('user_name');
        
        $model = new Post();
        $model->attributes = $row;
        if ($model->save()) {
            $this->afterCreate($model);
            return $model;
        }
        else {
            $errors = $model->getErrors();
            foreach ($errors as $error)
                $errstr[] = join('|', $error);
            $errstr = join(', ', $errstr);
            throw new ApiException('上传文章失败：' . $errstr, ApiError::POST_SAVE_ERROR);
        }
        
    }
    
    private function afterCreate($model)
    {
        
    }
    
}



