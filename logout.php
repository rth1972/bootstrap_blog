<?php
/**
 * Created by PhpStorm.
 * User: robin
 * Date: 8/15/14
 * Time: 1:42 AM
 */
session_start();
if(session_destroy()){
    echo '1';
} else {
    echo '0';
}
?>