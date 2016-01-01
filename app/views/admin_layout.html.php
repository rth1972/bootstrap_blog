<?php
session_start();

if(!isset($_SESSION['myusername'])){
	header( 'Location: '.site_url().'login' ) ;
	exit;
} 

if(isset($_SESSION['myusername'])){
	$username = $_SESSION['myusername'];
} else {
		$username = 'Guest';
}
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo isset($title) ? _h($title) : config('blog.title') ?></title>

	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" user-scalable="no" />
	<meta name="description" content="<?php echo config('blog.description')?>" />

	<link rel="alternate" type="application/rss+xml" title="<?php echo config('blog.title')?>  Feed" href="<?php echo site_url()?>rss" />

	<link href="<?php echo site_url() ?>assets/css/style.css" rel="stylesheet" />
	<link href="http://fonts.googleapis.com/css?family=Open+Sans+Condensed:700&subset=latin,cyrillic-ext" rel="stylesheet" />
<link href="<?php echo site_url() ?>bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo site_url() ?>css/bootstrap-tokenfield.css" rel="stylesheet">

  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
 	<script src="<?php echo site_url() ?>bootstrap/js/bootstrap.min.js"></script>
 	<script src="<?php echo site_url() ?>js/metisMenu.min.js"></script>
 	<script src="<?php echo site_url() ?>js/jquery.bootstrap-growl.min.js"></script>
  <script src="<?php echo site_url() ?>js/bootstrap-tokenfield.js"></script>
 	
	<!--[if lt IE 9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	
	<script type="text/javascript">
  $(function(){
  	$('#side-menu').metisMenu();
  	
  	$('.logout_button').on('click', function(e){
				$.ajax({
					url:'logout.php',
					cache:false,
					success: function(data){
						if(data == '1'){
							window.location.href='<?php echo site_url();?>';						
						}
					}	
			});
			e.preventDefault();
			})
  });  	
  	</script>
  	
	<style>

	</style>
</head>
<body>

<div class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo site_url() ?>"><?php echo config('blog.title') ?></a>&nbsp;&nbsp;<div id="site-description"><?php echo config('blog.description'); ?></div>
          </div>
          <div class="navbar-collapse collapse">
            <!--<ul class="nav navbar-nav">
              <li class="active"><a href="#">Link</a></li>
              <li><a href="#">Link</a></li>
              <li><a href="#">Link</a></li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="#">Action</a></li>
                  <li><a href="#">Another action</a></li>
                  <li><a href="#">Something else here</a></li>
                  <li class="divider"></li>
                  <li class="dropdown-header">Nav header</li>
                  <li><a href="#">Separated link</a></li>
                  <li><a href="#">One more separated link</a></li>
                </ul>
              </li>
            </ul>-->
          <ul class="nav navbar-nav navbar-right">
                                    <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $username;?>&nbsp;&nbsp;<span class="caret"></span></a>
                <?php if(isset($_SESSION['myusername'])) { ?>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="#" class="logout_button">Logout</a></li>
                </ul>
                <?php
                } else {
                	echo '<ul class="dropdown-menu" role="menu"><li><a href="'.site_url().'login">Login</a></li></ul>';
                }
                ?>
              </li>
                                </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </div>
<div class="container">
<div class="col-md-4">
<div class="panel panel-default">
    <div class="panel-heading"><i class="fa fa-cog"></i> Menu</div>
      <div class="panel-body">
      					<div class="sidebar"role="navigation">
                <div class="sidebar-nav">
                    <ul class="nav" id="side-menu">
                        <!--<li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                            </div>
                            
                        </li>-->
                        <li>
                            <a class="active" href="<?php echo site_url(); ?>bb-admin"><i class="fa fa-dashboard fa-fw"></i> General Settings</a>
                        </li>
                        <li>
                            <a href="<?php echo site_url(); ?>bb-admin/posts"><i class="fa fa-bar-chart-o fa-fw"></i> Posts</a>
                        </li>
                        <li>
                            <a href="<?php echo site_url(); ?>bb-admin/categories"><i class="fa fa-bar-chart-o fa-fw"></i> Categories</a>
                        </li>
                        <li>
                            <a href="tables.html"><i class="fa fa-users fa-fw"></i> Users</a>
                        </li>
                        <!--<li>
                            <a href="forms.html"><i class="fa fa-edit fa-fw"></i> Forms</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-wrench fa-fw"></i> UI Elements<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="panels-wells.html">Panels and Wells</a>
                                </li>
                                <li>
                                    <a href="buttons.html">Buttons</a>
                                </li>
                                <li>
                                    <a href="notifications.html">Notifications</a>
                                </li>
                                <li>
                                    <a href="typography.html">Typography</a>
                                </li>
                                <li>
                                    <a href="grid.html">Grid</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-sitemap fa-fw"></i> Multi-Level Dropdown<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="#">Second Level Item</a>
                                </li>
                                <li>
                                    <a href="#">Second Level Item</a>
                                </li>
                                <li>
                                    <a href="#">Third Level <span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level">
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>-->
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
</div>
</div>
</div>
	<div class="col-md-8">
<?php 
if(!isset($_SESSION['is_admin'])){
?>
    <div class="alert alert alert-danger" role="alert">
        <strong>Error!</strong> You have to be site admin to see this page.
    </div>
    <a href="<?php echo site_url();?>" class="btn btn-sm btn-default">Go Back</a>
<?php

} else {
?>

		<?php echo content()?>
<?php } ?>
	</div>
	</div>
	
</body>
</html>
