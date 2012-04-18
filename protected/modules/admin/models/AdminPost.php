<?php
/**
 * @property string $infoLink
 * @property string $editUrl
 * @property string $editLink
 * @property string $deleteLink
 * @property string $verifyLink
 * @property string $adminTitleLink
 * @property string $hottestUrl
 * @property string $recommendUrl
 * @property string $homeshowUrl
 * @property string $commentUrl
 * @property string $topLink
 * @property string $commentNumsBadgeHtml
 */
class AdminPost extends Post
{
    /**
     * Returns the static model of the specified AR class.
     * @return AdminPost the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    public function relations()
    {
        return parent::relations() + array(
            'adminCategory' => array(self::BELONGS_TO, 'AdminCategory', 'category_id'),
            'adminTopic' => array(self::BELONGS_TO, 'AdminTopic', 'topic_id'),
        );
    }
    
    public function getInfoLink()
    {
        return l(t('post_info_view', 'admin'), url('admin/post/info', array('id'=>$this->id)));
    }
    
    public static function fetchList($criteria = null, $sort = true, $pages = true)
    {
        $criteria = ($criteria === null) ? new CDbCriteria() : $criteria;
        if ($criteria->limit < 0)
            $criteria->limit = param('adminPostCountOfPage');
        
        if ($sort) {
            $sort  = new CSort(__CLASS__);
            $sort->defaultOrder = 't.id desc';
            $sort->applyOrder($criteria);
        }
         
        if ($pages) {
            $count = self::model()->count($criteria);
            $pages = new CPagination($count);
            $pages->setPageSize($criteria->limit);
            $pages->applyLimit($criteria);
        }

        $models = self::model()->with('category', 'topic')->findAll($criteria);

        $data = array(
            'models' => $models,
            'sort' => $sort,
            'pages' => $pages,
        );
         
        return $data;
    }

    public function getEditUrl()
    {
        return url('admin/post/create', array('id'=>$this->id));
    }
    
    public function getEditLink()
    {
        return l($this->title, $this->getEditUrl(), array('target'=>'_blank'));
    }

    public function getDeleteLink()
    {
        return l(t('delete', 'admin'), url('admin/post/setdelete', array('id'=>$this->id)), array('class'=>'set-delete'));
    }

    public function getVerifyLink()
    {
        $text = t(($this->state == AdminPost::STATE_DISABLED) ? 'setshow' : 'sethide', 'admin');
        return l($text, url('admin/post/setVerify', array('id'=>$this->id)), array('class'=>'set-verify'));
    }

    public function getHottestUrl()
    {
        $text = t(($this->hottest == BETA_NO) ? 'set_hottest_post' : 'cancel_hottest_post', 'admin');
        return l($text, url('admin/post/sethottest', array('id'=>$this->id)), array('class'=>'set-hottest'));
    }

    public function getRecommendUrl()
    {
        $text = t(($this->recommend == BETA_NO) ? 'set_recommend_post' : 'cancel_recommend_post', 'admin');
        return l($text, url('admin/post/setrecommend', array('id'=>$this->id)), array('class'=>'set-recommend'));
    }
    
    public function getHomeshowUrl()
    {
        $text = t(($this->homeshow == BETA_YES) ? 'cannel_homeshow_post' : 'set_homeshow_post', 'admin');
        return l($text, url('admin/post/sethomeshow', array('id'=>$this->id)), array('class'=>'set-recommend'));
    }

    public function getCommentUrl()
    {
        return url('admin/comment/list', array('postid'=>$this->id));
    }

    public function getTopLink()
    {
        $text = t(($this->istop == BETA_NO) ? 'settop' : 'cancel_top', 'admin');
        return l($text, url('admin/post/settop', array('id'=>$this->id)), array('class'=>'set-top'));
    }

    public function getCommentNumsBadgeHtml()
    {
        $count = (int)$this->comment_nums;
        if ($count <= 10)
            $class = '';
        elseif ($count <= 50)
            $class = 'badge-warning';
        else
            $class = 'badge-error';
        
        $html = sprintf('<span class="badge beta-badge %s">%s</span>', $class, $count);
        $html = l($html, $this->commentUrl, array('title'=>'Click to view comment list'));
        return $html;
    }

}

