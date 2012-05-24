<?php
class PostCommand extends CConsoleCommand
{
    const SYNC_ONCE_COUNT = 50;
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
        $cmd = app()->newsdb->createCommand()
            ->select(array('n.id', 'n.title', 'n.thumb', 'n.description', 'n.inputtime', 'd.content'))
            ->from('{{jnnews}} n')
            ->join('{{jnnews_data}} d', 'n.id = d.id')
            ->where('n.id > :lastid', array(':lastid'=> $lastid))
            ->order('n.id asc')
            ->limit(self::SYNC_ONCE_COUNT);
        
        $rows = $cmd->queryAll();
        return $rows;
    }
    
    private static function saveNews($rows)
    {
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