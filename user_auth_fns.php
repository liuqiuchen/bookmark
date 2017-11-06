<?php
/**
 * 注册
 * 登录
 * 检查用户是否登录
 * 修改密码
 * 重置密码
 * 通知新密码
 */

require_once('db_fns.php');

function register($username, $email, $password) {
    $conn = db_connect();

    // check if username is unique
    $result = $conn->query("select * from user where username='".$username."'");
    if(!$result) {
        throw new Exception('不能执行查询');
    }
    if($result->num_rows > 0) {
        throw new Exception('用户名已经被注册');
    }

    // if ok, put in db
    $result = $conn->query("insert into user values(
    '".$username."', sha1('".$password."'), '".$email."')");
    if(!$result) {
        throw new Exception('不能把你注册到数据库，请再次尝试。');
    }
    return true;
}

function login($username, $password) {
    // check username and password with db
    // if yes, return true
    // else throw exception
    $conn = db_connect();
    $result = $conn->query("select * from user where username='".$username."' and passwd = 
    sha1('".$password."')");
    if(!$result) {
        throw new Exception('Could not log you in');
    }

    if($result->num_rows>0) {
        return true;
    } else {
        throw new Exception('Could not log you in');
    }
}

// 检查用户是否登录
function check_valid_user() {
    if(isset($_SESSION['valid_user'])) {
        echo 'Logged in ad '. $_SESSION['valid_user'];
    } else {
        // they are not logged in
        do_html_heading('Problem: ');
        echo 'You are not logged in.<br/>';
        do_html_url('login.php', 'Login');
        do_html_footer();
        exit;
    }
}

function change_password($username, $old_password, $new_password) {
    // if the old password is right
    // change their password to new_password and return true
    // else throw an exception
    login($username, $old_password);
    $conn = db_connect();
    $result = $conn->query("update user set passwd = sha1('".$new_password."') 
    where username = '".$username."'");

    if(!$result) {
        throw new Exception("Password could not be changed");
    } else {
        return true;
    }
}






































