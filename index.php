<?php
error_reporting(0);
// This is the composer autoloader. Used by
// the markdown parser and RSS feed builder.
require 'vendor/autoload.php';

// Explicitly including the dispatch framework,
// and our functions.php file
require 'app/includes/dispatch.php';
require 'app/includes/functions.php';

// Load the configuration file
config('source', 'app/config.ini');

// The front page of the blog.
// This will match the root url
get('/index', function () {

	$page = from($_GET, 'page');
	$page = $page ? (int)$page : 1;
	
	$posts = get_posts($page);
	$tags = get_tags();
	$category = get_category();
	$likes = get_likes();
	if(empty($posts) || $page < 1){
		// a non-existing page
		no_posts();
	} 
	foreach($posts as $p){
		$total = $p->count;	
	}

    render('main',array(
    	'page' => $page,
    	'total' => $posts['count'],
		'posts' => $posts,
		'tags' =>$tags,
		'category'=> $category,
		'likes' => $likes,
		'has_pagination' => has_pagination($page, $total)
	));
});

get('/login', function () {
	
    render('login',array(), 'login_layout');
});

get('/bb-admin', function () {
	
    render('admin',array(
				'settings'=>get_config()    
    ), 'admin_layout');
});

get('/bb-admin/posts', function () {
	
    render('admin_posts',array(
				'settings'=>get_config()    
    ), 'admin_layout');
});

get('/bb-admin/categories', function () {
	
    render('admin_categories',array(
				'settings'=>get_config()    
    ), 'admin_layout');
});

get('/author/:name', function ($name) {
		$page = from($_GET, 'page');
	$page = $page ? (int)$page : 1;
	$author = get_author_posts($name);
	$tags = get_tags();
	$category = get_category();
	$likes = get_likes();
	
    render('author',array(
    			'page'=>$page,
				'author'=>$author,
				'tags' =>$tags,
				'category'=> $category,
				'likes' => $likes,
				'has_pagination' => has_pagination($page)
    ));
});

get('/profile/:name', function ($name) {
	$page = from($_GET, 'page');
	$page = $page ? (int)$page : 1;
	$author = get_author_posts($name);
	$tags = get_tags();
	$category = get_category();
	$likes = get_likes();
	$count = count($author);
	$exists = $author[0]['exists'];
	//print_r($author);
	if($exists != '1'){
	// a non-existing page
		no_author();
	}
	
	$total = $author['count'];
	foreach($author as $p){
		$total = $p->count;	
	}
    render('profile',array(
    			'exists'=> $exists,
    			'page' => $page,
    			'posts' => $posts,
    			'total' => $author['count'],
    			'author'=> $author,
    			'name'=>$name,
				'tags' =>$tags,
				'category'=> $category,
				'likes' => $likes,
				'has_pagination' => has_pagination($page, $total)
    			));
});

get('/cat/:name', function ($name) {
		$page = from($_GET, 'page');
	$page = $page ? (int)$page : 1;
	$categoryposts = get_posts_category($name);
	$tags = get_tags();
	$category = get_category();
	$likes = get_likes();
	foreach($categoryposts as $p){
		$total = $p->count;	
	}
    render('category',array(
    			'page'=>$page,
				'author'=>$categoryposts,
				'tags' =>$tags,
				'category'=> $category,
				'likes' => $likes,
				'has_pagination' => has_pagination($page, $total)
    ));
});

get('/post/:title',function($title){
	$post = find_post($title);
	if(!$post){
		not_found();
	}
foreach($post as $ps){
		$id=$ps['id'];	
}

	$tags = get_tags();
	$comments = get_comments($id);
	$category = get_category();
	$likes = get_likes();
	render('post',array(
		'title' => $post->title .' ⋅ ' . config('blog.title'),
		'p' => $post,
		'tags' =>$tags,
		'comments' => $comments,
		'category'=> $category,
		'likes' => $likes
	));
});
// The JSON API
get('/api/json',function(){

	header('Content-type: application/json');

	// Print the 10 latest posts as JSON
	echo generate_json(get_posts(1, 10));
});

// Show the RSS feed
get('/rss',function(){

	header('Content-Type: application/rss+xml');

	// Show an RSS feed with the 30 latest posts
	echo generate_rss(get_posts(1, 30));
});


// If we get here, it means that
// nothing has been matched above

get('.*',function(){
	not_found();
});

// Serve the blog
dispatch();
