<?php
class PostCommand extends CConsoleCommand
{
    const SYNC_ONCE_COUNT = 100;
    const SYNC_LASTID_CACHE_ID = 'sync_news_lastid';
    
    public function actionSyncNews($count = 50, $initLastid = 0)
    {
        $count = (int)$count;
        $lastid = (int)$lastid;
        
        if ($count == 0)
            $count = self::SYNC_ONCE_COUNT;
        
        $lastid = app()->getCache()->get(self::SYNC_LASTID_CACHE_ID);
        if ($lastid === false)
            $lastid = $initLastid;
        $rows = self::fetchNewsRows($count, $lastid);
        self::saveNews($rows);
        
    }
    
    private static function fetchNewsRows($count, $lastid)
    {
        $validStatus = 99;
        
        $cmd = app()->newsdb->createCommand()
            ->select(array('n.id', 'n.title', 'n.thumb', 'n.description', 'n.inputtime', 'd.content'))
            ->from('{{jnnews}} n')
            ->join('{{jnnews_data}} d', 'n.id = d.id')
            ->where(array('and', 'n.id > :lastid', 'n.status = :status', 'n.islink = 0'), array(':lastid'=> $lastid, ':status'=>$validStatus))
            ->order('n.id asc')
            ->limit(self::SYNC_ONCE_COUNT);
        
        $rows = $cmd->queryAll();
        return $rows;
    }
    
    private static function saveNews($rows)
    {
        if (count($rows) == 0) {
            echo "no latest news.\n";
            return ;
        }
        
        foreach ((array)$rows as $row) {
            app()->getCache()->set(self::SYNC_LASTID_CACHE_ID, $row['id']);
            if (empty($row['content'])) continue;
            
            unset($model);
            $model = new Post();
            $model->title = $row['title'];
            $model->thumbnail = $row['thumb'];
            $model->summary = $row['description'];
            $model->content = $row['content'];
            $model->create_time = $row['inputtime'];
            $model->state = Post::STATE_ENABLED;
            $model->post_type = Post::TYPE_POST;
            $model->homeshow = BETA_YES;
            try {
                if ($model->save()) {
                    echo sprintf("ID: %d, Sync Success.\n", $row['id'], $row['title']);
                }
                else {
                    echo sprintf("ID: %d, Title: %s Sync Fail.\n", $row['id'], $row['title']);
                    print_r($model->getErrors());
                }
            }
            catch (Exception $e) {
                echo sprintf("Throw Exception: %s.\n", $e->getMessage());
                continue;
            }
            
        }
    }
}