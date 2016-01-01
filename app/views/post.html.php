<?php 
session_start();

$title = seoUrl($p->title);
?>
<script type="text/javascript">
        /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
        var disqus_shortname = '<?php echo config("site.disqus_shortname"); ?>'; // required: replace example with your forum shortname

        /* * * DON'T EDIT BELOW THIS LINE * * */
        (function() {
            var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
            dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
            (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);

            var s = document.createElement('script'); s.async = true;
        s.type = 'text/javascript';
        s.src = '//' + disqus_shortname + '.disqus.com/count.js';
        (document.getElementsByTagName('HEAD')[0] || document.getElementsByTagName('BODY')[0]).appendChild(s);
        })();
    </script>
    <noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>    
<ol class="breadcrumb well">
  <li><a href="<?php echo site_url();?>">Home</a></li>
  <li class="active">Post</li>
  <li class="active"><?php echo $p->title; ?></li>
</ol>
<ul class="pager">
						<li class="previous"><a href="<?php echo site_url(); ?>">&larr; Back to posts</a></li>
					</ul>
<div class="panel panel-default blog-container">
									<div class="panel-body">
						<h4 class="headline m-top-md">
							<?php echo $p->title; ?><span class="pull-right">
      	   <a href="http://twitter.com/?status=<?php echo $p->title;?> / <?php echo site_url().'post/'.$title;?> @robintehofstee" title="Share on Twitter" target="_blank" data-toggle="tooltip" data-placement="top" class="btn btn-twitter btn-xs"><i class="fa fa-twitter"></i> Twitter</a> 
      	   <a href="http://www.facebook.com/sharer/sharer.php?u=<?php echo site_url().'post/'.$title;?>" title="Share on Facebook" target="_blank" data-toggle="tooltip" data-placement="top" class="btn btn-facebook btn-xs"><i class="fa fa-facebook"></i> Facebook</a> 
      	   <a href="https://plus.google.com/share?url=<?php echo site_url().'post/'.$title;?>" title="Share on Google+" target="_blank" data-toggle="tooltip" data-placement="top" class="btn btn-googleplus btn-xs"><i class="fa fa-google-plus"></i> Google+</a> 
      	   </span>	
							<span class="line"></span>
						</h4><br />
										<small class="text-muted"><a href="<?php echo site_url().'profile/'.$p->author;?>" class='btn btn-default btn-xs'><strong> <?php echo $p->author; ?></strong></a> |  <a style="pointer-events: none;" class="btn btn-default btn-xs"><?php echo date('Y-m-d H:i:s', $p->date); ?></a>  | <a href="<?php echo site_url().'post/'.$title; ?>#disqus_thread" class="btn btn-default btn-xs"></a> | <a href="#" data-id="<?php echo $p->id;?>" data-likes="<?php echo $p->likes;?>" data-toggle="tooltip" title="Like this post" class="btn btn-default btn-xs likes_button">
											<i class="fa fa-thumbs-o-up"></i>&nbsp;<span class="likes_value"><?php echo $p->likes; ?></span></a>
										</small>
										<p class="m-top-sm m-bottom-sm">
											<?php echo $p->body; ?>
										</p>								
									</div>
								</div>
					<div class="panel panel-default">

    
					<div class="panel-heading">Comments</div>
									<div class="panel-body">
<div id="disqus_thread"></div>
    
									</div>
								</div>
<?php

?>