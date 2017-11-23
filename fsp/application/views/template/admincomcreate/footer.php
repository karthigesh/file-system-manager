</div><!-- mainpanel -->
</section>
<?php if(isset($files)){
	echo include_files($files, 'footer');
}
?>
<script language="javascript">
       $(document).ready(function(){
		   'use strict';
	  $('#wysiwyg').wysihtml5({
		toolbar: {
		  fa: true
		}
	  });
	  $('#aboutus').summernote({
		height: 300
	  });
	  $('#wysiwyg1').wysihtml5({
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
