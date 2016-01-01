<div class="col-md-12">
<div class="row">
<div class="panel panel-default">
    <div class="panel-heading"><i class="fa fa-cog"></i> Categories</div>
      <div class="panel-body">
      		    <div class="col-lg-12">
      		    <div class="alert alert-info">
      		    <ul style="padding:10px;">
      		    	<li>to add a category just type the name of the category followed by a comma, and the category will be added.</li>
      		    	<li>to delete a category just click on the 'x' next to the category name.</li>
      		    	</ul>
      		    </div>
      		    <h5>Categories:</h5>
      <input type="text" class="form-control" id="my_input">
  </div><!-- /.col-lg-6 -->
</div>
</div>

</div>
    </div>
    <script type="text/javascript">
		$(document).ready(function(){
			$.ajax({
				url:'../get_cat.php',
				cache:false,
				dataType:'json',
				success:function(data){
						$.each(data, function( index, value ) {
$('#my_input').tokenfield('createToken', { value: value.id, label: value.name });
});
				}
			});

			$('#my_input').on('tokenfield:createtoken', function (e) {
    var data = e.attrs.value.split('|')
    e.attrs.value = data[1] || data[0];
    //alert(data[0]);
          $.ajax({
      url:'../save_category.php',
      cache:false,
      data:'id='+e.attrs.value,
      success: function(data1){
          if(data1 == '1'){
            alert('category successfully added.');
          }
      }
    })

  }).on('tokenfield:removedtoken', function (e) {
    //alert('Token removed! Token value was: ' + e.attrs.value)
    $.ajax({
      url:'../delete_category.php',
      cache:false,
      data:'id='+e.attrs.value,
      success: function(data1){
          if(data1 == '1'){
            alert('category successfully deleted.');
          } else if(data1 == '0'){
            $('#my_input').val('');
            $.ajax({
        url:'../get_cat.php',
        cache:false,
        dataType:'json',
        success:function(data){
            $.each(data, function( index, value ) {
$('#my_input').tokenfield('createToken', { value: value.id, label: value.name });
});
        }
      });
            alert('Still some posts in this category. Move the posts to another category first');
          }
      }
    })
  }).tokenfield();
		})    
    </script>