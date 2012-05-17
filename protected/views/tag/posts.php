<div class="beta-content">
    <div class="beta-block beta-radius3px">
        <h2><?php echo t('tag_posts', 'main', array('{name}'=>$tagname));?></h2>
        <ul class="beta-block-content beta-post-list unstyled">
            <?php if (count($posts) == 0):?>
            <li class="beta-no-content-tip"><?php echo t('no_posts');?></li>
            <?php endif;?>
            <?php foreach ((array)$posts as $model):?>
            <li><?php echo $model->titleLink;?>&nbsp;<span class="cgray">(<?php echo $model->shortDate;?>)</span></li>
            <?php endforeach;?>
            <div class="clear"></div>
        </ul>
    </div>
    <?php if ($pages->pageCount > 1):?>
    <div class="beta-pages"><?php $this->widget('CLinkPager', array('pages'=>$pages));?></div>
    <?php endif;?>
</div>
<div class="beta-sidebar">
    <?php $this->widget('BetaVisitTopPosts', array('allowEmpty'=>true, 'days'=>30, 'cid'=>$category->id));?>
</div>
<div class="clear"></div>