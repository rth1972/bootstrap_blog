<?php
session_start();

if(isset($_SESSION['myusername'])){
	header( 'Location: http://blog.radiocarreen.com' ) ;
	exit;
}
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo isset($title) ? _h($title) : config('blog.title') ?></title>

	<meta charset="utf-8" />
	<meta name="description" content="Bootstrap Blog <img src='<?php echo site_url();?>images/bootstrapblog.png'>" />
	<meta name="author" content="Robin te Hofstee" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="<?php echo site_url();?>bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo site_url() ?>css/summernote.css" rel="stylesheet">
	<link href="<?php echo site_url() ?>css/summernote-bs3.css" rel="stylesheet">
	<link href="<?php echo site_url();?>font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo site_url();?>css/style.css" type="text/css" />
	<?php if(config('blog.theme') != '') { ?>
		<link href="<?php echo site_url() ?>bootstrap/css/<?php echo config('blog.theme');?>.css" rel="stylesheet">
		<?php } ?>
		<link rel="stylesheet" href="<?php echo site_url() ?>css/jasny-bootstrap.min.css">
		<link href="<?php echo site_url() ?>icomoon/style.css" rel="stylesheet">
		<link href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.2/css/bootstrap-select.css" rel="stylesheet">
		<!--[if gte IE 9]>
		<link rel="stylesheet" href="stylesheets/ie9.css" type="text/css" />
		<![endif]-->

		<!--[if gte IE 8]>
		<link rel="stylesheet" href="stylesheets/ie8.css" type="text/css" />
		<![endif]-->
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
		<link rel="icon" href="favicon.ico" type="image/x-icon">
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
 	<script src="<?php echo site_url() ?>bootstrap/js/bootstrap.min.js"></script>

	<!--[if lt IE 9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<script type="text/javascript">
  $(function(){
  	$('.form-signin').submit(function( event ) {
  		$('.text-error').hide();
  			$.ajax({
				url:'checklogin.php',
				cache:false,
				data: $('.form-signin').serialize(),
				method:'POST',
				success: function(data){
					if(data =='1'){
					window.location.replace("<?php echo site_url(); ?>");
					} else {
					$('.text-error').show();
					}
				}
  			})
  			event.preventDefault();
  		})
  });
  	</script>

	<style>
		.form-signin
{
    max-width: 330px;
    padding: 15px;
    margin: 0 auto;
}
.form-signin .form-signin-heading, .form-signin .checkbox
{
    margin-bottom: 10px;
}
.form-signin .checkbox
{
    font-weight: normal;
}
.form-signin .form-control
{
    position: relative;
    font-size: 16px;
    height: auto;
    padding: 10px;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}
.form-signin .form-control:focus
{
    z-index: 2;
}
.form-signin input[type="text"]
{
    margin-bottom: -1px;
    border-bottom-left-radius: 0;
    border-bottom-right-radius: 0;
}
.form-signin input[type="password"]
{
    margin-bottom: 10px;
    border-top-left-radius: 0;
    border-top-right-radius: 0;
}
.account-wall
{
    margin-top: 20px;
    padding: 40px 0px 20px 0px;
    -moz-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
    -webkit-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
    box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
}
.login-title
{
    font-size: 18px;
    font-weight: 400;
    display: block;
}
.profile-img
{
    width: 96px;
    height: 96px;
    margin: 0 auto 10px;
    display: block;
    -moz-border-radius: 50%;
    -webkit-border-radius: 50%;
    border-radius: 50%;
}
.need-help
{
    margin-top: 10px;
}
.new-account
{
    display: block;
    margin-top: 10px;
}
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
                                    <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Guest
                                        <b class="caret"></b></a>
                                        <ul class="dropdown-menu">
                              				<li><a href="<?php echo site_url();?>login">Login</a></li>
                                        </ul>
                                    </li>
                                </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </div>
<div class="container">

	<div class="col-md-8">

		<?php echo content()?>

	</div>
	</div>

</body>
</html>
