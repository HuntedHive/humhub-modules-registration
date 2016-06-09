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
                        echo '<tr class="ui-sortable" data-item="item_'.$object->id.'"><td  style="z-index:99999;"><i class="fa fa-bars dragdrop"></i><span class="m_item" data-pk="' . $object->id . '" data-url="' . $this->createUrl('edit') . '">'.$object->name.'</span></td><td><a class="btn btn-danger btn-xs tt close" title="delete" href="' . $this->createUrl('delete', ['id' => $object->id]) . '"><i class="fa fa-times"></i></a></td></tr>';
                    } else {
                        $other = true;
                    }
                }
            }
            if(($setting[ManageRegistration::TYPE_TEACHER_TYPE]->value_text)) {
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
    <?php echo CHtml::beginForm(['action' => '', 'method' => 'post']); ?>
    <?php echo CHtml::activeHiddenField($model[ManageRegistration::TYPE_TEACHER_TYPE], 'type', ['value' => ManageRegistration::TYPE_TEACHER_TYPE]); ?>
    <?php echo CHtml::activeHiddenField($model[ManageRegistration::TYPE_TEACHER_TYPE], 'default', ['value' => ManageRegistration::DEFAULT_ADDED]); ?>
    <div class="row controls">
        <div class="col-xs-12">
                <?php echo CHtml::errorSummary($model[ManageRegistration::TYPE_TEACHER_TYPE], '', ''); ?>
        </div>
        <div class="col-sm-9">
            <?php echo CHtml::activeTextField($model[ManageRegistration::TYPE_TEACHER_TYPE], 'name', array('class' => 'form-control input-sm', 'placeholder' => 'Enter item name',)); ?>
            <div class="input-group pull-left apst-field">
               <input type="text" class="form-control input-sm" placeholder="Upload APSTs">
               <span class="input-group-btn">
                    <button class="btn btn-default btn-sm" type="button">Browse</button>
               </span>
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
                <h5>Teacher Type - Teacher Type 1</h5
                <p>Please select a new APST file to upload or edit the content below.</p><br>
                <div class="form-group">
                    <div class="input-group">
                       <input type="text" class="form-control input-md" placeholder="Upload APSTs" value="filename.xlsx">
                       <span class="input-group-btn">
                            <button class="btn btn-default btn-md" type="button">Browse</button>
                       </span>
                    </div>
                    <a href="#" class="pull-left apst-clear">clear</a>
                    <div class="clearfix"></div>
                </div>
                <div class="table-responsive hidden">
                    <table class="table table-striped text-left">
                        <thead>
                            <tr>
                                <td></td>
                                <th>Short Title</th>
                                <th>Description</th>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><i class="fa fa-bars dragdrop"></i></td>
                                <td>1.2 Understand how students learn</td>
                                <td>Demonstrate knowledge and understanding of research into how students learn and the implications for teaching.</td>
                                <td><a class="btn btn-danger btn-xs tt close" title="delete" href="/teachconnect-6/humhub/index.php/registration/registration/delete/id/2"><i class="fa fa-times"></i></a></td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-bars dragdrop"></i></td>
                                <td>1.3 Students with diverse linguistic, cultural, religious and socioeconomic backgrounds</td>
                                <td>Demonstrate knowledge of teaching strategies that are responsive to the learning strengths and needs of students from diverse linguistic, cultural, religious and socioeconomic backgrounds.</td>
                                <td><a class="btn btn-danger btn-xs tt close" title="delete" href="/teachconnect-6/humhub/index.php/registration/registration/delete/id/2"><i class="fa fa-times"></i></a></td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-bars dragdrop"></i></td>
                                <td>1.5 Differentiate teaching to meet the specific learning needs of students across the full range of abilities</td>
                                <td>Demonstrate knowledge and understanding of strategies for differentiating teaching to meet the specific learning needs of students across the full range of abilities.</td>
                                <td><a class="btn btn-danger btn-xs tt close" title="delete" href="/teachconnect-6/humhub/index.php/registration/registration/delete/id/2"><i class="fa fa-times"></i></a></td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-bars dragdrop"></i></td>
                                <td>2.1 Content and teaching strategies of the teaching area</td>
                                <td>Demonstrate knowledge and understanding of the concepts, substance and structure of the content and teaching strategies of the teaching area.</td>
                                <td><a class="btn btn-danger btn-xs tt close" title="delete" href="/teachconnect-6/humhub/index.php/registration/registration/delete/id/2"><i class="fa fa-times"></i></a></td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-bars dragdrop"></i></td>
                                <td>2.2 Content selection and organisation</td>
                                <td>Organise content into an effective learning and teaching sequence.</td>
                                <td><a class="btn btn-danger btn-xs tt close" title="delete" href="/teachconnect-6/humhub/index.php/registration/registration/delete/id/2"><i class="fa fa-times"></i></a></td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-bars dragdrop"></i></td>
                                <td>2.3 Curriculum, assessment and reporting</td>
                                <td>Use curriculum, assessment and reporting knowledge to design learning sequences and lesson plans.</td>
                                <td><a class="btn btn-danger btn-xs tt close" title="delete" href="/teachconnect-6/humhub/index.php/registration/registration/delete/id/2"><i class="fa fa-times"></i></a></td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-bars dragdrop"></i></td>
                                <td>6.2 Engage in professional learning and improve practice</td>
                                <td>Understand the relevant and appropriate sources of professional learning for teachers.</td>
                                <td><a class="btn btn-danger btn-xs tt close" title="delete" href="/teachconnect-6/humhub/index.php/registration/registration/delete/id/2"><i class="fa fa-times"></i></a></td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-bars dragdrop"></i></td>
                                <td>6.3 Engage with colleagues and improve practice</td>
                                <td>Seek and apply constructive feedback from supervisors and teachers to improve teaching practices.</td>
                                <td><a class="btn btn-danger btn-xs tt close" title="delete" href="/teachconnect-6/humhub/index.php/registration/registration/delete/id/2"><i class="fa fa-times"></i></a></td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-bars dragdrop"></i></td>
                                <td>7.4 Engage with professional teaching networks and broader communities</td>
                                <td>Understand the role of external professionals and community representatives in broadening teachers’ professional knowledge and practice.</td>
                                <td><a class="btn btn-danger btn-xs tt close" title="delete" href="/teachconnect-6/humhub/index.php/registration/registration/delete/id/2"><i class="fa fa-times"></i></a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="apst-controls hidden">
                    <br>
                    <button type="button" class="btn btn-default btn-sm pull-right" data-dismiss="modal"><i class="fa fa-plus"></i> Add Row</button>
                    <button type="button" class="btn btn-default btn-sm pull-right" data-dismiss="modal" style="margin-right:5px;">Export APSTS</button>
                    <br>
                </div>
            </div>
            <div class="modal-footer text-center">
                <hr>
                <button type="button" class="btn btn-default btn-sm pull-left" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary btn-sm pull-right" data-dismiss="modal">Save</button>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div><!-- /.modal -->