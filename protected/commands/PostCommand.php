<?php
class PostCommand extends CConsoleCommand
{
    public function actionUpdateStateEnable($count)
    {
        $cmd = app()->getDb()->createCommand()
            ->select('id')
            ->from('{{post}}')
            ->order('create_time asc, id asc')
            ->limit($count);
        
        $conditions = array('and', 'channel_id = :channelID', 'state = :disable_state');
        
        $params = array(':disable_state'=>Post::STATE_DISABLED, ':channelID'=>CHANNEL_DUANZI);
        $duanziIDs = $cmd->where($conditions, $params)->queryColumn();
        
        $params = array(':disable_state'=>Post::STATE_DISABLED, ':channelID'=>CHANNEL_LENGTU);
        $lengtuIDs = $cmd->where($conditions, $params)->queryColumn();
        
        $params = array(':disable_state'=>Post::STATE_DISABLED, ':channelID'=>CHANNEL_GIRL);
        $fuliIDs = $cmd->where($conditions, $params)->queryColumn();
        
        $ids = array_merge($duanziIDs, $lengtuIDs, $fuliIDs);
        
        $nums = app()->getDb()->createCommand()
            ->update('{{post}}',
                array('state'=>Post::STATE_ENABLED, 'create_time'=>(int)$_SERVER['REQUEST_TIME']),
                array('in', 'id', $ids)
            );
        
        printf("update %d rows\n", $nums);
    }
}