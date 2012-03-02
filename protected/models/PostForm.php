<?php
class PostForm extends CFormModel
{
    public $category_id = 0;
    public $topic_id = 0;
    public $title;
    public $summary;
    public $content;
    public $source;
    public $contributor_id;
    public $contributor;
    public $contributor_email;
    public $contributor_site;
    public $tags;
    public $captcha;
    
    public function rules()
    {
        return array(
            array('title, content', 'required'),
            array('category_id, topic_id', 'numerical', 'integerOnly'=>true),
			array('contributor', 'length', 'max'=>50),
	        array('contributor_email, contributor_site, source, tags', 'length', 'max'=>250),
	        array('contributor_email', 'email'),
	        array('contributor_site', 'url'),
            array('captcha', 'captcha', 'allowEmpty'=>$this->captchaAllowEmpty()),
			array('summary, content', 'safe'),
        );
    }
    
    public function attributeLabels()
    {
        return array(
			'category_id' => t('category'),
			'topic_id' => t('topic'),
			'title' => t('title'),
			'summary' => t('summary'),
			'content' => t('content'),
		    'contributor_id' => t('contributor_id'),
		    'contributor' => t('contributor'),
		    'contributor_site' => t('contributor_site'),
		    'contributor_email' => t('contributor_email'),
	        'source' => t('source'),
			'tags' => t('tags'),
            'captcha' => t('captcha'),
        );
    }
    
    public function save()
    {
        $post = new Post();
        $post->attributes = $this->attributes;
        $post->contributor_id = (int)user()->id;
        $post->state = $this->state();
        $post->save();
        $this->afterSave();
        return $post;
    }
    
    public function state()
    {
        return Post::STATE_DISABLED;
    }
        
    public function afterSave()
    {
        
    }
    
    public function captchaAllowEmpty()
    {
        return false;
    }
        
}