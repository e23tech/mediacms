<?php

/**
 * This is the model class for table "{{topic}}".
 *
 * The followings are the available columns in table '{{topic}}':
 * @property integer $id
 * @property string $name
 * @property integer $post_nums
 * @property string $icon
 * @property integer $orderid
 * @property string $postsUrl
 * @property string $postsLink
 * @property string $iconUrl
 * @property string $iconHtml
 */
class Topic extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Topic the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return TABLE_TOPIC;
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
	        array('name', 'required'),
	        array('name', 'unique'),
	        array('post_nums, orderid', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>50),
			array('icon', 'length', 'max'=>250),
			array('icon', 'file', 'allowEmpty'=>true),
	        array('name', 'filter', 'filter'=>'strip_tags'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
	        'postCount' => array(self::STAT, 'Post', 'topic_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => t('topic_name'),
			'post_nums' => t('post_nums'),
			'icon' => t('icon'),
			'orderid' => t('orderid'),
		);
	}


	public static function fetchListObjects()
	{
	    $criteria = new CDbCriteria();
	    $criteria->order = 'orderid desc, id asc';
	    $models = self::model()->findAll($criteria);
	
	    return $models;
	}
	
	public static function fetchListArray()
	{
	    $cmd = app()->getDb()->createCommand()
	    ->from(TABLE_TOPIC)
	    ->order(array('orderid desc', 'id asc'));
	
	    $rows = $cmd->queryAll();
	    return $rows;
	}
	
	public static function listData()
	{
	    $rows = self::fetchListArray();
	    $data = CHtml::listData($rows, 'id', 'name');
	    return $data;
	}
	
	public function getPostsUrl()
	{
	    return aurl('topic/posts', array('id'=>$this->id));
	}
	
	public function getPostsLink($target = '_blank')
	{
	    return l($this->name, $this->getPostsUrl(), array('target'=>$target));
	}
	
	public function getIconUrl()
	{
	    if (empty($this->icon)) return '';
	    
	    $pos = strpos($this->icon, 'http://');
	    if ($pos === false)
	        $url = fbu($this->icon);
	    elseif ($pos === 0)
	        $url = $this->icon;
	    else
	        $url = '';
	    
	    return $url;
	}
	
	public function getIconHtml()
	{
	    if (empty($this->icon))
	        return '';
	    else
    	    return image($this->getIconUrl(), $this->name, array('topic-icon'));
	}
	
	protected function beforeSave()
	{
	    if ($this->getIsNewRecord()) {
	        $this->orderid = (int)$this->orderid;
	        $this->post_nums = 0;
	    }
	
	    return true;
	}
	
	protected function beforeDelete()
	{
	    if ($this->subCount > 0)
	        $this->addError('name', t('topic_has_subcategory'));
	    if ($this->postCount > 0)
	        $this->addError('name', t('topic_has_post'));
	
	    return $this->hasErrors('name');
	}
}


