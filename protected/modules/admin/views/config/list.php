<h3><?php echo $this->adminTitle;?></h3>
<table class="table table-striped table-bordered beta-config-table">
    <thead>
        <tr>
            <th class="span1 align-center">ID</th>
            <th class="span2 align-right"><?php echo t('config_name');?></th>
            <th class="span4"><?php echo t('config_value');?></th>
            <th class="span4"></th>
            <th><?php echo l(t('edit_config_params', 'admin'), url('admin/config/edit', array('categoryid'=>$categoryid)));?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($models as $model):?>
        <tr>
            <td class="align-center"><?php echo $model['id'];?></td>
            <td class="align-right">
                <h5><?php echo h($model['name']);?></h5>
                <span class="cgray f12px"><?php echo $model['config_name'];?></span>
            </td>
            <td><?php echo h($model['config_value']);?></td>
            <td><?php echo nl2br($model['config_description']);?></td>
            <td>&nbsp;</td>
        </tr>
        <?php endforeach;?>
    </tbody>
</table>
