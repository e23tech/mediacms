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
        
        $where = array('and', 'category_id = :categoryid', 'post_type = :posttype', 'state = :state');
        $params = array(':categoryid'=>$categoryid, ':state'=>Post::STATE_ENABLED, ':posttype'=>Post::TYPE_POST);
        $cmd = app()->getDb()->createCommand()
            ->where($where, $params);
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
        
        $where = array('and', 'topic_id = :topicid', 'post_type = :posttype', 'state = :state');
        $params = array(':topicid'=>$topicid, ':state'=>Post::STATE_ENABLED, ':posttype'=>Post::TYPE_POST);
        $cmd = app()->getDb()->createCommand()
            ->where($where, $params);
        $rows = $this->fetchPosts($cmd);
        return $rows;
    }
    
    /**
     * 按时间线获取文章
     * @param integer $page 页码
     * @param integer $count 返回数据条数
     */
    public function timeline(/*$page, $count=15*/)
    {
        $cmd = app()->getDb()->createCommand()
            ->where('post_type = :posttype and state = :enabled', array(':enabled' => Post::STATE_ENABLED, ':posttype'=>Post::TYPE_POST));
        $rows = $this->fetchPosts($cmd);
        return $rows;
    }
    
    public function hottest(/*$count = 5*/)
    {
        $count = (int)$this->getQuery('count');
        $count = ($count < 1) ? self::HOTTEST_POSTS_COUNT_OF_PAGE : $count;
        
        $where = array('and', 'hottest = :hottest', 'state = :enabled', 'post_type = :posttype');
        $params = array(':enabled' => Post::STATE_ENABLED, ':hottest'=>BETA_YES, ':posttype'=>Post::TYPE_POST);
        $cmd = app()->getDb()->createCommand()
            ->from(Post::model()->tableName())
            ->where($where, $params)
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
        $this->requirePost();
        $this->requiredParams(array('content', 'user_id'));

        $file = var_export($_FILES, true);
        
        $row['content'] = $this->getPost('content') . $file;
        $row['title'] = mb_substr($row['content'], 0, 15, app()->charset);
        $row['summary'] = mb_substr($row['content'], 0, 50, app()->charset);
        $row['contributor_id'] = (int)$this->getPost('user_id');
        $row['user_name'] = $this->getPost('user_name');
        
        $model = new Post();
        $model->attributes = $row;
        if ($model->save()) {
            $result = $this->afterCreate($model);
            $data = array(
                'error' => 'OK',
                'fileError' => $result,
            );
        }
        else {
            $errors = $model->getErrors();
            foreach ($errors as $error)
                $errstr[] = join('|', $error);
            $errstr = join(', ', $errstr);
            $data = array(
                'error' => $errstr,
            );
        }
        
        return $data;
    }
    
    private function afterCreate(Post $model)
    {
        $errorCount = 0;
        foreach ($_FILES as $key => $file) {
            $upload = CUploadedFile::getInstanceByName($key);
            $result = $this->uploadFile($model->id, $upload, Upload::TYPE_PICTURE, 'images');
            if (!$result)
                $errorCount++;
        }
        
        return $errorCount;
    }
    
    private function uploadFile($postid, CUploadedFile $upload, $fileType = Upload::TYPE_PICTURE, $additional = null)
    {
        $file = BetaBase::makeUploadFilePath($upload->extensionName, $additional);
        $filePath = $file['path'];
        if ($upload->saveAs($filePath, $deleteTempFile) && $this->afterUploaded($postid, $upload, $file, $fileType))
            return true;
        else
            return false;
    }
    
    private function afterUploaded($postid, CUploadedFile $upload, $file, $fileType = Upload::TYPE_PICTURE)
    {
        $model = new Upload();
        $model->post_id = $postid;
        $model->file_type = $fileType;
        $model->url = $file['url'];
        $model->user_id = (int)$this->getPost('user_id');
        $model->token = '';
        $result = $model->save();
        return $result;
    }
    
    public function contribute_posts(/*$userid*/)
    {
        $userid = (int)$this->getQuery('userid');

        if ($userid <= 0) {
            $data = array('error'=>'failed');
            return $data;
        }
        
        $where = array('and', 'contributor_id=:userid',  'post_type=:posttype');
        $params = array(':userid' => $userid, ':posttype'=>Post::TYPE_POST);
        
        $cmd = app()->getDb()->createCommand()
            ->from('{{post}}')
            ->where($where, $params);
        
        $rows = $this->fetchPosts($cmd);
        
        $data = array(
            'error' => 'OK',
            'posts' => $rows,
        );
        return $data;
    }
}



