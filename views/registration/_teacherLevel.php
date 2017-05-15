<?php

use humhub\models\Setting;
use humhub\modules\registration\models\ManageRegistration;
use yii\helpers\Url;
use yii\helpers\Html;

?>
<?php
$flag = Setting::find()->andWhere('name = "type_manage" AND value="' . ManageRegistration::$type[ManageRegistration::TYPE_TEACHER_LEVEL] . '"')->one()->value_text;
$required = Setting::find()->andWhere('name = "required_manage" AND value="' . ManageRegistration::$type[ManageRegistration::TYPE_TEACHER_LEVEL] . '"')->one()->value_text;
?>
<h4>Teacher Level</h4>

<div class="table-responsive">
    <div class="row no-margin">
        <div class="col-xs-4 no-padding">
            <h5><strong>Item Name</strong></h5>
        </div>
        <div class="col-xs-3 no-padding">
            <h5><strong>APSTs</strong></h5>
        </div>
        <div class="col-xs-5 no-padding">
            <div class="checkbox regular-checkbox-container pull-right checkbox-required">
                <label>
                    <a href='<?= Url::toRoute(['required', 'required' => ManageRegistration::TYPE_TEACHER_LEVEL]) ?>'
                       data-method='post'>
                        <input class="regular-checkbox" type='checkbox' <?= $required ? "checked" : "" ?>
                               value="checkbox-required-teacherlevel" <?= $required ? "checked" : "" ?>/> required field
                        <div class="regular-checkbox-box"></div>
                    </a>
                </label>
                <div class="regular-checkbox-clear"></div>
            </div>
        </div>
    </div>
    <div class="table-scrollable">
        <table class="table table-hover">
            <tbody class='c_items' data-type="<?= ManageRegistration::TYPE_TEACHER_LEVEL ?>">
            <?php
            $other = false;
            if (empty($objects) && !$flag) {
                echo '<tr><td class="empty"><span class="empty">Add items to the list.</span></td></tr>';
            } else {
                foreach ($objects as $object) {
                    if ((bool)$object->default) {
                        echo '<tr class="ui-sortable" data-item="item_' . $object->id . '">
                                <td  style="z-index:99999;">
                                <i class="fa fa-bars dragdrop"></i>
                                <span class="m_item" data-pk="' . $object->id . '" data-url="' . Url::toRoute('edit') . '">' . $object->name . '</span>
                                </td>
                                <td class="apsts_file"><div class="pull-left">' . $object->file_name . '</div>
                                <div class="file_edit" data-id="' . $object->id . '" data-name="' . $object->file_name . '" data-type="' . trim($object->name) . '">
                                <i class="fa fa-pencil"></i>'.(empty($object->file_name) ? "Add APSTs" : "edit").'</div></td>
                                <td><a class="btn btn-danger btn-xs tt close" title="delete" href="' . Url::toRoute(['delete', 'id' => $object->id]) . '">
                                <i class="fa fa-times"></i></a></td></tr>';
                    } else {
                        $other = true;
                    }
                }
            }
            if (($setting[ManageRegistration::TYPE_TEACHER_LEVEL]->value_text)) {
                $tdEdit = '';
                $obj = ManageRegistration::find()->andWhere('type=0 AND `default`=0 AND file_name is not NULL')->one();
                if (empty($obj)) {
                    $obj = ManageRegistration::find()->andWhere('type=0 AND `default`=0')->one();
                    if (empty($obj)) {
                        $obj = new ManageRegistration();
                        $obj->name = 'othersFildn';
                        $obj->type = ManageRegistration::TYPE_TEACHER_LEVEL;
                        $obj->default = ManageRegistration::DEFAULT_DEFAULT;
                        $obj->save(false);
                    }
                }

                if (!empty($obj)) {
                    $tdEdit = '<td class="apsts_file"><div class="pull-left">' .
                        $obj->file_name . '</div><div class="file_edit" data-id="' .
                        $obj->getPrimaryKey() . '" data-name="' . $obj->file_name .
                        '" data-type="' . trim($obj->name) . '">
                        <i class="fa fa-pencil"></i>' .
                        (empty($obj->file_name) ? "Add APSTs" : "edit") . '</div></td>';
                } else {
                    // $tdEdit = '<td class="apsts_file" data-name="other"><div class="file_edit"><i class="fa fa-pencil"></i>add apsts</div></td>';
                }

                if (($setting[ManageRegistration::TYPE_TEACHER_LEVEL]->value_text)) {
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
            }
            ?>
            </tbody>
        </table>
    </div>
</div>

<div class="form form-registration-items">
    <?php echo Html::beginForm('', 'post', array('enctype' => 'multipart/form-data')); ?>
    <?php echo Html::activeHiddenInput($model[ManageRegistration::TYPE_TEACHER_LEVEL], 'type', ['value' => ManageRegistration::TYPE_TEACHER_LEVEL]); ?>
    <?php echo Html::activeHiddenInput($model[ManageRegistration::TYPE_TEACHER_LEVEL], 'default', ['value' => ManageRegistration::DEFAULT_ADDED]); ?>
    <div class="row controls">
        <div class="col-xs-12">
            <?php echo Html::errorSummary($model[ManageRegistration::TYPE_TEACHER_LEVEL], ['header' => '', 'style' => 'color:red']); ?>
        </div>

        <div class="col-sm-8">
            <?php echo Html::activeTextInput($model[ManageRegistration::TYPE_TEACHER_LEVEL], 'name', array('class' => 'form-control input-sm', 'placeholder' => 'Enter item name',)); ?>
            <div class="input-group pull-left apst-field">
                <?php echo Html::activeFileInput($model[ManageRegistration::TYPE_TEACHER_LEVEL], 'file', array('class' => 'filestyle', 'placeholder' => 'Enter item name',)); ?>
            </div>
            <button type="submit" name="btn" class="btn btn-primary btn-sm pull-left">
                <i class="fa fa-plus"></i> add item
            </button>
        </div>
        <div class="col-sm-4">
            <div class="checkbox regular-checkbox-container pull-right">
                <label>
                    <a href='<?= Url::toRoute(['type', 'type' => ManageRegistration::TYPE_TEACHER_LEVEL]) ?>'
                       data-method='post'>
                        <input class="regular-checkbox" type='checkbox' <?= $flag ? "checked" : "" ?>/> add 'other'
                        option to list
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

<!-- Edit APST -->
<div class="modal fade modal-simple" id="editAPST" tabindex="-1" role="dialog" aria-labelledby="editAPST">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header modal-header-margin-bottom">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <h3>Australian Professional Standards<br> for Teachers</h3>
                <h5>Teacher Level - <span class="append-teacher-type"></span></h5
                <p>Please select a new APST file to upload or edit the content below.</p><br>
                <div class="form-group">
                    <?php echo Html::beginForm('', 'post', array('enctype' => 'multipart/form-data')); ?>

                    <div class="errorBlock errorSummary"></div>

                    <div class="col-xs-10">
                        <div class="input-group pull-left apst-field">
                            <?php echo Html::activeFileInput($model[ManageRegistration::TYPE_TEACHER_LEVEL], 'apstsfile', array('class' => 'styleapsts', 'placeholder' => 'Enter item name',)); ?>
                        </div>
                    </div>
                    <div class="APSTS_id">

                    </div>
                    <?php echo Html::endForm(); ?>
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
    var urlUpdateAPSTS = '<?= Url::toRoute(["/registration/registration/update-apsts"]); ?>';
</script>

