<?php
foreach($author as $p){
	$cat = $p->cat;
}
?>
<ol class="breadcrumb well">
  <li><a href="<?php echo site_url();?>">Home</a></li>
  <li class="active">Category</li>
  <li class="active"><?php echo $cat; ?></li>
</ol>
<?php
if(empty($author)){
 ?>
    <div class="alert alert-info">
        <strong>Note!</strong> This catergory does not have any posts yet.
    </div>
<?php
} else {
foreach($author as $p){
$title = seoUrl($p->title);
?>
<div class="panel panel-default blog-container">
									<div class="panel-body">
						<h4 class="headline m-top-md">
							<a href="<?php echo site_url().'post/'.$title; ?>"><?php echo $p->title; ?></a>
							<span class="line"></span>
						</h4><br />
										<small class="text-muted"> <a href="<?php echo site_url().'profile/'.$p->author;?>" class="btn btn-default btn-xs"><strong> <?php echo $p->author; ?></strong></a> |  <span style="pointer-events: none;" class="btn btn-default btn-xs"><?php echo date('Y-m-d H:i:s', $p->date); ?></span>  | <a href="<?php echo site_url().'post/'.$title; ?>#disqus_thread" class="btn btn-default btn-xs"></a> | <a href="#" data-id="<?php echo $p->id;?>" data-toggle="tooltip" title="Like this post" class="btn btn-default btn-xs likes">
											<i class="fa fa-thumbs-o-up"></i>&nbsp;<span class="likes_value"><?php echo $p->likes; ?></span></a>
										</small>
										<p class="m-top-sm m-bottom-sm">
											<?php echo summary($p->body); ?>
										</p>
										<a href="<?php echo site_url().'post/'.$title; ?>"><i class="fa fa-angle-double-right"></i> Continue reading</a>
									</div>
								</div>
	<hr />
<?php } ?>
<?php if ($has_pagination['prev']):?>
	<a href="?page=<?php echo $page-1?>" class="pagination pagination-arrow newer">Newer</a>
<?php endif;?>

<?php if ($has_pagination['next']):?>
	<a href="?page=<?php echo $page+1?>" class="pagination-arrow older">Older</a>
<?php endif;?>

<?php
} ?>