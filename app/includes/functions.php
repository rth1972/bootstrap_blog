<?php
use \Suin\RSSWriter\Feed;
use \Suin\RSSWriter\Channel;
use \Suin\RSSWriter\Item;
config('source', 'app/config.ini');

$host = config('mysql.host');
$user = config('mysql.user');
$password = config('mysql.password');
$database = config('mysql.database');
$connection = mysql_connect("$host", "$user", "$password") or die ("<p class='error'>Sorry, we were unable to connect to the database server.</p>");
mysql_select_db($database, $connection) or die ("<p class='error'>Sorry, we were unable to connect to the database.</p>");

function get_post_names(){

	static $_cache = array();
$temp = array();
	if(empty($_cache)){

		// Get the names of all the
		// posts (newest first):
$query = mysql_query("SELECT * FROM blog_posts ORDER BY date_posted DESC");
while ($row = mysql_fetch_assoc($query))
    {
        $temp[] = array('id'=>$row["id"], 'title'=>$row['title'], 'post'=>$row['posts'], 'postfull'=>$row['postfull'], 'author_id'=>$row["author_id"], 'date_posted'=>$row['date_posted'], 'url'=>$row['url']);
    }
		$_cache = $temp;
	}
	return $_cache;
}

function get_posts($page = 1, $perpage = 0){

	if($perpage == 0){
		$perpage = config('posts.perpage');
	}
	$query1 = mysql_query("SELECT * FROM blog_posts ORDER BY id DESC");
	$total = mysql_num_rows($query1);
	$limit = 'LIMIT ' .($page - 1) * $perpage .',' .$perpage; 
	$query = mysql_query("SELECT * FROM blog_posts ORDER BY id DESC $limit");
	$tmp = array();
	$postsArray = array();
    while ($row = mysql_fetch_array($query))
    { 
    	$comments = get_comments($row['id']);
    	$author = get_author($row['author_id']);
    	$likes = get_post_likes($row['id']);
    	
        $postsArray[] = array('total'=>$total, 'id'=>$row["id"], 'title'=>$row['title'], 'post'=>$row['posts'], 'postfull'=>$row['posts'], 'author_id'=>$row["author_id"], 'date_posted'=>$row['date_posted'], 'url'=>$row['url'], 'comments'=>$comments,'author'=>$author,'likes'=>$likes);
    }  
    
    //return $postsArray;
    foreach($postsArray as $v){

		$posts = new stdClass;
		//$post->date = strtotime($v['date_posted']);
		$date = $v['date_posted'];
		//$post->date = date('jS F Y h:i:s A (T)', $date);
		$posts->date = $date;
		$posts->id = $v['id'];
		// The post URL
		$posts->url = site_url().$v['url'].'/';
		// Get the contents and convert it to HTML
		//$content = $md->transformMarkdown(file_get_contents($v));
		//$content = $v['posts'];
		//echo $content
		
		// Extract the title and body
		$posts->title = $v['title'];
		$posts->tags = $v['tags'];
		$posts->count = $v['total'];
		$posts->body = $v['post'];
		$posts->total_comments = $v['comments']['total'];
		$posts->comments  = $v['comments']['comments'];
		$posts->author = $v['author'][0]['name'];
		$posts->author_id = $v['author'][0]['id'];
		$posts->likes = $v['likes'][0]['likes'];
		$tmp[] = $posts;
		
	}
	return $tmp;
}
function get_author($id){
	$query = mysql_query("SELECT * FROM members WHERE id='$id'");
	$tmp = array();
	$authorArray = array();
	while ($row = mysql_fetch_array($query))
    {
        $authorArray= array('id'=>$row["id"], 'name'=>$row['username']);
    }  
    $author = new stdClass;
    foreach($authorArray as $a){
		$author->id = $a['id'];
		$author->name = $a['name'];
		$tmp[]= $authorArray;
}
return $tmp;
}

