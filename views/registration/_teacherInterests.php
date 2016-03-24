<?php 
$flag = HSetting::model()->find('value="'.ManageRegistration::$type[ManageRegistration::TYPE_TEACHER_INTEREST]. '"')->value_text;
?>
<h4>Teacher Interests</h4>
<table class="table table-hover">
    <thead>
        <tr>
            <th id="user-grid_c0">
                <a class="sort-link" href="">Name</a>
            </th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (empty($interests)) {
            echo '<tr><td colspan="4" class="empty"><span class="empty">Нет результатов.</span></td></tr>';
        } else {
            foreach ($interests as $interest) {
                echo '<tr><td colspan="4" class="empty"><span class="m_item" data-pk="' . $interest->id . '" data-url="' . $this->createUrl('edit') . '">'.$interest->name.'</span><a class="close" href="' . $this->createUrl('delete', ['id' => $interest->id]) . '">x</a></td></tr>';
            }
        }
        ?>
    </tbody>
</table>
<div class="form">
    <?php echo CHtml::beginForm(['action' => '', 'method' => 'post']); ?>
    <?php echo CHtml::activeHiddenField($model[ManageRegistration::TYPE_TEACHER_INTEREST], 'type', ['value' => ManageRegistration::TYPE_TEACHER_INTEREST]); ?>
        <?php echo CHtml::activeHiddenField($model[ManageRegistration::TYPE_TEACHER_INTEREST], 'default', ['value' => ManageRegistration::DEFAULT_ADDED]); ?>
    <div class="row pull-left col-lg-4">
<?php echo CHtml::activeTextField($model[ManageRegistration::TYPE_TEACHER_INTEREST], 'name'); ?>
    </div>
    <div class="row submit pull-left col-lg-4">
        <input type="submit" name="btn" class="btn btn-primary" />
    </div>
    <div class="row submit pull-left col-lg-4">
        <a href='<?= $this->createUrl('type', ['type' => ManageRegistration::TYPE_TEACHER_INTEREST]) ?>' data-method='post'>
            <input type='checkbox' <?= $flag?"checked":"" ?>/> add 'other' option to list
        </a>
    </div>
    <div class='row pull-left col-lg-12'>
            <?php echo CHtml::errorSummary($model[ManageRegistration::TYPE_TEACHER_INTEREST], '', ''); ?>
    </div>
<?php echo CHtml::endForm(); ?>
</div>