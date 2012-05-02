<h3><?php echo $this->adminTitle;?></h3>
<div class="btn-toolbar">
    <button class="btn btn-small" id="select-all"><?php echo t('select_all', 'admin');?></button>
    <button class="btn btn-small" id="reverse-select"><?php echo t('reverse_select', 'admin');?></button>
    <button class="btn btn-small btn-primary" id="batch-verify" data-src="<?php echo url('admin/user/multiVerify');?>"><?php echo t('user_enabled', 'admin');?></button>
    <button class="btn btn-small btn-danger" id="batch-reject" data-src="<?php echo url('admin/user/multiForbidden');?>"><?php echo t('user_disabled', 'admin');?></button>
    <a class="btn btn-small btn-success" href=''><?php echo t('reload_data', 'admin');?></a>
</div>
<table class="table table-striped table-bordered beta-list-table">
    <thead>
        <tr>
            <th class="item-checkbox align-center">#</th>
            <th class="span1 align-center"><?php echo $sort->link('id');?></th>
            <th class="span3"><?php echo $sort->link('email');?></th>
            <th class="span3"><?php echo $sort->link('name');?></th>
            <th class="span1 align-center"><?php echo $sort->link('state');?></th>
            <th class="span2 align-center"><?php echo $sort->link('create_time');?></th>
            <th>#</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($models as $model):?>
        <tr>
            <td class="item-checkbox"><input type="checkbox" name="itemid[]" value="<?php echo $model->id;?>" /></td>
            <td class="align-center"><?php echo $model->id;?></td>
            <td><?php echo l($model->email, $model->getInfoUrl());?></td>
            <td><?php echo $model->name;?></td>
            <td class="span1 align-center"><?php echo $model->stateText;?></td>
            <td class="align-center"><?php echo $model->createTime;?></td>
            <td>
                <?php echo $model->editUrl;?>
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
	$(document).on('click', '.row-state', BetaAdmin.ajaxSetBooleanColumn);
	$(document).on('click', '#select-all', BetaAdmin.selectAll);
	$(document).on('click', '#reverse-select', BetaAdmin.reverseSelect);
	$(document).on('click', '#batch-verify', BetaAdmin.enabledMultiUsers);
	$(document).on('click', '#batch-reject', BetaAdmin.forbiddenMultiUsers);

});
</script>
