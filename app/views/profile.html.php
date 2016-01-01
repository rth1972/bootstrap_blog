<?php
session_start();
$profile_pic =  $author[0]['profile_pic'];
$cover = $author[0]['cover'];
$name  = $author[0]['name'];
$total_posts = count($author[0]['posts']);
?>
<div class="col-md-12">
        <div class="row">
<div class="profile-display">
            <div class="profile-cover"><img id="cover-image" src="data:image/png;base64,<?php echo $cover;?>" style="height:100%; width:100%" />
        <?php if(isset($_SESSION['myusername'])){ 
        $loginname = $_SESSION['myusername'];
            if($loginname == $name){        
        ?>
        <button href="#" data-toggle="modal" data-target="#myModal" class="btn btn-xs btn-primary changepic pull-right" style="margin:10px;"><i class="fa fa-picture-o"></i>&nbsp;Change Cover</button> 
        <button href="#" data-toggle="modal" data-target="#myModal1" class="btn btn-xs btn-primary changepic pull-right" style="margin:10px;"><i class="fa fa-picture-o"></i>&nbsp;Change Profile Picture</button>           
        <?php } 
        } ?>
        </div> 
            <div class="well">
          <!-- <div class="author-info-img" >-->
            <img class="author-info-img" src="data:image/png;base64,<?php echo $profile_pic;?>" />
            <!--</div>-->
            <div class="author-meta">
              <h2 class="author-username">
              <?php echo $name;?>
              </h2>
            </div>
          </div>
        </div>        
      </div>
      <div class="row">
<div id="content" style="margin-top: 100px;">
<ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
<li class="active"><a href="#red" data-toggle="tab">Posts</a></li>
<?php if(isset($_SESSION['myusername'])){  
$loginname = $_SESSION['myusername'];
            if($loginname == $name){
  ?>
<li><a href="#newpost" data-toggle="tab">Create New Post</a></li>
<?php } }?>
</ul>
<div id="my-tab-content" class="tab-content">
<div class="tab-pane active" id="red" style="padding: 10px;">
<?php 
if($total_posts > 0){ 
  foreach($author[0]['posts'] as $p){
    $title = seoUrl($p->title);
   ?>
<div class="post_<?php echo $p->id;?>">
<div class="panel panel-default blog-container">
                  <div class="panel-body">
            <h4 class="headline m-top-md">
              <a href="<?php echo site_url().'post/'.$title; ?>"><?php echo $p->title;?></a>
              <?php if(isset($_SESSION['myusername'])){ 
        $loginname = $_SESSION['myusername'];
            if($loginname == $name){        
        ?>&nbsp;
<button data-id="<?php echo $p->id; ?>" data-toggle="tooltip" title="Edit Post" class="btn btn-default btn-sm pull-right"><i class="site-edit"></i></button>
<button data-id="<?php echo $p->id; ?>" data-toggle="tooltip" title="Delete Post" class="btn btn-default btn-sm pull-right confirm-delete" style="margin-right:3px;"><i class="site-trash-o"></i></button>
        <?php }} ?>
              <span class="line"></span>
            </h4><br />
            <small class="text-muted"><a href="<?php echo site_url().'profile/'.$p->author;?>" class='btn btn-default btn-xs'><strong> <?php echo $p->author; ?></strong></a> |  <span style="pointer-events: none;" class="btn btn-default btn-xs"><?php echo date('Y-m-d H:i:s', $p->date); ?></span>  | <a href="<?php echo site_url().'post/'.$title; ?>#disqus_thread" style="pointer-events: none;" class="btn btn-default btn-xs"></a> | <a href="#" data-id="<?php echo $p->id;?>" data-likes="<?php echo $p->likes;?>" data-toggle="tooltip" title="Like this post" style="pointer-events: none;" class="btn btn-default btn-xs likes_button">
                      <i class="fa fa-thumbs-o-up"></i>&nbsp;<span class="likes_value"><?php echo $p->likes; ?></span></a>
                    </small>
            <br /><br />
            <?php echo summary($p->body); ?>
                    <a href="<?php echo site_url().'post/'.$title; ?>"><i class="fa fa-angle-double-right"></i> Continue reading</a>
                  </div>
                </div>
  <hr />
  </div>
   <?php
  }
?>

<?php 
} else { ?>
<div class="panel panel-default blog-container">
                  <div class="panel-body">
            <h4 class="headline m-top-md">
              <a href="<?php echo site_url(); ?>">Author does not have any posts yet.</a>
              
              <span class="line"></span>
            </h4>
                  </div>
                </div>
<?php
}
?>
</div>

<?php if(isset($_SESSION['myusername'])){ 
        $loginname = $_SESSION['myusername'];
            if($loginname == $name){        
        ?>
<div class="tab-pane" id="newpost" style="padding: 10px;">
<form id="summerpostForm" method="post" class="form-horizontal" action="javascript:return;">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Post title</label>
                                        <div class="col-md-5">
                                            <input type="text" class="form-control" name="title" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                      <label class="col-md-3 control-label">Category</label>
                                      <div class="col-md-9">
                                      <select class="form-control selectpicker show-menu-arrow" name="category">
                                      <?php foreach($category as $c){
                                        echo "<option value='".$c->id."'>".$c->name."</option>";
                                      }
                                        ?>
                                      </select>
                                    </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Post content</label>
                                        <div class="col-md-9">
                                            <textarea class="form-control content" name="content" style="height: 400px;"></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-5 col-md-offset-3">
                                            <button class="btn btn-default save_post_button">Save Post</button>
                                        </div>
                                    </div>
                                </form>
</div>
<?php } } ?>
      </div>
      </div>
      </div>
      </div>

      <div id="deletePostModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="deletePostModalLabel" aria-hidden="true">
     <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
        <p>You are about to delete a post.</p>
        <p>Do you want to proceed?</p>
    </div>
    <div class="modal-footer">
      <a href="#" id="btnYes" class="btn danger">Yes</a>
      <a href="#" data-dismiss="modal" aria-hidden="true" class="btn secondary">No</a>
    </div>
</div>
</div></div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Change Profile Cover</h4>
      </div>
      <div class="modal-body">
        <div class="fileinput fileinput-new" data-provides="fileinput">
  <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
    <img data-src="holder.js/200x150" alt="...">
  </div>
  <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
  <div>
    <span class="btn btn-default btn-file"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span><input type="file"  class="fileinput" name="..." id="upload"></span>
    <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
  </div>
</div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary save_cover">Save changes</button>
      </div>
    </div>
  </div>
</div>

<!-- profile pic Modal -->
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Change Profile Picture</h4>
      </div>
      <div class="modal-body">
        <div class="fileinput fileinput-new" data-provides="fileinput">
  <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
    <img data-src="holder.js/200x150" alt="...">
  </div>
  <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
  <div>
    <span class="btn btn-default btn-file"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span><input type="file" class="fileinput1" name="..." id="profileupload"></span>
    <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
  </div>
</div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary save_profile">Save changes</button>
      </div>
    </div>
  </div>
</div>