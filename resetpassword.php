<?php
session_start();

if(isset($_SESSION['myusername'])){
	header( 'Location: http://blog.radiocarreen.com' ) ;
	exit;
}
require 'vendor/autoload.php';

// Explicitly including the dispatch framework,
// and our functions.php file
require 'app/includes/dispatch.php';
require 'app/includes/functions.php';
config('source', 'app/config.ini');
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
<link href="<?php echo site_url() ?>css/metro.css" rel="stylesheet">
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
  <link rel="stylesheet" href="css/bootstrapValidator.min.css"/>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
 	<script src="<?php echo site_url() ?>bootstrap/js/bootstrap.min.js"></script>
 	<script type="text/javascript" src="js/bootstrapValidator.js"></script>
 	
	<!--[if lt IE 9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	
	<script type="text/javascript">
  $(function(){
  	$('#resetpassword_form').bootstrapValidator({
			feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        }  	
  	}).on('success.form.bv', function(e) {
            // Prevent form submission
            e.preventDefault();
            // Get the form instance
            var $form = $(e.target);
            // Get the BootstrapValidator instance
            var bv = $form.data('bootstrapValidator');
           $.ajax({
				url:'confirmpassword.php',
				cache:false,
				data: "key=<?php echo $_REQUEST['key'];?>&password="+$('#firstpassword').val(),
				method:'POST',
				success: function(data){
					if(data =='1'){
					$('.text-success').show();
					$('.btn-submit').hide();
					$('.btn-goback').show();
					} else if(data== '0'){
						$('.text-error').html('<strong>Warning!</strong> Provided username is not in our system.');
					$('.text-error').show();
					} else {
						$('.text-error').html(data);
					$('.text-error').show();
					}
				}
  			})
        });
  });  	
  	</script>
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
<div class="container">

    <div class="row">
    <br /><br />
        <div class="col-sm-8 col-md-6 col-md-offset-3">
        <div class="panel panel-primary">
  <div class="panel-heading">Reset Password?</div>
  <div class="panel-body">
    <form id="resetpassword_form" role="form">
<div class="input-group">
  <span class="input-group-addon"><i class="fa fa-lock"></i></span>
  <input type="password" class="form-control" id="firstpassword" name="firstpassword" placeholder="New Password" required autofocus
		          data-bv-notempty="true"
		          data-bv-notempty-message="<strong>Warning!</strong> The password is required and cannot be empty"
                data-bv-identical="true"
                data-bv-identical-field="secondpassword"
                data-bv-identical-message="<strong>Warning!</strong> The password and its confirm are not the same" 
  />
</div><br />
<div class="input-group">
  <span class="input-group-addon"><i class="fa fa-lock"></i></span>
  <input type="password" class="form-control" name="secondpassword" placeholder="Confirm Password" required autofocus
					 data-bv-notempty="true"
                data-bv-notempty-message="<strong>Warning!</strong> The confirm password is required and cannot be empty"
                data-bv-identical="true"
                data-bv-identical-field="firstpassword"
                data-bv-identical-message="<strong>Warning!</strong> The password and its confirm are not the same"  
  />
</div>
<br />
<button class="btn btn-primary btn-block btn-submit" name="submit" type="submit">Submit</button>
<a href="http://blog.radiocarreen.com" style="display:none;" class="btn btn-primary btn-block btn-goback" type="button">Go Back</a>
</form>
  </div>
</div>
<br />
<div class="alert alert-danger text-error" style='display:none;'>
        <strong>Warning!</strong> Provided username is not in our system.
    </div>
    
    <div class="alert alert-success text-success" style='display:none;'>
        <strong>Success!</strong> Your password has been successfully changed.<br />Now you can try to login with your new password.
    </div>
        </div>
    </div>
</div>
	</div>
	</div>
	
</body>
</html>
