<ol class="breadcrumb well">
  <li class="active">Home</li>
</ol>

<div class="panel panel-default blog-container">
									<div class="panel-body">
						<h4 class="headline m-top-md">
							<a href="<?php echo site_url().$title; ?>">This Blog doesn't have any posts yet.</a>
							<span class="line"></span>
						</h4>									
									</div>
								</div>
	<hr />
<?php if ($has_pagination['prev']):?>
	<a href="?page=<?php echo $page-1?>" class="pagination pagination-arrow newer">Newer</a>
<?php endif;?>

<?php if ($has_pagination['next']):?>
	<a href="?page=<?php echo $page+1?>" class="pagination-arrow older">Older</a>
<?php endif;?>