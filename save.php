<?php
$result = json_decode($_REQUEST['data'], true);
foreach($result as $item) { //foreach element in $arr
    $title = $item['title']; //etc
    $content = $item['content'];
    $date = $item['publish'];
}

//$title = $_REQUEST['title'];
$newtitle = str_replace(' ', '-', $title);
$filetitle = $date.$newtitle;
$myfile = fopen("posts/".$filetitle.".md", "w") or die("Unable to open file!");
fwrite($myfile, "<h1>".$title."</h1><--end title-->");
fwrite($myfile, $content);
fclose($myfile);
?>