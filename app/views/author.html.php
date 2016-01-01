<?php 
foreach($author as $p){

$title = seoUrl($p->title);

?>
<div class="panel panel-default blog-container">
									<div class="panel-body">
						<h2 class="headline m-top-md">
							<a href="<?php echo site_url().'post/'.$title; ?>"><?php echo $p->title; ?></a>
							<span class="line"></span>
						</h2>
						<br />
										<small class="text-muted">By <a href="<?php echo site_url().'author/'.$p->author;?>"><strong> <?php echo $p->author; ?></strong></a> |  Post on <?php echo $p->date; ?>  | <?php echo $p->comments;?> comments | <span class="post-like text-muted tooltip-test" rel="tooltip" data-toggle="tooltip" data-original-title="I like this post!">
											<i class="fa fa-thumbs-o-up"></i> <span class="like-count"><?php echo $p->likes; ?></span>
										</span></small>
										<p class="m-top-sm m-bottom-sm">
											<?php echo $p->body; ?>
										</p>
										<a href="<?php echo site_url().'post/'.$title; ?>"><i class="fa fa-angle-double-right"></i> Continue reading</a>
									</div>
								</div>
	<hr />
<?php }?>

<?php if ($has_pagination['prev']):?>
	<a href="?page=<?php echo $page-1?>" class="pagination pagination-arrow newer">Newer</a>
<?php endif;?>

<?php if ($has_pagination['next']):?>
	<a href="?page=<?php echo $page+1?>" class="pagination-arrow older">Older</a>
<?php endif;?>
