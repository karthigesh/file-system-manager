</div><!-- mainpanel -->
</section>
<?php if(isset($files)){
	echo include_files($files, 'footer');
}
?>
<script language="javascript">
       $(document).ready(function(){
		   'use strict';
		   var form = $('#comcreateuser');
		   var error = $('.emailerror', form);
		   var success = $('.alert-success', form);	
		   var siteurl = '<?php echo BASE_URL;?>';
             $("#compcreateuser").validate({
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
                     password: {
						 minlength : 5,
                         required: true,
                        },
                     phone: {
						 maxlength :12,
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
        $(".companyadmin-status").click(function(){
				 var userid = $(this).attr('data-id');
				 var status = $(this).find('.active').html();
				$('#compuserstatus_'+userid).val(status);
				$("#compuserstatuschange_"+userid).submit();
             });
	  $('#wysiwyg').wysihtml5({
		toolbar: {
		  fa: true
		}
	  });
	  $('#summernote').summernote({
		height: 200
	  });
});

</script>
</body>
</html>