function get_author_posts($name, $page = 1, $perpage = 0){
	$query1 = mysql_query("SELECT * FROM members WHERE username='$name'");
	$num_rows1 = mysql_num_rows($query1);
$row1 = mysql_fetch_array($query1);

$author_id = $row1['id'];
$profile_pic =$row1['profile_pic'];
$cover = $row1['cover_photo'];
	if(isset($_REQUEST['page'])){
$page = $_REQUEST['page'];
}
	if($perpage == 0){
		$perpage = config('posts.perpage');
	}
	
	$query1 = mysql_query("SELECT * FROM blog_posts WHERE author_id = '$author_id' order by id DESC");
	$total = mysql_num_rows($query1);
	$limit = 'LIMIT ' .($page - 1) * $perpage .',' .$perpage; 
	$query = mysql_query("SELECT * FROM blog_posts WHERE author_id = '$author_id' order by id DESC $limit");
	$tmp = array();
	$postss= array();
	$postsArray = array();
	$profilepic = array();
	$coverpic = array();
	if($num_rows1 > 0){
		$exists= true;
	} else {
		$exists= false;
	}

    while ($row = mysql_fetch_array($query))
    {
    	$comments = get_comments($row['id']);
    	$likes = get_post_likes($row['id']);
    	$author = get_author($row['author_id']);
    	$val = substr($row['posts'], 0, 50) . "...";
    	$postsArray[] = array('id'=>$row["id"], 'post'=>$row['posts'], 'title'=>$row['title'], 'tags'=>$row['tags'],'date_posted'=>$row['date_posted'],'comments'=>$comments, 'likes'=>$likes,'author'=>$author);
      //  $postsArray[] = array('id'=>$row["id"], 'title'=>$row['title'], 'post'=>$val, 'postfull'=>$row['posts'], 'author_id'=>$row["author_id"], 'date_posted'=>$row['date_posted'], 'url'=>$row['url'], 'comments'=>$comments,'author'=>$author,'likes'=>$likes);
    }  
    //return $postsArray;
    foreach($postsArray as $v){
		$posts = new stdClass;
		$date = $v['date_posted'];
		$posts->date = $date;
		$posts->id = $v['id'];
		$posts->title = $v['title'];
		$posts->tags = $v['tags'];
		$posts->body = $v['post'];
		$posts->comments = $v['comments']['total'];
		$posts->author_id = $v['author'][0]['id'];
		$posts->author = $v['author'][0]['name'];
		$posts->likes = $v['likes'][0]['likes'];
		$postss[] = $posts;
		
	}
	$tmp[] = array('exists'=>$exists,'profile_pic'=>$profile_pic, 'cover'=>$cover, 'name'=>$row1['username'], 'total'=>$total, 'posts'=>$postss);
	return $tmp;
}

function get_posts_category($category, $page=1, $perpage = 0){
$query1 = mysql_query("SELECT * FROM category WHERE name='$category'");
$row1 = mysql_fetch_array($query1);
$category_id = $row1['id'];
$category_name = $row1['name'];
	if($perpage == 0){
		$perpage = config('posts.perpage');
	}
	
	if(isset($_REQUEST['page'])){
$page = $_REQUEST['page'];
}
	$limit = 'LIMIT ' .($page - 1) * $perpage .',' .$perpage; 
	$query = mysql_query("SELECT * FROM blog_posts WHERE category='$category_id' order by id DESC $limit");
	$tmp = array();
	$postsArray = array();
    while ($row = mysql_fetch_array($query))
    {
    	$comments = get_comments($row['id']);
    	$likes = get_post_likes($row['id']);
    	$author = get_author($row['author_id']);
    	$val = substr($row['posts'], 0, 50) . "...";
    	$postsArray[] = array('id'=>$row["id"], 'category'=>$category_name, 'post'=>$row['posts'], 'title'=>$row['title'], 'tags'=>$row['tags'],'date_posted'=>$row['date_posted'],'comments'=>$comments, 'likes'=>$likes,'author'=>$author);
      //  $postsArray[] = array('id'=>$row["id"], 'title'=>$row['title'], 'post'=>$val, 'postfull'=>$row['posts'], 'author_id'=>$row["author_id"], 'date_posted'=>$row['date_posted'], 'url'=>$row['url'], 'comments'=>$comments,'author'=>$author,'likes'=>$likes);
    }  
    //return $postsArray;
    foreach($postsArray as $v){
		$posts = new stdClass;
		$date = $v['date_posted'];
		$posts->date = $date;
		$posts->id = $v['id'];
		$posts->title = $v['title'];
		$posts->tags = $v['tags'];
		$posts->body = $v['post'];
		$posts->comments = $v['comments']['total'];
		$posts->author_id = $v['author'][0]['id'];
		$posts->author = $v['author'][0]['name'];
		$posts->likes = $v['likes'][0]['likes'];
		$posts->cat = $v['category'];
		$tmp[] = $posts;
		
	}
	return $tmp;

}

