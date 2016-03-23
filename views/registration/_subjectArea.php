<?php 
$flag = HSetting::model()->find('value="'.ManageRegistration::$type[ManageRegistration::TYPE_SUBJECT_AREA]. '"')->value_text;
?>
<h3>Teacher Subject Area</h3>
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
        if (empty($subjects)) {
            echo '<tr><td colspan="4" class="empty"><span class="empty">Нет результатов.</span></td></tr>';
        } else {
            foreach ($subjects as $subject) {
                echo '<tr><td colspan="4" class="empty"><span class="m_item" data-pk="' . $subject->id . '" data-url="' . $this->createUrl('edit') . '">'.$subject->name.'</span><a class="close" href="' . $this->createUrl('delete', ['id' => $subject->id]) . '">x</a></td></tr>';
            }
        }
        ?>
    </tbody>
</table>
<div class="form">
    <?php echo CHtml::beginForm(['action' => '', 'method' => 'post']); ?>
    <?php echo CHtml::activeHiddenField($model[ManageRegistration::TYPE_SUBJECT_AREA], 'type', ['value' => ManageRegistration::TYPE_SUBJECT_AREA]); ?>
        <?php echo CHtml::activeHiddenField($model[ManageRegistration::TYPE_SUBJECT_AREA], 'default', ['value' => ManageRegistration::DEFAULT_ADDED]); ?>
    <div class="row pull-left col-lg-4">
<?php echo CHtml::activeTextField($model[ManageRegistration::TYPE_SUBJECT_AREA], 'name'); ?>
    </div>
    <div class="row submit pull-left col-lg-4">
        <input type="submit" name="btn" class="btn btn-primary" />
    </div>
    <div class="row submit pull-left col-lg-4">
        <a href='<?= $this->createUrl('type', ['type' => ManageRegistration::TYPE_SUBJECT_AREA]) ?>' data-method='post'>
            <input type='checkbox' <?= $flag?"checked":"" ?>/> add 'other' option to list
        </a>
    </div>
    <div class='row pull-left col-lg-12'>
            <?php echo CHtml::errorSummary($model[ManageRegistration::TYPE_SUBJECT_AREA], '', ''); ?>
    </div>
<?php echo CHtml::endForm(); ?>
</div>