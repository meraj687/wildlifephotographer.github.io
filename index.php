<!DOCTYPE html>  
<html>  
 <head>  
  <title>Php</title>  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
        
   <style>
           .container h3{
               background-color:lightseagreen;
               font-family: verdana;
               font-size: 300%;
               
               border: 2px solid powderblue;
               padding: 30px;
               box-shadow: 10px 10px 8px 10px #888888;
           }
           #add{
               font-size: 200%;
               width: 284px;
               padding: 10px 10px 20px 10px;
               border: 1px solid #BFBFBF;
               background-color: cadetblue;
               box-shadow: 10px 10px 5px #aaaaaa;
               
               cursor: pointer;
           }
           #imageModal{
               color: darkcyan;
               font-family: sans-serif;
           }
          #action{
            font-family: verdana;
          }
          .modal-footer{
               font-family: verdana;
               font-size: 300%;
               box-shadow: 10px 10px 5px #aaaaaa;
          }
          #closebtn{
            box-shadow: 10px 10px 5px #aaaaaa;
          }
          .btn{
            box-shadow: 5px 5px 8px 5px #888888;
          }
          .table th{
             font-size: medium;   
             font-family: 'Times New Roman', Times, serif;
             padding-left: 250 70;
             scroll-behavior: smooth;
          }
   </style>    

 </head>  
 <body>  
  <br /><br />  
  <div class="container" style="width:900px;">  
   <h3 align="center" style="color:darkred;" >WILDLIFE PHOTOGRAPHER</h3>  
   <br />
   <div align="center" >
    <button type="button" name="add" id="add" class="btn btn-success">Add</button>
   </div>
   <br />
   <div id="image_data">

   </div>
  </div>  
 </body>  
</html>

<div id="imageModal" class="modal fade" role="dialog">
 <div class="modal-dialog">
  <div class="modal-content">
   <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Add Image</h4>
   </div>
   <div class="modal-body">
    <form id="image_form" method="post" enctype="multipart/form-data">
     <p><label>Select Image</label>
     <input type="file" name="image" id="image" /></p><br />
     <input type="hidden" name="action" id="action" value="insert" />
     <input type="hidden" name="image_id" id="image_id" />
     <input type="submit" name="insert" id="insert" value="Insert" class="btn btn-info" />
      
    </form>
   </div>
   <div class="modal-footer">
    <button id="closebtn" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
   </div>
  </div>
 </div>
</div>
 
<script>  
$(document).ready(function(){
 
 fetch_data();

 function fetch_data()
 {
  var action = "fetch";
  $.ajax({
   url:"action.php",
   method:"POST",
   data:{action:action},
   success:function(data)
   {
    $('#image_data').html(data);
   }
  })
 }
 $('#add').click(function(){
  $('#imageModal').modal('show');
  $('#image_form')[0].reset();
  $('.modal-title').text("Add Image");
  $('#image_id').val('');
  $('#action').val('insert');
  $('#insert').val("Insert");
 });
 $('#image_form').submit(function(event){
  event.preventDefault();
  var image_name = $('#image').val();
  if(image_name == '')
  {
   alert("Please Select Image");
   return false;
  }
  else
  {
   var extension = $('#image').val().split('.').pop().toLowerCase();
   if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)
   {
    alert("Invalid Image File");
    $('#image').val('');
    return false;
   }
   else
   {
    $.ajax({
     url:"action.php",
     method:"POST",
     data:new FormData(this),
     contentType:false,
     processData:false,
     success:function(data)
     {
      alert(data);
      fetch_data();
      $('#image_form')[0].reset();
      $('#imageModal').modal('hide');
     }
    });
   }
  }
 });
 $(document).on('click', '.update', function(){
  $('#image_id').val($(this).attr("id"));
  $('#action').val("update");
  $('.modal-title').text("Update Image");
  $('#insert').val("Update");
  $('#imageModal').modal("show");
 });
 $(document).on('click', '.delete', function(){
  var image_id = $(this).attr("id");
  var action = "delete";
  if(confirm("Are you sure you want to remove this image from database?"))
  {
   $.ajax({
    url:"action.php",
    method:"POST",
    data:{image_id:image_id, action:action},
    success:function(data)
    {
     alert(data);
     fetch_data();
    }
   })
  }
  else
  {
   return false;
  }
 });
});  
</script>