function summary($str, $limit=100, $strip = false) {
    $str = ($strip == true)?strip_tags($str):$str;
    if (strlen ($str) > $limit) {
        $str = substr ($str, 0, $limit - 3);
        return (substr ($str, 0, strrpos ($str, ' ')).' ...<br /><br />');
    }
    return trim($str);
}
function seoUrl($string) {
    //Lower case everything
    $string = strtolower($string);
    //Make alphanumeric (removes all other characters)
    $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
    //Clean up multiple dashes or whitespaces
    $string = preg_replace("/[\s-]+/", " ", $string);
    //Convert whitespaces and underscore to dash
    $string = preg_replace("/[\s_]/", "-", $string);
    return $string;
}

function get_comments($id){
		$query = mysql_query("SELECT * FROM comments WHERE post_id='$id'");
	$tmp = array();
	$postsArray = array();
	$commentArray = array();
	$arr = array();
	$num_rows = mysql_num_rows($query);
    while ($row = mysql_fetch_array($query))
    {
    	$author_id = $row['name'];
    	$query1 = mysql_query("SELECT * FROM members WHERE id='$author_id'");
    	while($row1 = mysql_fetch_array($query1)){
    				$profile_pic = $row1['profile_pic'];
    				$username = $row1['username'];
    	}
        $postsArray[] = array('id'=>$row["id"], 'name'=>$username, 'profile_pic'=>$profile_pic, 'url'=>$row['url'], 'email'=>$row['email'], 'body'=>$row["body"], 'dt'=>$row['dt']);
    }  
  
    foreach($postsArray as $v){
    	$posts = new stdClass;
		//$post->date = strtotime($v['date_posted']);
		//$post->date = date('jS F Y h:i:s A (T)', $date);
		$posts->date = $v['dt'];
		$posts->id = $v['id'];
		$posts->url = $v['url'];
		$posts->name = $v['name'];
		$posts->profile_pic = $v['profile_pic'];
		$posts->url = $v['url'];
		$posts->body = $v['body'];
		$tmp[] = $posts;
		
	}
	$arr = array('total'=>$num_rows, 'comments'=> $tmp);
	return $arr;
}

function get_all_posts(){

$query = mysql_query("SELECT * FROM blog_posts ORDER BY id DESC LIMIT 0,5");
	$tmp = array();

	// Create a new instance of the markdown parser
	$postsArray = array();
    while ($row = mysql_fetch_assoc($query))
    {
        $postsArray[] = array('id'=>$row["id"], 'title'=>$row['title'], 'post'=>$row['posts'], 'postfull'=>$row['postfull'], 'author_id'=>$row["author_id"], 'date_posted'=>$row['date_posted'], 'url'=>$row['url']);
    }  
    foreach($postsArray as $v){

		$posts = new stdClass;
		//$post->date = strtotime($v['date_posted']);
		$date = $v['date_posted'];
		//$post->date = date('jS F Y h:i:s A (T)', $date);
		$posts->date = $date;
		$posts->id = $v['id'];
		// The post URL
		$posts->url = site_url().$v['url'].'/';

		// Get the contents and convert it to HTML
		//$content = $md->transformMarkdown(file_get_contents($v));
		//$content = $v['posts'];
		//echo $content
		
		// Extract the title and body
		$posts->title = $v['title'];

		$posts->body = $v['post'];
		$tmp[] = $posts;
		
	}
	return $tmp;	
}

function get_config(){
	$tmp = array();
	// Parse with sections
$ini_array = parse_ini_file("app/config.ini", true);
$tmp[]=$ini_array;
	return $tmp;
}

