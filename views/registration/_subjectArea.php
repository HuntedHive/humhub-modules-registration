<?php 
$flag = HSetting::model()->find('value="'.ManageRegistration::$type[ManageRegistration::TYPE_SUBJECT_AREA]. '"')->value_text;
?>

<link rel="stylesheet" type="text/css"
         href="<?php echo $this->module->assetsUrl; ?>/css/registration.css"/>

<h4>Teacher Subject Area</h4>

<div class="table-responsive">
	<div class="row no-margin">
    	<div class="col-xs-4 no-padding">
			<h5><strong>Item Name</strong></h5>                     
    	</div>
        <div class="col-xs-4 no-padding">
            <h5><strong>Relates to Teacher Types</strong></h5>
        </div>
        <div class="col-xs-4 no-padding">
            <div class="checkbox regular-checkbox-container pull-right checkbox-required">
                <label>
                    <input class="regular-checkbox" type='checkbox' value="checkbox-required-subjectarea"/> required field
                    <div class="regular-checkbox-box"></div>
                </label>
                <div class="regular-checkbox-clear"></div>
            </div>
      	</div>
    </div>
    <div class="table-scrollable">
        <table class="table table-hover">    
            <tbody class="c_items" data-type="<?= ManageRegistration::TYPE_SUBJECT_AREA ?>">
				<?php
                if (empty($subjects)) {
                    echo '<tr><td class="empty"><span class="empty">Add items to the list.</span></td></tr>';
                } else {
                    foreach ($subjects as $subject) {
                        echo '<tr class="ui-sortable" data-item="item_'.$subject->id.'"><td class="col-sm-4" style="z-index:99999;"><i class="fa fa-bars dragdrop"></i><span class="m_item" data-pk="' . $subject->id . '" data-url="' . $this->createUrl('edit') . '">'.$subject->name.'</span></td><td class="col-sm-6"><span class="label label-success">' . ManageRegistration::getDependName($subject->depend) . '</span></td><td class="col-sm-2"><a class="btn btn-danger btn-xs tt close" href="' . $this->createUrl('delete', ['id' => $subject->id]) . '" title="delete item"><i class="fa fa-times"></i></a></td></tr>';
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

          
<div class="form form-registration-items">
    <?php echo CHtml::beginForm(['action' => '', 'method' => 'post']); ?>
    <div class="row controls">

        <div class="col-md-8 selectpicker-tags">
            <?php echo CHtml::activeTextField($model[ManageRegistration::TYPE_SUBJECT_AREA], 'name', array('class' => 'form-control input-sm pull-left', 'placeholder' => 'Enter item name',)); ?>
            <!-- Existing Selectbox <?php echo CHtml::activeDropDownList($model[ManageRegistration::TYPE_SUBJECT_AREA], 'depend', ManageRegistration::getTeachetTypeDropDownList() , array('class' => 'form-control input-sm selectpicker show-tick pull-left')); ?> -->
            <select name="subjectarea" class="selectpicker form-control show-tick input-sm pull-left" multiple title="Select related teacher type(s)...">
                <optgroup label="Select related teacher type(s)">
                  <option  data-content="<span class='label label-success'>primary school</span>">primary school</option>
                  <option  data-content="<span class='label label-success'>high school</span>">high school</option>
                  <option  data-content="<span class='label label-success'>other</span>">other</option>
                </optgroup>
            </select>

            <button type="submit" name="btn" class="btn btn-primary btn-sm pull-left">
                <i class="fa fa-plus"></i> add item
            </button>
            <div class="clearfix"></div>
        </div>

        <div class="col-md-4">
        	<div class="checkbox regular-checkbox-container pull-right">
                <label>
                    <a href='<?= $this->createUrl('type', ['type' => ManageRegistration::TYPE_SUBJECT_AREA]) ?>' data-method='post'>
                        <input class="regular-checkbox" type='checkbox' <?= $flag?"checked":"" ?>/> add 'other' option to list
                        <div class="regular-checkbox-box"></div>
                    </a>
                </label>
                <div class="regular-checkbox-clear"></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
             <?php echo CHtml::errorSummary($model[ManageRegistration::TYPE_SUBJECT_AREA], '', ''); ?>
             <?php echo CHtml::activeHiddenField($model[ManageRegistration::TYPE_SUBJECT_AREA], 'type', ['value' => ManageRegistration::TYPE_SUBJECT_AREA]); ?>
             <?php echo CHtml::activeHiddenField($model[ManageRegistration::TYPE_SUBJECT_AREA], 'default', ['value' => ManageRegistration::DEFAULT_ADDED]); ?>
        </div>
    </div>
	<?php echo CHtml::endForm(); ?>
</div>

<hr class="hr-spacer">

