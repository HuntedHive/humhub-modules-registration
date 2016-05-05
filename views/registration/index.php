<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
<script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>


<link rel="stylesheet" type="text/css"
         href="<?php echo $this->module->assetsUrl; ?>/css/registration.css"/>

<script>
    $(document).ready(function() {
        /* Sortable on Jquery UI library */
        $( ".c_items" ).sortable({
            placeholder: "grid-view table tbody tr",
            update: function(event, ui) {
                var sort = $(this);
                var type = $(this).data('type');
                var items = new Array();
                var data = sort[0].children;

                for(var i=0; i<data.length;i++) {
                    items[i] = (data[i].dataset.item).split('_')[1];
                }
                console.log(items);
                $.ajax({
                    type: 'POST',
                    url: '<?= Yii::app()->createUrl("/registration/registration/sort") ?>',
                    data: {'data':items,'type':type},
                    success: function(data) {
                    }
                });
            }
        });
        
        /* Edit in line library */
        $.fn.editable.defaults.mode = 'inline';
        $.fn.editable.defaults.ajaxOptions = {type: "POST"};
        $('.m_item').editable({
            type: 'text',
            success: function(response, newValue) {
            }
        });
    });
</script>

<div class="panel panel-default">
    <div class="panel-heading"><strong>Manage</strong> Registration</div>
     
    <div class="panel-body">
    	<p>Edit the dropdown options available during user registration.</p>
        <div id="user-grid">
            
            <div class='row'>
            	<div class="col-xs-12">
                	<?php $this->renderPartial("_teacherLevel", ['model' => $model, 'levels' => $levels, 'setting' => $setting]) ?>
            	</div>
            </div>
            
            <div class='row'>
            	<div class="col-xs-12">
                	<?php $this->renderPartial("_teacherType", ['model' => $model, 'types' => $types, 'setting' => $setting]) ?>
            	</div>
            </div>
            
            <div class='row'>
                <div class="col-xs-12">
					<?php $this->renderPartial("_subjectArea", ['model' => $model, 'subjects' => $subjects, 'setting' => $setting]) ?>
            	</div>
            </div>
            
            <div class='row'>
            	<div class="col-xs-12">
                	<?php $this->renderPartial("_teacherInterests", ['model' => $model, 'interests' => $interests, 'setting' => $setting]) ?>
            	</div>
            </div>

            <div class='row'>
                <div class="col-xs-12">
                    <?php $this->renderPartial("_teacherOther", ['model' => $model, 'others' => $others, 'setting' => $setting]) ?>
                </div>
            </div>
        </div>
    </div>
</div>        
