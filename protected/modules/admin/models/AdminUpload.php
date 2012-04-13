<?php
/**
 * @author chendong
 *
 * @property string $infoUrl
 * @property string $editurl
 * @property string $deleteUrl
 * @property string $verifyUrl
 * @property string $stateText;
 */
class AdminUpload extends Upload
{
    /**
     * Returns the static model of the specified AR class.
     * @return AdminUpload the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public static function fetchList($postid, $fileType = null)
    {
        $postid = (int)$postid;
        if (empty($postid)) return array();
        
        $criteria = new CDbCriteria();
        $criteria->addColumnCondition(array('post_id' => $postid));
        $criteria->order = 't.id asc';
        if ($fileType !== null)
            $criteria->addColumnCondition(array('file_type' => $fileType));
         
        $models = self::model()->findAll($criteria);
         
        return $models;
    }
    
}