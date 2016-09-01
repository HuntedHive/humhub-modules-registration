<?php

use humhub\models\Setting;
use humhub\modules\registration\models\ManageRegistration;
use yii\helpers\Url;
use yii\helpers\Html;

?>
<?php 
$flag = Setting::find()->andWhere('name = "type_manage" AND value="'.ManageRegistration::$type[ManageRegistration::TYPE_TEACHER_INTEREST]. '"')->one()->value_text;
$required = Setting::find()->andWhere('name = "required_manage" AND value="'.ManageRegistration::$type[ManageRegistration::TYPE_TEACHER_INTEREST]. '"')->one()->value_text;
?>
<h4>Teacher Interests</h4>

<div class="table-responsive">
	<div class="row no-margin">
    	<div class="col-xs-6 no-padding">
			<h5><strong>Item Name</strong></h5>                     
    	</div>
        <div class="col-xs-6 no-padding">
            <div class="checkbox regular-checkbox-container pull-right checkbox-required">
                <label>
                    <a href='<?= Url::toRoute(['required', 'required' => ManageRegistration::TYPE_TEACHER_INTEREST]) ?>' data-method='post'>
                        <input class="regular-checkbox" type='checkbox' value="checkbox-required-teacherinterests" <?= $required?"checked":"" ?>/> required field
                        <div class="regular-checkbox-box"></div>
                    </a>
                </label>
                <div class="regular-checkbox-clear"></div>
            </div>
      	</div>
    </div>
    <div class="table-scrollable">
        <table class="table table-hover">    
            <tbody class='c_items' data-type="<?= ManageRegistration::TYPE_TEACHER_INTEREST ?>">
            <?php
            $other = false;
            if (empty($objects) && !$flag) {
                echo '<tr><td class="empty"><span class="empty">Add items to the list.</span></td></tr>';
            } else {
                foreach ($objects as $object) {
                    if((bool)$object->default) {
                        echo '<tr class="ui-sortable" data-item="item_'.$object->id.'"><td  style="z-index:99999;"><i class="fa fa-bars dragdrop"></i><span class="m_item" data-pk="' . $object->id . '" data-url="' . Url::toRoute('edit') . '">'.$object->name.'</span></td><td><a class="btn btn-danger btn-xs tt close" title="delete" href="' . Url::toRoute(['delete', 'id' => $object->id]) . '"><i class="fa fa-times"></i></a></td></tr>';
                    } else {
                        $other = true;
                    }
                }
            }

            if(($setting[ManageRegistration::TYPE_TEACHER_INTEREST]->value_text)) {
                echo '<tr class="ui-sortable">
                                <td class="col-sm-4" style="z-index:1000;">
                                    <i class="fa fa-bars dragdrop"></i>
                                    <span class="m_item">
                                          other
                                    </span>
                                </td>
                                <td class="col-sm-6">
                            </td>';
            }
            ?>
            </tbody>
        </table>
    </div>
</div>

          
<div class="form form-registration-items">
    <?php echo Html::beginForm('', 'post'); ?>
    <?php echo Html::activeHiddenInput($model[ManageRegistration::TYPE_TEACHER_INTEREST], 'type', ['value' => ManageRegistration::TYPE_TEACHER_INTEREST]); ?>
    <?php echo Html::activeHiddenInput($model[ManageRegistration::TYPE_TEACHER_INTEREST], 'default', ['value' => ManageRegistration::DEFAULT_ADDED]); ?>
    <div class="row controls">
        <div class="col-xs-12">
                <?php echo Html::errorSummary($model[ManageRegistration::TYPE_TEACHER_INTEREST], ['header' => '', 'style'=>'color:red']); ?>
        </div>
        <div class="col-sm-6 col-xs-12">
            <?php echo Html::activeTextInput($model[ManageRegistration::TYPE_TEACHER_INTEREST], 'name', array('class' => 'form-control input-sm', 'placeholder' => 'Enter item name',)); ?>
            <button type="submit" name="btn" class="btn btn-primary btn-sm">
                <i class="fa fa-plus"></i> add item
            </button>
        </div>

        <div class="col-sm-6 col-xs-12">
        	<div class="checkbox regular-checkbox-container pull-right">
                <label>
                    <a href='<?= Url::toRoute(['type', 'type' => ManageRegistration::TYPE_TEACHER_INTEREST]) ?>' data-method='post'>
                        <input class="regular-checkbox" type='checkbox' <?= $flag?"checked":"" ?>/> add 'other' option to list
                        <div class="regular-checkbox-box"></div>
                    </a>
                </label>
                <div class="regular-checkbox-clear"></div>
            </div>
        </div>
    </div>
	<?php echo Html::endForm(); ?>
</div>

<hr class="hr-spacer">

