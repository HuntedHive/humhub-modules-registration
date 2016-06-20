<?php 
$flag = HSetting::model()->find('name = "type_manage" AND value="'.ManageRegistration::$type[ManageRegistration::TYPE_TEACHER_TYPE]. '"')->value_text;
$required = HSetting::model()->find('name = "required_manage" AND value="'.ManageRegistration::$type[ManageRegistration::TYPE_TEACHER_TYPE]. '"')->value_text;
?>

<h4>Teacher Type</h4>

<div class="table-responsive">
	<div class="row no-margin">
	    <div class="col-xs-4 no-padding">
			<h5><strong>Item Name</strong></h5>
    	</div>
    	<div class="col-xs-4 no-padding">
			<h5><strong>APSTs</strong></h5>
    	</div>
        <div class="col-xs-4 no-padding">
            <div class="checkbox regular-checkbox-container pull-right checkbox-required">
                <label>
                    <a href='<?= $this->createUrl('required', ['required' => ManageRegistration::TYPE_TEACHER_TYPE]) ?>' data-method='post'>
                        <input class="regular-checkbox" type='checkbox' value="checkbox-required-teachertype" <?= $required?"checked":"" ?>/> required field
                        <div class="regular-checkbox-box"></div>
                    </a>
                </label>
                <div class="regular-checkbox-clear"></div>
            </div>
      	</div>
    </div>
    <div class="table-scrollable">
        <table class="table table-hover">
            <tbody class='c_items' data-type="<?= ManageRegistration::TYPE_TEACHER_TYPE ?>">
            <?php
            $other = false;
            if (empty($objects)) {
                echo '<tr><td class="empty"><span class="empty">Add items to the list.</span></td></tr>';
            } else {
                foreach ($objects as $object) {
                    if((bool)$object->default) {
                        echo '<tr class="ui-sortable" data-item="item_'.$object->id.'"><td  style="z-index:99999;"><i class="fa fa-bars dragdrop"></i><span class="m_item" data-pk="' . $object->id . '" data-url="' . $this->createUrl('edit') . '">'.$object->name.'</span></td><td class="apsts_file"><div class="pull-left">'.$object->file_name.'</div><div class="file_edit" data-id="'.$object->id.'" data-name="'.$object->file_name.'" data-type="'.trim($object->name).'"><i class="fa fa-pencil"></i>edit</div></td><td><a class="btn btn-danger btn-xs tt close" title="delete" href="' . $this->createUrl('delete', ['id' => $object->id]) . '"><i class="fa fa-times"></i></a></td></tr>';
                    } else {
                        $other = true;
                    }
                }
            }
            if(($setting[ManageRegistration::TYPE_TEACHER_TYPE]->value_text)) {

                $tdEdit = '';
                $obj =  ManageRegistration::model()->find('type=1 AND `default`=0 AND file_name is not NULL');
                if(empty($obj)) {
                    $obj = ManageRegistration::model()->find('type=1 AND `default`=0');
                }
                
                if(!empty($obj)) {
                    $tdEdit = '<td class="apsts_file"><div class="pull-left">'.$obj->file_name.'</div><div class="file_edit" data-id="'.$obj->id.'" data-name="'.$obj->file_name.'" data-type="'.trim($obj->name).'"><i class="fa fa-pencil"></i>'.(empty($obj->file_name)?"Add APSTs":"edit").'</div></td>';
                } else {
//                    $tdEdit = '<td class="apsts_file" data-name="other"><div class="file_edit"><i class="fa fa-pencil"></i>add apsts</div></td>';
                }

                echo '<tr class="ui-sortable">
                                <td class="col-sm-4" style="z-index:1000;">
                                    <i class="fa fa-bars dragdrop"></i>
                                    <span class="m_item">
                                          other
                                    </span>
                                </td>
                                ' . $tdEdit . '
                                <td class="col-sm-6">
                            </td>';
            }
            ?>
            </tbody>
        </table>
    </div>
</div>


<div class="form form-registration-items">
    <?php echo CHtml::beginForm('', 'post', array('enctype' => 'multipart/form-data')); ?>
    <?php echo CHtml::activeHiddenField($model[ManageRegistration::TYPE_TEACHER_TYPE], 'type', ['value' => ManageRegistration::TYPE_TEACHER_TYPE]); ?>
    <?php echo CHtml::activeHiddenField($model[ManageRegistration::TYPE_TEACHER_TYPE], 'default', ['value' => ManageRegistration::DEFAULT_ADDED]); ?>
    <div class="row controls">
        <div class="col-xs-12">
                <?php echo CHtml::errorSummary($model[ManageRegistration::TYPE_TEACHER_TYPE], '', ''); ?>
        </div>
        <div class="col-sm-9">
            <?php echo CHtml::activeTextField($model[ManageRegistration::TYPE_TEACHER_TYPE], 'name', array('class' => 'form-control input-sm', 'placeholder' => 'Enter item name',)); ?>
            <div class="input-group pull-left apst-field">
                <?php echo CHtml::activeFileField($model[ManageRegistration::TYPE_TEACHER_TYPE], 'file', array('class' => 'filestyle', 'placeholder' => 'Enter item name',)); ?>
            </div>
            <button type="submit" name="btn" class="btn btn-primary btn-sm pull-left">
                <i class="fa fa-plus"></i> add item
            </button>
        </div>

        <div class="col-sm-3">
        	<div class="checkbox regular-checkbox-container pull-right">
                <label>
                    <a href='<?= $this->createUrl('type', ['type' => ManageRegistration::TYPE_TEACHER_TYPE]) ?>' data-method='post'>
                        <input class="regular-checkbox" type='checkbox' <?= $flag?"checked":"" ?>/> add 'other' option to list
                        <div class="regular-checkbox-box"></div>
                    </a>
                </label>
                <div class="regular-checkbox-clear"></div>
            </div>
        </div>
    </div>
	<?php echo CHtml::endForm(); ?>
</div>

<hr class="hr-spacer">


<!-- Edit APST -->
<div class="modal fade modal-simple" id="editAPST" tabindex="-1" role="dialog" aria-labelledby="editAPST">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header modal-header-margin-bottom">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body text-center">
                <h3>Edit Australian Professional Standards<br> for Teachers</h3>
                <h5>Teacher Type - <span class="append-teacher-type"></span></h5
                <p>Please select a new APST file to upload or edit the content below.</p><br>
                <div class="form-group">
                    <?php echo CHtml::beginForm('', 'post', array('enctype' => 'multipart/form-data')); ?>

                    <div class="errorBlock errorSummary"></div>

                    <div class="col-xs-10">
                        <div class="input-group pull-left apst-field">
                            <?php echo CHtml::activeFileField($model[ManageRegistration::TYPE_TEACHER_TYPE], 'apstsfile', array('class' => 'styleapsts', 'placeholder' => 'Enter item name',)); ?>
                        </div>
                    </div>
                    <div class="APSTS_id">

                    </div>
                    <?php echo CHtml::endForm(); ?>
                    <a href="#" class="pull-left apst-clear">clear</a>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="modal-footer text-center">
                <hr>
                <button type="button" class="btn btn-default btn-sm pull-left" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary btn-sm pull-right apsts-update-modal">Save</button>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div><!-- /.modal -->
<script>
    var urlUpdateAPSTS = '<?= Yii::app()->createUrl("/registration/registration/updateAPSTS"); ?>';
</script>