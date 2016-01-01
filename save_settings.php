<?php

$title = $_REQUEST['title'];
$url = $_REQUEST['url'];
$perpage = $_REQUEST['select_perpage'];
$description = $_REQUEST['description'];
$about = $_REQUEST['about'];
$theme = $_REQUEST['select_theme'];
$disqus = $_REQUEST['disqus_shortname'];
$file = 'app/config.ini';
$admin_file = 'app/config.ini';
$searchtitle = 'blog.title';
$searchurl = 'site.url';
$searchdescription = 'blog.description';
$searchabout = 'blog.about';
$searchperpage = "posts.perpage";
$searchtheme = "blog.theme";
$searchdisqus = "site.disqus_shortname";

$host = $_REQUEST['host'];
$user = $_REQUEST['user'];
$password = $_REQUEST['password'];
$database = $_REQUEST['database'];
$searchhost = 'mysql.host';
$searchuser = 'mysql.user';
$searchpassword = 'mysql.password';
$searchdatabase = "mysql.database";

function replaceInFile($what, $with, $file){
    $fp = file($file);
    foreach($fp as $line){
   		$buffer = preg_replace("/".$what."*/", $with, $line);
    }
    fclose($fp);
    echo $buffer;
    file_put_contents($file, $buffer);
}

function replace_in_file($FilePath, $OldText, $NewText)
{
    $Result = array('status' => 'error', 'message' => '');
    if(file_exists($FilePath)===TRUE)
    {
        if(is_writeable($FilePath))
        {
            try
            {
                $FileContent = file_get_contents($FilePath);
                $FileContent = str_replace($OldText, $NewText, $FileContent);
                if(file_put_contents($FilePath, $FileContent) > 0)
                {
                    $Result["status"] = 'success';    
                }
                else
                {
                   $Result["message"] = 'Error while writing file'; 
                }
            }
            catch(Exception $e)
            {
                $Result["message"] = 'Error : '.$e; 
            }
        }
        else
        {
            $Result["message"] = 'File '.$FilePath.' is not writable !';       
        }
    }
    else
    {
        $Result["message"] = 'File '.$FilePath.' does not exist !';
    }
    return $Result;
}
function get_part($file, $searchfor, $name, $start){
// get the file contents, assuming the file to be readable (and exist)
$contents = file_get_contents($file);
// escape special characters in the query
$pattern = preg_quote($searchfor, '/');
// finalise the regular expression, matching the whole line
$pattern = "/^.*$pattern.*\$/m";
// search, and store all matching occurences in $matches
if(preg_match_all($pattern, $contents, $matches)){
   $text =  implode("\n", $matches[0]);
   //echo $text;
   
replace_in_file($file, $text, $start.'="'.$name.'"');
   //replaceInFile($text, 'blog.title='+$name, $file);
}
else{
   echo "No matches found";
}
}
get_part($file, $searchtitle, $title, $searchtitle);
get_part($file, $searchdescription, $description, $searchdescription);
get_part($file, $searchabout, $about, $searchabout);
get_part($file, $searchurl, $url, $searchurl);
get_part($file, $searchperpage, $perpage, $searchperpage);
get_part($file, $searchhost, $host, $searchhost);
get_part($file, $searchuser, $user, $searchuser);
get_part($file, $searchpassword, $password, $searchpassword);
get_part($file, $searchdatabase, $database, $searchdatabase);
get_part($file, $searchtheme, $theme, $searchtheme);
get_part($file, $searchdisqus, $disqus, $searchdisqus);
?>