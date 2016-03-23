<?php 
$flag = HSetting::model()->find('value="'.ManageRegistration::$type[ManageRegistration::TYPE_TEACHER_LEVEL]. '"')->value_text;
?>
<h3>Teacher Level</h3>
<table class="table table-hover">
    <thead>
        <tr>
            <th id="user-grid_c0">
                <a class="sort-link" href="">Name</a>
            </th>
        </tr>
    </thead>
    <tbody>
        <tr class="c_items ui-sortable" data-type="<?= ManageRegistration::TYPE_TEACHER_LEVEL; ?>">
            
            <?php
            if (empty($levels)) {
                echo '<td colspan="4" class="empty"><span class="empty">Нет результатов.</span></td>';
            } else {
                foreach ($levels as $level) {
                    echo '<td class="item_'.$level->id.'" style="z-index:99999;float:left;width:100%" colspan="4"><i class="fa fa-bars dragdrop"></i><span class="m_item" data-pk="' . $level->id . '" data-url="' . $this->createUrl('edit') . '">'.$level->name.'</span><a class="close" href="' . $this->createUrl('delete', ['id' => $level->id]) . '">x</a></td>';
                }
            }
            ?>
        </tr>
    </tbody>
</table>
<div class="form">
    <?php echo CHtml::beginForm(['action' => '', 'method' => 'post']); ?>
    <?php echo CHtml::activeHiddenField($model[ManageRegistration::TYPE_TEACHER_LEVEL], 'type', ['value' => ManageRegistration::TYPE_TEACHER_LEVEL]); ?>
        <?php echo CHtml::activeHiddenField($model[ManageRegistration::TYPE_TEACHER_LEVEL], 'default', ['value' => ManageRegistration::DEFAULT_ADDED]); ?>
    <div class="row pull-left col-lg-4">
<?php echo CHtml::activeTextField($model[ManageRegistration::TYPE_TEACHER_LEVEL], 'name'); ?>
    </div>
    <div class="row submit pull-left col-lg-4">
        <input type="submit" name="btn" class="btn btn-primary" />
    </div>
    <div class="row submit pull-left col-lg-4">
        <a href='<?= $this->createUrl('type', ['type' => ManageRegistration::TYPE_TEACHER_LEVEL]) ?>' data-method='post'>
            <input type='checkbox' <?= $flag?"checked":"" ?>/> add 'other' option to list
        </a>
    </div>
    <div class='row pull-left col-lg-12'>
            <?php echo CHtml::errorSummary($model[ManageRegistration::TYPE_TEACHER_LEVEL], '', ''); ?>
    </div>
<?php echo CHtml::endForm(); ?>
</div>