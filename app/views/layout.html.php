<?php
session_start();

if(isset($_SESSION['myusername'])){
	$username = $_SESSION['myusername'];
} else {
		$username = 'Guest';
}
?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>

	<title><?php echo config('blog.title') ?></title>

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
            <a class="navbar-brand" href="<?php echo site_url();?>"><i class="site-bb" style="vertical-align:middle;font-size:24px;"></i>&nbsp;<?php echo config('blog.title'); ?></a> <span class="site-description"><?php echo config('blog.description');?></span>
          </div>
          <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $username;?>&nbsp;&nbsp;<span class="caret"></span></a>
                <?php if(isset($_SESSION['myusername'])) { ?>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="<?php echo site_url().'profile/'.$username; ?>" class=""><i class="site-user4"></i>&nbsp;Profile</a></li>
                      <?php if(isset($_SESSION['is_admin'])){ ?>
                  	<li><a href="<?php echo site_url();?>bb-admin"><i class="site-meter2"></i>&nbsp;Admin Dashboard</a></li>
                    <li><a href="#" class="logout_button"><i class="site-sign-out"></i>&nbsp;Logout</a></li>
                      <?php }?>
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
<div class="row">
<div class="col-md-9">
	<?php echo content(); ?>
	</div>
	<div class="col-md-3" style="border-left:1px solid #ccc;">
								<form>
									<div class="form-group">
										<div class="input-group">
											<input id="searchbox" type="text" class="form-control input-sm" placeholder="Search In Blog...">
											<span class="input-group-btn">
												<button class="btn btn-default btn-sm" type="button"><i class="fa fa-search"></i></button>
											</span>
										</div><!-- /input-group -->
									</div>
								</form>
									<div class="well text-center">
					<h5 class="headline">
						Don't want to miss updates? Please click the button below!
					</h5>
					<a href="<?php echo site_url();?>rss" class="btn btn-primary">Subscribe to my feed</a>
				</div>
								<h4 class="headline">
									POPULAR POST
									<span class="line"></span>
								</h4>
								<div class="media popular-post">
								<ul class="list-group">
								<?php
                foreach($likes as $l){
								$title1 = seoUrl($l->title);
								?>
  <li class="list-group-item get_pop" data-id="<?php echo site_url().'post/'.$title1; ?>"><i class="fa fa-circle" style="font-size:6px;vertical-align:middle;color:#ccc;"></i>&nbsp; <?php echo $l->title; ?><span class="pull-right" style="font-size:12px;vertical-align:middle;"><i class="fa fa-thumbs-o-up">&nbsp;<span class="pop_<?php echo $l->id;?>"><?php echo $l->likes; ?></span></i></span></li>

  <?php } ?>
</ul>
								<h4 class="headline">
									CATEGORIES
									<span class="line"></span>
								</h4>
								<div class="media popular-post">
								<ul class="list-group">
<?php
									foreach($category as $c){
										$cat = seoUrl($c->name);

								?>
									<li data-id="<?php echo site_url().'cat/'.$cat; ?>" class="list-group-item get_cat"><i class="fa fa-circle" style="font-size:6px;vertical-align:middle;color:#ccc;"></i>&nbsp; <?php echo $c->name; ?></li>
									<?php } ?>
</ul>
</div>
								<!--<h4 class="headline">
									TAG CLOUD
									<span class="line"></span>
								</h4>
								<div class="media popular-post">
								<?php
foreach($tags as $s){?>
									<a class="btn btn-primary" href="#"><?php echo $s->name; ?></a>
									<?php } ?>

								</div><br />-->
								<h4 class="headline">
									ABOUT THE BLOG
									<span class="line"></span>
								</h4>
								<div class="media popular-post">
								<p>
<?php echo config('blog.about');?>
								</p>
								</div>
							</div><!-- /.col -->
	</div>
</div>
</div>

<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo site_url() ?>js/jasny-bootstrap.min.js"></script>
<script src="<?php echo site_url() ?>js/holder.js"></script>
<script src="<?php echo site_url();?>js/bootstrap-typeahead.js"></script>
<script src="//oss.maxcdn.com/jquery.bootstrapvalidator/0.5.1/js/bootstrapValidator.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.2/js/bootstrap-select.js"></script>
<script src="<?php echo site_url() ?>js/summernote.min.js"></script>
<script type="text/javascript">
        /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
        var disqus_shortname = '<?php echo config("site.disqus_shortname"); ?>'; // required: replace example with your forum shortname

        /* * * DON'T EDIT BELOW THIS LINE * * */
        (function() {
            var s = document.createElement('script'); s.async = true;
        s.type = 'text/javascript';
        s.src = '//' + disqus_shortname + '.disqus.com/count.js';
        (document.getElementsByTagName('HEAD')[0] || document.getElementsByTagName('BODY')[0]).appendChild(s);
        })();
    </script>
    <noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
<script type="text/javascript">
	$(document).ready(function(){
		$('[data-toggle="tooltip"]').tooltip({
    'placement': 'top'
});
$('.btn').on('click', function(){
    $(this).blur();
})
$('.likes_button').on('click', function(e){
  var val = $(this).data('likes');
  var id = $(this).data('id');
  var newval = val + 1;
  $.ajax({
      url:'<?php echo site_url();?>save_likes.php',
      cache:false,
      data:'id='+id+'&likes='+newval,
      success:function(data){
          if(data == '1'){
             // $(this).data('likes', newval);
             // $('.likes_value').html(newval);
              //$(this).blur();
             // $('.pop_'+id).html(newval);
             window.location.reload();
          }
      }
  });
    e.preventDefault();
})
$('#deletePostModal').on('show', function() {
    var id = $(this).data('id'),
        removeBtn = $(this).find('.danger');
})

$('.confirm-delete').on('click', function(e) {
    var id = $(this).data('id');
    $('#deletePostModal').data('id', id).modal('show');
    e.preventDefault();
});
$('#btnYes').click(function() {
    // handle deletion here
    var id = $('#deletePostModal').data('id');
    $.ajax({
      url:'<?php echo site_url();?>delete_post.php',
      cache:false,
      data: 'id='+id,
      success: function(data){
        if(data == '1'){
        //$('.post_'+id).remove();
        //$('#deletePostModal').modal('hide');
        window.location.reload();
          }
      }
    })
});
    $('.selectpicker').selectpicker();

		$('#searchbox').typeahead({
    onSelect: function(item) {
    	var str = item.text;

    	str = str.replace(/\s/g, "-");
        //console.log(str);
        window.location.href = "<?php site_url();?>post/"+str;
    },
    ajax: {
        url: "<?php echo site_url();?>search.php",
        timeout: 500,
        displayField: "title",
        triggerLength: 1,
        method: "get",
        loadingClass: "loading-circle",
        preDispatch: function (query) {
            return {
                search: query
            }
        },
        preProcess: function (data) {
            return data;
        }
    }
});
$('.tt-query').css('background-color','#fff');

function validateEditor() {
        // Revalidate the content when its value is changed by Summernote
        $('#summernoteForm, #summerpostForm').bootstrapValidator('revalidateField', 'content');
    };

    $('#summerpostForm')
        .bootstrapValidator({
            excluded: [':disabled'],
            fields: {
                title: {
                    validators: {
                        notEmpty: {
                            message: 'The title is required and cannot be empty'
                        }
                    }
                },
                category: {
                    validators: {
                        notEmpty: {
                            message: 'Please select a category.'
                        }
                    }
                },
                content: {
                    validators: {
                        callback: {
                            message: 'Comment field is required and cannot be empty',
                            callback: function(value, validator) {
                                var code = $('[name="content"]').code();
                                // <p><br></p> is code generated by Summernote for empty content
                                return (code !== '' && code !== '<p><br></p>');
                            }
                        }
                    }
                }
            }
        }).on('success.form.bv', function(e) {
            // Prevent submit form
            e.preventDefault();
            var $form     = $(e.target);

            $('.content').each( function() {
              $(this).val($(this).code());
                  });

            var validator = $form.serialize();
            //$form.find('.alert').html('Thanks for signing up. Now you can sign in as ' + validator.getFieldElements('username').val()).show();
            $.ajax({
              url:'<?php echo site_url();?>save_post.php',
              cache:false,
              data: validator,
              method:'post',
              success: function(data){
                  if(data == '1'){
                    window.location.href='<?php echo site_url();?>';
                  }
              }
            });
        }).find('[name="content"]')
            .summernote({
                height: 200,
                onkeyup: function() {
                    validateEditor();
                },
                onpaste: function() {
                    validateEditor();
                },
                toolbar: [
      ['style', ['style']],
      ['style', ['bold', 'italic', 'underline', 'clear']],
      ['fontsize', ['fontsize']],
      ['color', ['color']],
      ['para', ['ul', 'ol', 'paragraph']],
      ['height', ['height']],
      ['table', ['table']],
      //['insert', ['link', 'picture', 'video']], // no insert buttons
      ['insert', ['link', 'picture', 'video']],
      ['view', ['fullscreen']],
      ['help', ['help']]
    ]
            });

$('#myModal').on('hidden.bs.modal', function () {
    $('.fileinput').fileinput('reset')
})

$('#myModal1').on('hidden.bs.modal', function () {
    $('.fileinput1').fileinput('reset')
})
		$('.save_cover').bind("click",function()
    {
        var imgVal = $('#upload').val();
        if(imgVal=='')
        {
            alert("empty input file");

        } else {
			var fd = new FormData();
    fd.append("upload", $('#upload')[0].files[0]);

    $.ajax({
       url: "<?php echo site_url();?>upload_cover.php",
       type: "POST",
       data: fd,
       processData: false,
       contentType: false,
       dataType: 'json',
       success: function(response) {
         $.each(response, function(k, v) {
         	var imageUrl = v['data'];
    			$('#cover-image').attr('src', "data:image/jpeg;base64," + imageUrl);
    			$('#myModal').modal('hide');
  });
       }
    });
 }
 return false;
		});

		$('.save_profile').bind("click",function()
    {
        var imgVal = $('#profileupload').val();
        if(imgVal=='')
        {
            alert("empty input file");

        } else {
			var fd = new FormData();
    fd.append("upload", $('#profileupload')[0].files[0]);

    $.ajax({
       url: "<?php echo site_url();?>upload_profile.php",
       type: "POST",
       data: fd,
       processData: false,
       contentType: false,
       dataType: 'json',
       success: function(response) {
         $.each(response, function(k, v) {
         	var imageUrl = v['data'];
    			$('.author-info-img').attr('src', "data:image/jpeg;base64," + imageUrl);
    			$('#myModal1').modal('hide');
  });
       }
    });
 }
 return false;
		});
		$(".list-group-item").hover(
  function () {
    $(this).addClass('active');
  },
  function () {
    $(this).removeClass('active');
  }
  );

  $(".get_pop").on('click', function(){
  		//alert($(this).attr('data-id'));
  		window.location.href = $(this).attr('data-id');
  })

  $(".get_cat").on('click', function(){
  		//alert($(this).attr('data-id'));
  		window.location.href = $(this).attr('data-id');
  })
		$('.logout_button').on('click', function(e){
				$.ajax({
					url:'<?php echo site_url();?>logout.php',
					cache:false,
					success: function(data){
						if(data == '1'){
							window.location.href='<?php echo site_url();?>';
						}
					}
			});
			e.preventDefault();
			})
	})
</script>
</body>
</html>
