<?php
require_once('bookmark_fns.php');
session_start();

// create short variable names
$username = $_POST['username'];
$passwd = $_POST['passwd'];

if($username && $passwd) {
    try {
        login($username, $passwd);
        $_SESSION['valid_user'] = $username;
        // 登录成功重定向页面
        echo "<script language='javascript'>location.href='http://localhost/bookmark/member.php';</script>";
    } catch (Exception $e) {
        do_html_header('Problem');
        echo 'You could not be logged in.
        You must be logged in to view this page.';
        do_html_url('login_form.php', 'Login');
        do_html_footer();
        exit;
    }
}