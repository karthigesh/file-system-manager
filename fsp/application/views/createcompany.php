<div class="panel">
	<div class="panel-heading">
	  <h4 class="panel-title">Create Company</h4>
	</div>
		<div class="panel-body">
	<form id="createcompanyform" method="POST" action="<?php echo BASE_URL;?>admin/newcompany/">
	<div class="form-group">
		<input type="text" name="name" id="name" placeholder="Username" class="form-control" value="" required>
	</div>
	<div class="form-group">
		<input type="text" name="fname" placeholder="First Name" class="form-control" value="" required>
	</div>
	<div class="form-group">
		<input type="text" name="lname" placeholder="Last Name" class="form-control" value="" required>
	</div>
	<div class="form-group">
		<input type="password" name="password" placeholder="Password" class="form-control" value="" required>
	</div>
	<div class="form-group">
		<input type="text" name="email" id="email_id" placeholder="Email" class="form-control" value="" required>
	</div>
	<div class="form-group">
		<input type="text" name="phone" maxlength="12" id="phone" placeholder="Phone" onkeypress="validatephone(event)" class="form-control" value="" required>
	</div>
	<div class="form-group">
		<input class="btn btn-success" type="submit" name="company_submit" value="create company">
	</div>
	</form>
</div>
</div>
<script language="javascript">
	function validatephone(evt) {
			var theEvent = evt || window.event;
			var key = theEvent.keyCode || theEvent.which;
			key = String.fromCharCode( key );
			var regex = /[0-9]|\./;
			if( !regex.test(key) ) {
				theEvent.returnValue = false;
				if(theEvent.preventDefault) theEvent.preventDefault();
			}
		}
       $(document).ready(function(){
		   'use strict';
		   var form = $('#createcompanyform');
		   var error = $('.emailerror', form);
		   var success = $('.alert-success', form);	
		   var siteurl = '<?php echo BASE_URL;?>';
             $("#createcompanyform").validate({
				 doNotHideMessage: true, 
				 errorElement: 'div', 
                errorClass: 'emailerror', 
                 rules: {
					 name:{
						 required: true,
						 remote:
						 {
							 url:siteurl+'company/userverify',
							 type:"POST",
							 data:
							 {
								 name: function()
								 {
									 return $('#name').val();
								 }
							 }
						 },
					 },                  
                      email: {
                         required: true,
                         email: true,
                         remote:
							{
							  url: siteurl+'company/emailverify',
							  type: "post",
							  data:
							  {
								  email: function()
								  {
									  return $('#email_id').val();
									  console.log($('#email_id').val());
								  }
							  },
							},
                      },
                     phone: {
						 required: true,
					 },
                  },
                  messages: { 
					email:{
					 remote: function(data) { 	
						 return $.validator.format("<div class='alert alert-danger'>{0} is already taken</div>", $("#email_id").val()); 
						 }
					},
					name:{
						remote: function(data){
							return $.validator.format("<div class='alert alert-danger'>{0} is already taken</div>", $("#name").val());
						}
					},
                },    
             errorPlacement: function(error, element) {
					element.after(error);
			},
			invalidHandler: function (event, validator) {  
					error.show();
                },
            submitHandler: function (form) {
					error.remove();
					$('.emailerror', form).remove(); 
					console.clear();
					form.submit();
                },
        });
});

</script>
