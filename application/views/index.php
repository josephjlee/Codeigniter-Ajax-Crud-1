<!DOCTYPE html>
<html>
<head>
	<title><?php echo $title; ?></title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" >
</head>
<style type="text/css">
	.form-control, .btn{
		border-radius: 0px;
	}
</style>

<body>
	<div class="container">
		<div class="row">
			<div class="col-md-4"></div>
			<div class="col-md-4">
				<h3 id="formTitle">Contact Form</h3>
				<div style="display: none" class="alert alert-success"></div>
					<form method="post" id="contactForm" action="" onsubmit="saveContact()">
						<input type="hidden" name="id" id="cId" value="">
						<input type="hidden" value="save" id="formStatus">
						<div class="form-group">
							<label class="control-label">Name :</label>
							<input id="cName" type="text"class="form-control" name="name" value="" placeholder="Enter Name" required>
						</div>
						<div class="form-group">
							<label class="control-label">Email :</label>
							<input id="cEmail" type="email"class="form-control" name="email" value="" placeholder="Enter Email" required>
						</div>
						<div class="form-group">
							<label class="control-label">Phone :</label>
							<input id="cPhone" type="number" class="form-control"name="phone" value="" placeholder="Enter Number" required>
						</div>
						<button type="submit" id="cBtn" class="btn btn-success">Save Contact</button>
					</form>				
			</div>
			<div class="col-md-4"></div>
		</div>
		<div class="row">
			<h3>Contact List</h3>
			<table class="table table-bordered">
			    <thead>
			      <tr>
			        <th>#</th>
			        <th>Name</th>
			        <th>Email</th>
			        <th>Phone</th>
			        <th>Action</th>
			      </tr>
			    </thead>
			    <tbody id="contactList">
<!-- 			      <tr>
			        <td>1</td>
			        <td>Ruhul Amin</td>
			        <td>ruhul11bd@gmail.com</td>
			        <td>01749-769449</td>
			        <td>
			        	<button class="btn btn-xs btn-warning" onclick="edit()"><i class="fa fa-edit"></i> Edit</button>
			        	<button class="btn btn-xs btn-danger" onclick="delete()"><i class="fa fa-trash"></i> Delete</button>
			        </td>
			      </tr> -->
			    </tbody>
			  </table>
		</div>
	</div>

		<script src="http://code.jquery.com/jquery-3.3.1.min.js" ></script>
	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script type="text/javascript">
	allContacts();



	function saveContact(){
		event.preventDefault();
		var data = $('#contactForm').serialize();
		var msg = '';
		if($("#formStatus").val() == 'update'){
			var url = "<?php echo base_url('home/updateContact') ?>";
			msg = "Seccessfully Updated";
		}else{
			var url = "<?php echo base_url('home/saveContact') ?>";
			msg = "Seccessfully Saved";
		}
		$.ajax({
			type:'ajax',
			method:'post',
			url:url,
			data:data,
			success:function(response){
				$('#contactForm')[0].reset();
				$('#cBtn').removeClass('btn-warning');
				$('#cBtn').addClass('btn-success');
				$('#formStatus').val('save');
				$('#cBtn').html('Save Contact');
				allContacts();
				$('.alert-success').html(msg).fadeIn().delay('3000').fadeOut('slow');
			},
			error:function(){
				alert('Jamela Ache');
			}
		});
	}

	function editContact(id){
		var url = "<?php echo base_url('home/editContact/') ?>"+id;
		$.ajax({
			type:'ajax',
			method:'post',
			url:url,
			dataType:'json',
			success:function(data){
				$('#formTitle').html('Edit Contact');
				$('#cBtn').removeClass('btn-success');
				$('#cBtn').addClass('btn-warning');
				$('#cBtn').html('Update Contact');

				$('#cName').val(data.name);
				$('#cEmail').val(data.email);
				$('#cPhone').val(data.phone);
				$('#cId').val(data.id);

				$('#formStatus').val('update');
				
			},
			error:function(){
				alert('Jamela Ache');
			}
		});
	}

	function deleteContact(id){
		var url = "<?php echo base_url('home/deleteContact/') ?>"+id;
		if(confirm('Are you sure about Delete??')){
			$.ajax({
				type:'ajax',
				method:'post',
				url:url,
				success:function(response){
					allContacts();
					$('.alert-success').html('Successfully Deleted').fadeIn().delay('3000').fadeOut('slow');
				},
				error:function(){
					alert('Jamela Ache');
				}
			});
		}
	}

	function allContacts(){
		$.ajax({
			type:'ajax',
			url:"<?php echo base_url(); ?>home/allContacts",
			dataType:'json',
			success:function(data){
				var html='';
				var i = '';
				var sl=0;
				for (i =0; data.length > i; i++) {
					sl++;
					html += '<tr>'+
				        '<td>'+sl+'</td>'+
				        '<td>'+data[i].name+'</td>'+
				        '<td>'+data[i].email+'</td>'+
				        '<td>'+data[i].phone+'</td>'+
				        '<td>'+
				        	'<button class="btn btn-xs btn-warning" onclick="editContact('+data[i].id+')"><i class="fa fa-edit"></i> Edit</button>'+
				        	' <button class="btn btn-xs btn-danger" onclick="deleteContact('+data[i].id+')"><i class="fa fa-trash"></i> Delete</button>'+
				        '</td>'+
				      '</tr>';
				}
				$('#contactList').html(html);
			},
			error:function(){
				alert('Error Getting Contact Data');
			}
		});
	}

</script>
</body>
</html>
