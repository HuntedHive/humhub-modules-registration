<?php
use yii\helpers\Url;

?>
<link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
<script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
<script src="<?php echo $this->context->module->assetsUrl; ?>/js/jquery-ui.min.js"></script>
<script src="<?php echo $this->context->module->assetsUrl; ?>/js/registration.js"></script>
<script type="text/javascript" src="<?php echo $this->context->module->assetsUrl ?>/js/bootstrap-filestyle.min.js"> </script>

<link rel="stylesheet" type="text/css"
         href="<?php echo $this->context->module->assetsUrl; ?>/css/registration.css"/>

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
                    url: '<?= Url::toRoute("/registration/registration/sort") ?>',
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
                	<?= $this->render("_teacherLevel", ['model' => $model, 'objects' => $levels, 'setting' => $setting]) ?>
            	</div>
            </div>
            
            <div class='row'>
            	<div class="col-xs-12">
                	<?= $this->render("_teacherType", ['model' => $model, 'objects' => $types, 'setting' => $setting]) ?>
            	</div>
            </div>

            <div class='row'>
                <div class="col-xs-12">
					<?= $this->render("_subjectArea", ['model' => $model, 'objects' => $subjects, 'setting' => $setting]) ?>
            	</div>
            </div>

            <div class='row'>
            	<div class="col-xs-12">
                	<?= $this->render("_teacherInterests", ['model' => $model, 'objects' => $interests, 'setting' => $setting]) ?>
            	</div>
            </div>
        </div>
    </div>
</div>        
