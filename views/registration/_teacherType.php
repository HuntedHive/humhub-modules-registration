<?php 
$flag = HSetting::model()->find('value="'.ManageRegistration::$type[ManageRegistration::TYPE_TEACHER_TYPE]. '"')->value_text;
?>
<h3>Teacher Type</h3>
<table class="table table-hover">
    <thead>
        <tr>
            <th id="user-grid_c0">
                <a class="sort-link" href="">Name</a>
            </th>
        </tr>
    </thead>
    <tbody class="c_items" data-type="<?= ManageRegistration::TYPE_TEACHER_TYPE; ?>">
        <?php
        if (empty($types)) {
            echo '<tr><td colspan="4" class="empty"><span class="empty">Нет результатов.</span></td></tr>';
        } else {
            foreach ($types as $type) {
                echo '<tr class="item_'.$type->id.'" style="z-index:99999"><td colspan="4"><i class="fa fa-bars dragdrop"></i><span class="m_item" data-pk="' . $type->id . '" data-url="' . $this->createUrl('edit') . '">' . $type->name . '</span><a class="close" href="' . $this->createUrl('delete', ['id' => $type->id]) . '">x</a></td></tr>';
            }
        }
        ?>
    </tbody>
</table>
<div class="form">
    <?php echo CHtml::beginForm(['action' => '', 'method' => 'post']); ?>
    <?php echo CHtml::activeHiddenField($model[ManageRegistration::TYPE_TEACHER_TYPE], 'type', ['value' => ManageRegistration::TYPE_TEACHER_TYPE]); ?>
        <?php echo CHtml::activeHiddenField($model[ManageRegistration::TYPE_TEACHER_TYPE], 'default', ['value' => ManageRegistration::DEFAULT_ADDED]); ?>
    <div class="row pull-left col-lg-4">
<?php echo CHtml::activeTextField($model[ManageRegistration::TYPE_TEACHER_TYPE], 'name'); ?>
    </div>
    <div class="row submit pull-left col-lg-4">
        <input type="submit" name="btn" class="btn btn-primary" />
    </div>
    <div class="row submit pull-left col-lg-4">
        <a href='<?= $this->createUrl('type', ['type' => ManageRegistration::TYPE_TEACHER_TYPE]) ?>' data-method='post'>
            <input type='checkbox' <?= $flag?"checked":"" ?>/> add 'other' option to list
        </a>
    </div>
    <div class='row pull-left col-lg-12'>
            <?php echo CHtml::errorSummary($model[ManageRegistration::TYPE_TEACHER_TYPE], '', ''); ?>
    </div>
<?php echo CHtml::endForm(); ?>
</div>