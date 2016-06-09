$(document).ready(function(){
   $(".subject_close").on("click", function() {
       var dataId = $(this).data('id');
       var dataDepend = $(this).data('depend');
       var currentItem = $(this);
       var parentTD = $(this).parents("td");

       $.ajax({
           url: urlDelete,
           data: {"dataId":dataId, "dataDepend":dataDepend},
           type: 'POST',
           success: function(data) {
               if(data) {
                   currentItem.parent(".label").remove();
                   if(parentTD.find("span").length == 0) {
                       parentTD.parents("tr").remove();
                   }
               }
           }
       });
   });
});