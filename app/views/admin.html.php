<div class="col-md-12">
<div class="row">
<div class="panel panel-default">
    <div class="panel-heading"><i class="fa fa-cog"></i> Settings</div>
      <div class="panel-body">
      <h3>Blog settings</h3>
      <hr />
     <form class="form-horizontal" id="settings-form">
     <?php
	foreach($settings as $p){
		?>
        <div class="form-group">
            <label for="site.url" class="control-label col-xs-3">Site Url</label>
            <div class="col-xs-9">
                <input type="text" class="form-control" id="site.url" name="url" value="<?php echo $p['site.url']; ?>" required>
            </div>
        </div>
        <div class="form-group">
            <label for="blog.title" class="control-label col-xs-3">Blog Title</label>
            <div class="col-xs-9">
                <input type="text" class="form-control" id="blog.title" name="title" value="<?php echo $p['blog.title']; ?>" required>
            </div>
        </div>
        <div class="form-group">
        <label for="blog.description" class="control-label col-xs-3">Blog Description</label>
            <div class="col-xs-9">
                 <input type="text" class="form-control" id="blog.description" name="description" value="<?php echo $p['blog.description']; ?>" required>
                </div>
            </div>
        <div class="form-group">
        <label for="blog.about" class="control-label col-xs-3">About Blog</label>
            <div class="col-xs-9">
                 <input type="text" class="form-control" id="blog.about" name="about" value="<?php echo $p['blog.about']; ?>" required>
                </div>
            </div>
            <div class="form-group">
        <label for="select_perpage" class="control-label col-xs-3">Posts Per Page</label>
            <div class="col-xs-9">
            <select class="select_perpage form-control" name="select_perpage">
            <option value="1">1</option>
  <option value="5">5</option>
  <option value="10">10</option>
  <option value="15">15</option>
  <option value="20">20</option>
</select> 
</div></div>
<div class="form-group">
        <label for="site.disqus_shortname" class="control-label col-xs-3">Disqus Shortname</label>
            <div class="col-xs-9">
                 <input type="text" class="form-control" id="site.disqus_shortname" name="disqus_shortname" value="<?php echo $p['site.disqus_shortname']; ?>" required>
                </div>
            </div>
<div class="form-group">
        <label for="select_theme" class="control-label col-xs-3">Theme</label>
            <div class="col-xs-9">
            <select class="select_theme form-control" name="select_theme">
            <option value="">Default</option>
   <option value="darkly">Darkly</option>
  <option value="slate">Slate</option>
  <option value="cerulean">cerulean</option>
  <option value="ios">Ios</option>
  <option value="metro">Metro</option>
</select> 
</div></div><br /><br />
		<h3>Mysql Settings</h3>
		<hr />
		<div class="form-group">
            <label for="mysql.host" class="control-label col-xs-3">Host</label>
            <div class="col-xs-9">
                <input type="text" class="form-control" id="mysql.host" name="host" value="<?php echo $p['mysql.host']; ?>" required>
            </div>
        </div>
        <div class="form-group">
            <label for="mysql.user" class="control-label col-xs-3">User</label>
            <div class="col-xs-9">
                <input type="text" class="form-control" id="mysql.user" name="user" value="<?php echo $p['mysql.user']; ?>" required>
            </div>
        </div>
        <div class="form-group">
        <label for="mysql.password" class="control-label col-xs-3">Password</label>
            <div class="col-xs-9">
                 <input type="text" class="form-control" id="mysql.password" name="password" value="<?php echo $p['mysql.password']; ?>" required>
                </div>
            </div>
            <div class="form-group">
        <label for="mysql.database" class="control-label col-xs-3">Database</label>
            <div class="col-xs-9">
                 <input type="text" class="form-control" id="mysql.database" name="database" value="<?php echo $p['mysql.database']; ?>" required>
                </div>
            </div>
        <?php
     }
     ?>
        <div class="form-group">
            <div class="col-xs-offset-2 col-xs-10">
                <button name="save" id="save" class="btn btn-primary">Save</button>
            </div>
        </div>
    </form>
</div>
</div>

</div>
    </div>
    <script type="text/javascript">
		$(document).ready(function(){
			$('[name=select_perpage] option').filter(function() { 
    return ($(this).text() == '<?php echo config("posts.perpage") ?>'); //To select Blue
}).prop('selected', true);

$('[name=select_theme] option').filter(function() { 
    return ($(this).val() == '<?php echo config("blog.theme") ?>'); //To select Blue
}).prop('selected', true);



				$('#save').on('click', function(){
					var data = $("#settings-form").serializeArray();
					post_var = {'data': data };
					$.ajax({
						url:'save_settings.php',
						cache: false,
						data: data,
						success:function(data){	
							$.bootstrapGrowl("Blog Settings are saved!", {
  ele: 'body', // which element to append to
  type: 'success', // (null, 'info', 'error', 'success')
  offset: {from: 'top', amount: 20}, // 'top', or 'bottom'
  align: 'right', // ('left', 'right', or 'center')
  width: 250, // (integer, or 'auto')
  delay: 4000,
  allow_dismiss: true,
  stackup_spacing: 10 // spacing between consecutively stacked growls.
});
					
						}					
					})
					return false;
				});
				
				$('#save_mysql').on('click', function(){
					var data = $("#mysql-form").serializeArray();
					post_var = {'data': data };
					$.ajax({
						url:'save_settings.php',
						cache: false,
						data: data,
						success:function(data){	
							$.bootstrapGrowl("Mysql Settings are saved!", {
  ele: 'body', // which element to append to
  type: 'success', // (null, 'info', 'error', 'success')
  offset: {from: 'top', amount: 20}, // 'top', or 'bottom'
  align: 'right', // ('left', 'right', or 'center')
  width: 250, // (integer, or 'auto')
  delay: 4000,
  allow_dismiss: true,
  stackup_spacing: 10 // spacing between consecutively stacked growls.
});
					
						}					
					})
					return false;
				});
		})    
    </script>