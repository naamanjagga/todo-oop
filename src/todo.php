 <?php

//session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>todo</title>
</head>
<body>
    <h2>TODO LIST</h2>
    <h3>Add Item</h3>
    <input type="text" id="input">
    <button type="submit" id="btn1" >Add</button>
    <button type="submit" id="btn2" >Update</button>
    <div> 
        <h3>Todo</h3>
        <div id="todo"></div>
    </div>
    <div> 
        <h3>Completed</h3>
        <div id="completed"></div>
    </div>
</body>
</html>
<script>
    var length;
    var js_array = [];
    var array_diff = [];
    $(document).ready( function() {
        $('#btn2').hide();
       $('#btn1').on('click' , function() {
          var todo = $('#input').val();
          if(todo == "") {
              alert('please enter some value');
          } else {
                 $.ajax({
                     url: 'post.php',
                     type: 'post',
                     datatype: 'json',
                     data: {
                         action: 'todo',
                         todo: todo
                     },
                     success:function(data){
                        js_array = JSON.parse(data);
                        length = js_array.length;
                         display(js_array);
                     }

                  })
          }
       })
    })
    var u_id;
    function Edit(id){
        $('#btn1').hide();
        $('#btn2').show();
        for (var i = 0; i < length; i++) {
             if(i == id){
                u_id = i
                $('#input').val(js_array[i]);
                  $('#btn2').on('click' ,function() {
                    $('#btn2').hide();
                    $('#btn1').show();
                      var u_value = $('#input').val();
                    $.ajax({
                     url: 'post.php',
                     type: 'post',
                     datatype: 'json',
                     data: {
                         action: 'edit',
                         u_value: u_value,
                         edit: u_id
                     },
                     success:function(data){
                         var js_array = JSON.parse(data);
                         display(js_array);
                   }
                  })
                })
             }
        }
    }
    function Delete(id){
        for (var i = 0; i < length; i++) {
             if(i == id){
                $.ajax({
                     url: 'post.php',
                     type: 'post',
                     datatype: 'json',
                     data: {
                         action: 'delete',
                         delete: i
                     },
                     success:function(data){
                        var js_array = JSON.parse(data);
                        display(js_array);
                   }
             })
        }
      }
    }
    function change(x) {
        for (var i = 0; i < length; i++) {
		    if (i == x) {
                var checkbox = document.getElementById('check' + [ i ]);
                if(checkbox.checked){
                    $.ajax({
                     url: 'post.php',
                     type: 'post',
                     datatype: 'json',
                     data: {
                         action: 'check',
                         complete: js_array[i],
                         check: i
                     },
                     success:function(data){
                         console.log(data);
                        var js_array1 = JSON.parse(data);
                        var html = '<ul>';
	                    for (var j = 0; j < js_array.length; j++) {
                            if(x == j){
                                js_array.splice(j,1);
                            
                                continue;
                            } else {
		                        html +=
			                        '<li><input type ="checkbox" id="check' +
			                        [ j ] +
			                        '" onchange="change(' +
			                        j +
			                         ')">' +
			                        js_array[j] +
			                        ' <button id="Edit" onclick="Edit(' +
			                        j +
			                        ')">Edit</button> <button id="Delete" onclick="Delete(' +
			                        j +
			                        ')">Delete</button><br> ';
	
	                            html += '</li></ul>';
	                            $('#todo').html(html);
                            }
                        }
                        var html = '<ul>';
	                       for (var i = 0; i < js_array1.length; i++) {
		                      html +=
			                       '<li><input type ="checkbox" id="check' +
			                        [ i ] +
			                        '" onchange="change(' +
			                         i +
			                         ')" checked>' +
			                         js_array1[i] +
			                          ' <button id="Edit" onclick="Edit(' +
			                         i +
			                         ')">Edit</button> <button id="Delete" onclick="Delete(' +
			                         i +
			                        ')">Delete</button><br> ';
	                                }
	                    html += '</li></ul>';
	                    $('#completed').html(html);
                        
                   }
                })
            } 
        }
      }
    }
     function display(todolist) {

        var html = '<ul>';
	       for (var i = 0; i < todolist.length; i++) {
		      html +=
			      '<li><input type ="checkbox" id="check' +
			      [ i ] +
			      '" onchange="change(' +
			       i +
			      ')">' +
			      todolist[i] +
			      ' <button id="Edit" onclick="Edit(' +
			       i +
			      ')">Edit</button> <button id="Delete" onclick="Delete(' +
			       i +
			      ')">Delete</button><br> ';
	            }
	      html += '</li></ul>';
	      $('#todo').html(html);

    }
</script> 