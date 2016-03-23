  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
<script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
<script src="http://farhadi.ir/projects/html5sortable/jquery.sortable.js"></script>
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
</style>
<script>
    $(document).ready(function() {
        $.fn.editable.defaults.mode = 'inline';
        $.fn.editable.defaults.ajaxOptions = {type: "POST"};
        $('.m_item').editable({
            type: 'text',
            success: function(response, newValue) {
            }
        });
        
        $( ".c_items" ).sortable({
            placeholder: "gets"
        });
        $( ".c_items2" ).sortable({
            placeholder: "gets"
        });
        $('.c_items').bind('sortupdate', function(event, ui) {
            var sort = $(this).sortable('serialize');
            var type = $(this).data('type');
            var items = new Array();
            var data = sort[0].children;
            for(var i=0; i<data.length;i++) {
                items[i] = (data[i].className).split('_')[1];
            }
            
            $.ajax({
                type: 'POST',
                url: window.location.href.split('?')[0]+"?r=registration/registration/sort",
                data: {'data':items,'type':type},
                success: function(data) {
                }
            });
        });
        
    });
</script>
<div class="col-md-9">
    <div class="panel panel-default">
        <div class="panel-heading"><strong>Manage</strong> Reginstration</div>
        <div class="panel-body">
            <ul class="nav nav-pills">
                <li>
                </li>
            </ul>
            <p>
                Edit the dropdown options available during user registration
            </p>
            <div id="user-grid" class="grid-view">
                
                <div class='row'>
                    <?php $this->renderPartial("_teacherLevel", ['model' => $model, 'levels' => $levels]) ?>
                </div>
                
                <div class='row'>
                    <?php $this->renderPartial("_teacherType", ['model' => $model, 'types' => $types]) ?>
                </div>
                
                <div class='row'>
                    <?php $this->renderPartial("_subjectArea", ['model' => $model, 'subjects' => $subjects]) ?>
                </div>
                
                <div class='row'>
                    <?php $this->renderPartial("_teacherInterests", ['model' => $model, 'interests' => $interests]) ?>
                </div>
            </div>
        </div>
    </div>        
</div>
