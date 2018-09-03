<!DOCTYPE html>
<html lang="en">

<head>
    <title>Test</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    
  </head>

<body>

 <div class="container">
     
    <div class="table-responsive">
        <h1>Product details
        <button data-toggle='modal' data-target='#insert-item' class='btn btn-primary insert-item pull-right'>Add New Product</button></h1>
        <br><br>
        <table class="table table-bordered table-hover" id="product_table">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Created</th>
                <th>Action</th>
                
            </tr>
           
        </table>
    </div>

 </div>

<!-- create -->

 <div class="modal fade" id="insert-item"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h4 class="modal-title">Create Item</h4>
          </div>

          <div class="modal-body">
                <form id="userForm" action="products.php" method="post">
                        <div class="form-group"> <label>Product Name</label><br><input type='text' id="name" name="name" placeholder='Name' /></div>
                        <div class="form-group"> <label>Description</label><br><input type='text' name='description' placeholder='description' /></div>
                        <div class="form-group"> <label>Price</label><br><input type='text' name='price' placeholder='price' /></div>
                        <div class="form-group"> <label>Created</label><br><input type='date' name='created' placeholder='created' /></div>
                        <div><input type='submit' value='Submit' /></div>
                        </form>
    </div>
  </div>
  </div>
    
 </div>


<!-- edit -->
 <div class="modal fade" id="edit-item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
          <h4 class="modal-title" id="myModalLabel">Edit Item</h4>
        </div>


        <div class="modal-body">
            
                <form data-toggle="validator" action="products.php" method="put">
                    <input type="hidden" name="id" class="edit-id">

                    <div class="form-group">
                      <label class="control-label" for="title">Name:</label>
                      <input type="text" name="name" class="form-control" data-error="Please enter title." required />
                      <div class="help-block with-errors"></div>
                  </div>

                  <div class="form-group">
                      <label class="control-label" for="title">Description:</label>
                      <input name="description" class="form-control" data-error="Please enter description." required />
                      <div class="help-block with-errors"></div>
                  </div>

                  <div class="form-group">
                    <label class="control-label" for="title">Price:</label>
                    <input name="price" class="form-control" data-error="Please enter price." required />
                    <div class="help-block with-errors"></div>
                </div>

                <div class="form-group">
                    <label class="control-label" for="title">Created:</label>
                    <input type="date" name="created" class="form-control" data-error="Please enter date and time." required />
                    <div class="help-block with-errors"></div>
                </div>

                  <div class="form-group">
                      <button type="submit" class="btn btn-success crud-submit-edit">Submit</button>
                  </div>
                </form>
        </div>
      </div>
    </div>
  </div>

 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  <script id="source" language="javascript" type="text/javascript">

$(function(){
        console.log("data");
        $.ajax({
            type:"GET",
            url: 'http://localhost/rest/products',
            data: "",
            dataType: 'json',
            success: function(data){
              
                for (index = 0; index < data.length; index++) {
                    var id = data[index].id;
                    var name = data[index].name;
                    var description = data[index].description;
                    var price = data[index].price;
                    
                    var created = data[index].created;
                   // var d = new Date(created).toDateString();
                                                                                                        
                   $('#product_table').append("<tr><td id='prid'>"+(index+1)+"</td><td>"+name+"</td><td>"+description+"</td><td>"+price+"</td><td>"+created+"</td><td data-id='"+id+"'><button class='btn btn-danger remove-item'>delete</button><button data-toggle='modal' data-target='#edit-item' class='btn btn-primary edit-item'>Edit</button> </td></tr>");
                   
                }
            }
        });

//insert
$("body").on("click",".insert-item",function(){

    $("#userForm").submit(function(e){
    e.preventDefault();         //prevent default action 
    console.log('inside form');
    
    var post_url = $(this).attr("action"); //get form action url
    var request_method = $(this).attr("method"); //get form GET/POST method
    var formData = $("#userForm").serializeArray();

    console.log(formData);

    $.ajax({
        url:"http://localhost/rest/products",
        type:request_method,
        data: formData,
        success: function (response){
            alert("DATA POSTED SUCCESSFULLY");
            window.location = "read.php";
            console.log(response.status);
        },
        error: function(error){
            console.log('came to error');
        }
        
    });
   
});

});


//edit
$("body").on("click",".edit-item",function(){


var id = $(this).parent("td").data('id');
var name = $(this).parent("td").prev("td").prev("td").prev("td").prev("td").text();
var description = $(this).parent("td").prev("td").prev("td").prev("td").text();
var price = $(this).parent("td").prev("td").prev("td").text();
var created = $(this).parent("td").prev("td").text();

$("#edit-item").find("input[name='name']").val(name);
$("#edit-item").find("input[name='description']").val(description);
$("#edit-item").find("input[name='price']").val(price);
$("#edit-item").find("input[name='created']").val(created);
$("#edit-item").find(".edit-id").val(id);


});
//update
$(".crud-submit-edit").click(function(e){



var form_action = $("#edit-item").find("form").attr("action");
var name = $("#edit-item").find("input[name='name']").val();
var description = $("#edit-item").find("input[name='description']").val();
var price = $("#edit-item").find("input[name='price']").val();
var created = $("#edit-item").find("input[name='created']").val();
var id = $("#edit-item").find(".edit-id").val();


if(name != '' && description != '' && price != '' && created != ''){
    console.log('into if');
    $.ajax({
        dataType: 'json',
        type:'PUT',
        url:'http://localhost/rest/products/'+id+'/',
        data:{name:name, description:description, price:price, created:created},
        success: function(response){
            console.log('success');
            $(".modal").modal('hide');
            window.location = "read.php";

            
        },
        error: function (error){
            console.log('came to error'+id);
        }
    });
}else{
    alert('Please fill all the fields');
}
e.preventDefault();

});



//delete
$("body").on("click",".remove-item",function(){

    var id = $(this).parent("td").data('id');
    var c_obj = $(this).parents("tr");

 var confirmation = confirm("are you sure you want to remove the item?");

 if(confirmation){
    $.ajax({
        dataType: 'json',
        type:'DELETE',
        url: 'http://localhost/rest/products/'+id+'/',
        data:'',
        success: function(response){
            c_obj.remove();
            window.location = "read.php";
            console.log('came to success');
        },
        error:function(error){
            console.log('came to error'+id);
        }
    });
        }       
  });
});
  </script>
</body>

</html>