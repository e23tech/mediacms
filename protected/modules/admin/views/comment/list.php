<h3><?php echo $this->adminTitle;?>&nbsp;&nbsp;&nbsp;<?php echo $post->titleLink;?></h3>
<div class="btn-toolbar">
    <button class="btn btn-small" id="select-all"><?php echo t('select_all', 'admin');?></button>
    <button class="btn btn-small" id="reverse-select"><?php echo t('reverse_select', 'admin');?></button>
    <button class="btn btn-small btn-primary" id="batch-verify" data-src="<?php echo url('admin/comment/multiVerify');?>"><?php echo t('set_batch_verify', 'admin');?></button>
    <button class="btn btn-small btn-primary" id="batch-recommend" data-src="<?php echo url('admin/comment/multiRecommend');?>"><?php echo t('setrecommend', 'admin');?></button>
    <button class="btn btn-small btn-primary" id="batch-hottest" data-src="<?php echo url('admin/comment/multiHottest');?>"><?php echo t('sethottest', 'admin');?></button>
    <button class="btn btn-small btn-danger" id="batch-delete" data-src="<?php echo url('admin/comment/multiDelete');?>"><?php echo t('delete', 'admin');?></button>
</div>
<table class="table table-striped table-bordered beta-list-table">
    <thead>
        <tr>
            <th class="item-checkbox align-center">#</th>
            <th class="span1 align-center"><?php echo $sort->link('id');?></th>
            <th><?php echo t('content');?></th>
            <th class="span2 align-center"><?php echo t('user_name');?>&nbsp;/&nbsp;<?php echo $sort->link('create_time');?></th>
            <th class="span1 align-center">#</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($models as $model):?>
        <tr>
            <td class="item-checkbox"><input type="checkbox" name="itemids" value="<?php echo $model->id;?>" /></td>
            <td class="align-center"><?php echo $model->id;?></td>
            <td class="comment-content"><?php echo $model->content;?></td>
            <td>
                <?php echo $model->authorName;?><br />
                <?php echo $model->createTime;?>
            </td>
            <td>
                <?php echo $model->verifyUrl;?>
                <div class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown"><?php echo t('operation', 'admin');?><b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><?php echo $model->editUrl;?></li>
                        <li><?php echo $model->recommendUrl;?></li>
                        <li><?php echo $model->deleteUrl;?></li>
                    </ul>
                </div>
            </td>
        </tr>
        <?php endforeach;?>
    </tbody>
</table>
<?php if ($pages):?>
<div class="beta-pages"><?php $this->widget('CLinkPager', array('pages'=>$pages, 'htmlOptions'=>array('class'=>'pagination')));?></div>
<?php endif;?>

<script type="text/javascript">
$(function(){
	var deleteConfirmText = '<?php echo t('delete_confirm', 'admin');?>';
	$(document).on('click', '.set-delete', {onfirmText:deleteConfirmText}, BetaAdmin.deleteComment);
	$(document).on('click', '.set-verify, .set-verify, .set-recommend', BetaAdmin.ajaxSetCommentBoolColumn);
	
	$(document).on('click', '#batch-delete', {onfirmText:deleteConfirmText}, BetaAdmin.deleteMultiComments);
	$(document).on('click', '#batch-verify', BetaAdmin.verifyMultiComments);
	$(document).on('click', '#batch-recommend', BetaAdmin.recommendMultiComments);
	$(document).on('click', '#batch-hottest', BetaAdmin.hottestMultiComments);
	
	$(document).on('click', '#select-all', BetaAdmin.selectAll);
	$(document).on('click', '#reverse-select', BetaAdmin.reverseSelect);
	
	$(document).on('click', '.comment-content', function(event){
		$(this).find('fieldset').toggle();
	});
});
</script>

