<h2><?php echo $model->title;?></h2>

<?php if (count($model->picture) > 0):?>
<div class="control-group bottom10px">
    <label class="control-label"><?php echo t('post_upload_pictures', 'admin');?></label>
    <div class="controls">
        <ul class="unstyled post-pictures">
            <?php foreach ((array)$model->picture as $pic):?>
            <li><img src="<?php echo $pic->fileUrl;?>" /></li>
            <?php endforeach;?>
        </ul>
    </div>
</div>
<?php endif;?>