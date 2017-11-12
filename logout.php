<?php
require_once('bookmark_fns.php');
session_start();
$old_user = $_SESSION['valid_user']; // 保存session到变量中，帮助下面判断

// 销毁session
unset($_SESSION['valid_user']);
$result_dest = session_destroy();

// start output html
do_html_header('Logging Out');

if(!empty($old_user)) {
    if($result_dest) {
        echo 'Logged out.<br/>';
        do_html_url('login_form.php', 'Login');
    } else {
        echo 'Could not log you out.<br/>';
    }
} else {
    echo '你没有登录，不需要退出。';
    do_html_url('login_form.php', 'Login');
}

do_html_footer();
