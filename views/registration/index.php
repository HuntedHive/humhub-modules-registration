<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
<script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<style>
    .grid-view table tbody tr {
        margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em; height: 18px; 
    }

    .gets {
        border:1px solid black;
        height:100px;
        background: red;
        position: relative;
    }

    .table-scrollable {
            overflow-x: hidden; 
            overflow-y: scroll; 
            height: 120px; 
            width: 100%;
            display:block;
    }

    .table=scrollable .fa {
            margin-right:10px;
    }

    .form-registration-items input {
            margin-right: 10px; 
            padding-top: 2px; 
            padding-bottom: 2px; 
            height: auto;
            width:auto;
            float:left;
    }

    .form-registration-items .checkbox {
            margin-right: 20px;
    }

    .form-registration-items .checkbox.pull-right {
            float:right;
            margin-top:0px;
            margin-bottom:0px;
    }

    .form-registration-items .controls {
            margin-top:10px;
    }

    .ui-sortable {
            cursor:pointer;
    }

    .ui-sortable .close {
            padding: 3px 5px;
            font-size: 11px;
            opacity:1;
            margin-right:10px;
    }

    .ui-sortable .dragdrop {
            margin-right:10px;
    }

    .errorSummary {
            color:#dc4226;
    }

    .errorSummary ul {
            padding-left: 0px;
            list-style: none;
    }

    .hr-spacer {
            margin:30px 0px;
    }

    @media (max-width: 767px) {
            .form-registration-items .checkbox.pull-right{
                    float:left !important;
                    margin-top:20px !important;
                    margin-bottom:10px;
            }

    }
</style>

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

                $.ajax({
                    type: 'POST',
                    url: window.location.href.split('?')[0]+"?r=registration/registration/sort",
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
                	<?php $this->renderPartial("_teacherLevel", ['model' => $model, 'levels' => $levels]) ?>
            	</div>
            </div>
            
            <div class='row'>
            	<div class="col-xs-12">
                	<?php $this->renderPartial("_teacherType", ['model' => $model, 'types' => $types]) ?>
            	</div>
            </div>
            
            <div class='row'>
                <div class="col-xs-12">
					<?php $this->renderPartial("_subjectArea", ['model' => $model, 'subjects' => $subjects]) ?>
            	</div>
            </div>
            
            <div class='row'>
            	<div class="col-xs-12">
                	<?php $this->renderPartial("_teacherInterests", ['model' => $model, 'interests' => $interests]) ?>
            	</div>
            </div>
        </div>
    </div>
</div>        