function get_tags(){
	$query = mysql_query("SELECT * FROM tags");
	$temp = array();
	$postsArray = array();
    while ($row = mysql_fetch_assoc($query))
    {
        $postsArray[] = array('id'=>$row["id"], 'name'=>$row['name']);
    }  
    
    foreach($postsArray as $t){
		$posts = new stdClass;
		$posts->id = $t['id'];
		$posts->name = $t['name'];

		$tmp[] = $posts;
	}
	return $tmp;
}

function get_post_likes($id){
$query = mysql_query("SELECT * FROM blog_posts WHERE id='$id'");
	$tmp = array();
	$authorArray = array();
	while ($row = mysql_fetch_array($query))
    {
        $authorArray= array('likes'=>$row["likes"]);
    }  
    $author = new stdClass;
    foreach($authorArray as $a){
		$author->likes = $a['likes'];
		$tmp[]= $authorArray;
}
return $tmp;
}

function get_likes(){
	$query = mysql_query("SELECT * FROM blog_posts ORDER BY likes DESC limit 0,4");
	$temp = array();
	$likeArray = array();
    while ($row = mysql_fetch_assoc($query))
    {
        $likeArray[] = array('id'=>$row["id"], 'title'=>$row['title'], 'likes'=>$row['likes']);
    }  
    
    foreach($likeArray as $t){
		$likes = new stdClass;
		$likes->id = $t['id'];
		$likes->title = $t['title'];
		$likes->likes = $t['likes'];
		
		$tmp[] = $likes;
	}
	return $tmp;
}

function get_category(){
	$query = mysql_query("SELECT * FROM category");
	$temp = array();
	$catsArray = array();
    while ($row = mysql_fetch_assoc($query))
    {
        $catsArray[] = array('id'=>$row["id"], 'name'=>$row['name']);
    }  
    
    foreach($catsArray as $t){
		$cats = new stdClass;
		$cats->id = $t['id'];
		$cats->name = $t['name'];

		$tmp[] = $cats;
	}
	return $tmp;
}
// Find post by year, month and name
function find_post($id){
	$id = mysql_real_escape_string($id);
	$id = str_replace('-', ' ', $id);
	$query = mysql_query("SELECT * FROM blog_posts WHERE title='$id'");
	$postArray = array();
    while ($row = mysql_fetch_array($query))
    {
    	$comments = get_comments($row['id']);
    	$author = get_author($row['author_id']);
    	$likes = get_post_likes($row['id']);
        $postArray[] = array('id'=>$row["id"], 'title'=>$row['title'], 'post'=>$row['posts'], 'postfull'=>$row['postfull'], 'author'=>$author, 'date_posted'=>$row['date_posted'], 'comments'=>$comments, 'likes'=>$likes);
    }  
  
foreach($postArray as $v){
		$date = $v['date_posted'];
		$post->date = $date;
		$post->id = $v['id'];
		$post->title = $v['title'];
		$post->body = $v['post'];
		$post->comments = $v['comments']['total'];
		$post->author = $v['author'][0]['name'];
		$post->author_id = $v['author'][0]['id'];
		$post->likes = $v['likes'][0]['likes'];
		return $post;
	}
	
	//return $false;
  //  return false;
}

// Helper function to determine whether
// to show the pagination buttons
function has_pagination($page = 1, $total){
	return array(
		'prev'=> $page > 1,
		'next'=> $total > $page*config('posts.perpage')
	);
}

// The not found error
function not_found(){
	error(404, render('404', null, false));
}

function no_author(){
	error(404, render('no_author', null, false));
}

function no_posts(){
	error(404, render('no_posts', null));
}

function author_no_posts(){
	error(404, render('no_posts', null));
}
// Turn an array of posts into an RSS feed
function generate_rss($posts){
	
	$feed = new Feed();
	$channel = new Channel();
	
	$channel
		->title(config('blog.title'))
		->description(config('blog.description'))
		->url(site_url())
		->appendTo($feed);

	foreach($posts as $p){
		
		$item = new Item();
		$item
			->title($p->title)
			->description($p->body)
			->url($p->url)
			->appendTo($channel);
	}
	
	echo $feed;
}

// Turn an array of posts into a JSON
function generate_json($posts){
	return json_encode($posts);
}
