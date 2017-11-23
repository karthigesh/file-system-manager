</div><!-- mainpanel -->
</section>
<?php if(isset($files)){
	echo include_files($files, 'footer');
}
?>
<script language="javascript">
       $(document).ready(function(){
             $(".admin-status").click(function(){
				 var userid = $(this).attr('data-id');
				 var status = $(this).find('.active').html();
				$('#adminstatus_'+userid).val(status);
				$("#adminstatuschange_"+userid).submit();
             });
        });

</script>
</body>
</html>
