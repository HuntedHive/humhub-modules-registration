<?php

use humhub\models\Setting;
use humhub\modules\registration\models\ManageRegistration;
use yii\helpers\Url;
use yii\helpers\Html;

?>
<?php
$flag = Setting::find()->andWhere('name = "type_manage" AND value="'.ManageRegistration::$type[ManageRegistration::TYPE_SUBJECT_AREA]. '"')->one()->value_text;
$required = Setting::find()->andWhere('name = "required_manage" AND value="'.ManageRegistration::$type[ManageRegistration::TYPE_SUBJECT_AREA]. '"')->one()->value_text;
?>

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
                    <a href='<?= Url::toRoute('required', ['required' => ManageRegistration::TYPE_SUBJECT_AREA]) ?>' data-method='post'>
                        <input class="regular-checkbox" type='checkbox' value="checkbox-required-subjectarea" <?= $required?"checked":"" ?>/> required field
                        <div class="regular-checkbox-box"></div>
                    </a>
                </label>
                <div class="regular-checkbox-clear"></div>
            </div>
      	</div>
    </div>
    <div class="table-scrollable">
        <table class="table table-hover">    
            <tbody class="c_items" data-type="<?= ManageRegistration::TYPE_SUBJECT_AREA ?>">
				<?php
                $other = false;
                if (empty($objects)) {
                    echo '<tr><td class="empty"><span class="empty">Add items to the list.</span></td></tr>';
                } else {
                    foreach ($objects as $subject) {
                        if($subject->default && strtolower($subject->name) != "other") {
                        echo '<tr class="ui-sortable" data-item="item_' . $subject->id . '">
                                <td class="col-sm-4" style="z-index:1000;">
                                    <i class="fa fa-bars dragdrop"></i>
                                    <span class="m_item" data-pk="' . $subject->id . '" data-url="' . Url::toRoute('editSubject') . '" data-name="' . $subject->name . '">
                                        ' . $subject->name . '
                                    </span>
                                </td>
                                <td class="col-sm-6">'
                            . ManageRegistration::getDependNames($subject->name, $subject->type) .
                            '</td>
                                <td class="col-sm-2">
                                    <a class="btn btn-danger btn-xs tt close" title="delete" href="' . Url::toRoute('deleteSubject', ['name' => $subject->name]) . '">
                                        <i class="fa fa-times"></i>
                                    </a>
                                </td>
                              </tr>';
                        } else {
                            $other = true;
                        }
                    }

                    if(($setting[ManageRegistration::TYPE_SUBJECT_AREA]->value_text)) {
                        echo '<tr class="ui-sortable">
                                <td class="col-sm-4" style="z-index:1000;">
                                    <i class="fa fa-bars dragdrop"></i>
                                    <span class="m_item">
                                          other
                                    </span>
                                </td>
                                <td class="col-sm-6">
                                <td class="col-sm-2">
                            </td>';
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

          
<div class="form form-registration-items">
    <?php echo Html::beginForm('', 'post'); ?>
    <div class="row controls">

        <div class="col-xs-6 selectpicker-tags">
            <?php echo Html::activeTextInput($model[ManageRegistration::TYPE_SUBJECT_AREA], 'name', array('class' => 'form-control input-sm pull-left', 'placeholder' => 'Enter item name',)); ?>
            <!-- Existing Selectbox <?php echo Html::activeDropDownList($model[ManageRegistration::TYPE_SUBJECT_AREA], 'depend', ManageRegistration::getTeachetTypeDropDownList() , array('class' => 'form-control input-sm selectpicker show-tick pull-left')); ?> -->
            <select name="ManageRegistration[subjectarea][]" class="selectpicker form-control show-tick input-sm pull-left" multiple title="Select related teacher type(s)...">
                <optgroup label="Select related teacher type(s)">
                    <?php
                        $other = false;
                        foreach (ManageRegistration::find()->andWhere("`default`=". ManageRegistration::DEFAULT_ADDED .  " AND type=" . ManageRegistration::TYPE_TEACHER_TYPE )->all() as $item) {
                                echo "<option  data-content='" . $item->name . "'>$item->name</option>";
                        }
                    ?>
                    <?php
                        if(($setting[ManageRegistration::TYPE_TEACHER_TYPE]->value_text)) {
                            echo "<option  data-content='other'>other</option>";
                        }
                    ?>
                </optgroup>
            </select>

            <button type="submit" name="btn" class="btn btn-primary btn-sm pull-left">
                <i class="fa fa-plus"></i> add item
            </button>
            <div class="clearfix"></div>
        </div>

        <div class="col-xs-6">
        	<div class="checkbox regular-checkbox-container pull-right">
                <label>
                    <a href='<?= Url::toRoute('type', ['type' => ManageRegistration::TYPE_SUBJECT_AREA]) ?>' data-method='post'>
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
             <?php echo Html::errorSummary($model[ManageRegistration::TYPE_SUBJECT_AREA], ['header' => '', 'style' => 'color:red']); ?>
             <?php echo Html::activeHiddenInput($model[ManageRegistration::TYPE_SUBJECT_AREA], 'type', ['value' => ManageRegistration::TYPE_SUBJECT_AREA]); ?>
             <?php echo Html::activeHiddenInput($model[ManageRegistration::TYPE_SUBJECT_AREA], 'default', ['value' => ManageRegistration::DEFAULT_ADDED]); ?>
        </div>
    </div>
	<?php echo Html::endForm(); ?>
</div>

<hr class="hr-spacer">
<script>
    var urlDelete = '<?= Url::toRoute("/registration/registration/delete-subject-item"); ?>';
</script>

