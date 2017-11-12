<?php
require_once('bookmark_fns.php');
// 有session的地方都要开启session，获取也是
session_start();

do_html_header('Home');
check_valid_user();
// get the bookmarks this user has saved
if($url_array = get_user_urls($_SESSION['valid_user'])) {
    display_user_urls($url_array);
}

// give menu of options
display_user_menu();

do_html_footer();
