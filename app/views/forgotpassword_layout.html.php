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
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" user-scalable="no" />
	<meta name="description" content="<?php echo config('blog.description')?>" />

	<link rel="alternate" type="application/rss+xml" title="<?php echo config('blog.title')?>  Feed" href="<?php echo site_url()?>rss" />

	<link href="<?php echo site_url() ?>assets/css/style.css" rel="stylesheet" />
	<link href="http://fonts.googleapis.com/css?family=Open+Sans+Condensed:700&subset=latin,cyrillic-ext" rel="stylesheet" />
<link href="<?php echo site_url() ?>bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo site_url() ?>css/metro.css" rel="stylesheet">
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
 	<script src="<?php echo site_url() ?>bootstrap/js/bootstrap.min.js"></script>
 	
	<!--[if lt IE 9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	
	<script type="text/javascript">
  $(function(){
  	$('#forgotpassword_form').submit(function( event ) {
  		$('.text-error').hide();
  		$('.text-error').html('');
  		$('.text-success').hide();
  			$.ajax({
				url:'forgotpassword.php',
				cache:false,
				data: $('#forgotpassword_form').serialize(),
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
  			event.preventDefault();
  		})
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

		<?php echo content()?>

	</div>
	</div>
	
</body>
</html>
