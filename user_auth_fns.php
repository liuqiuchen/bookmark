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
require './lib/phpMailer/class.phpmailer.php';
require './lib/phpMailer/class.smtp.php';

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
    /**
     * check_valid_user() 不再连接数据库，但是它检查该用户是否有注册过的会话，
     * 也就是说，该用户是否已经登录。
     */
    if(isset($_SESSION['valid_user'])) {
        echo 'Logged in as '. $_SESSION['valid_user'].'.';
    } else {
        // they are not logged in
        do_html_heading('Problem: ');
        echo 'You are not logged in.<br/>';
        do_html_url('login_form.php', 'Login');
        do_html_footer();
        exit;
    }
}

function change_password($username, $old_password, $new_password) {
    // if the old password is right
    // change their password to new_password and return true
    // else throw an exception
    login($username, $old_password); // 调用login()来判断用户输入的旧密码是否正确。
    $conn = db_connect();
    $result = $conn->query("update user set passwd = sha1('".$new_password."') 
    where username = '".$username."'");

    if(!$result) {
        throw new Exception("Password could not be changed");
    } else {
        return true;
    }
}

function get_random_num() {
    // get a random dictionary word between 6 and 13 chars in length
    $total=rand(6, 13);

    for($i = 0;$i < $total;$i++) {
        $arr[$i] = rand(0, 9);
    }
    $random_num = implode('', $arr);
    return $random_num;
}

// 重置密码（初始化一个密码）
function reset_password($username) {
    // set password for username to a random value
    // return the new password or false on failure
    // get a random dictionary word between 6 and 13 chars in length
    $new_password = get_random_num();
    $conn = db_connect();
    $result = $conn->query("update user set passwd = sha1('".$new_password."')
     where username = '".$username."'");
    if(!$result) {
        throw new Exception('Could not change password.'); // not changed
    } else {
        return $new_password; // changed successfully
    }
}

// 通知用户新密码
function notify_password($username, $password) {
    // notify the user that their password has been changed
    $conn = db_connect();
    $result = $conn->query("select email from user where username='".$username."'");
    if(!$result) {
        throw new Exception('Could not find email address');
    } else if ($result->num_rows == 0) {
        throw new Exception('Could not find email address');
    } else {
        $row = $result->fetch_object();
        $address = $row->email;
        $from = "From: bookmarkSupport@example.com \r\n";
        $mesg = "Your PHPBookmark password has been changed to ".$password."\r\n"
            ."Please change it next time you log in.\r\n";
        $mail = new PHPMailer(); //建立邮件发送类
        $mail->IsSMTP(); // 使用SMTP方式发送
        $mail->CharSet ="UTF-8";//设置编码，否则发送中文乱码
        $mail->Host = "smtp.163.com"; // 您的企业邮局域名
        $mail->SMTPAuth = true; // 启用SMTP验证功能
        $mail->Username = "asinaqq@163.com"; // 邮局用户名(请填写完整的email地址)
        $mail->Password = "87794055dsdsfsd"; // 邮局密码，是发件人163账号的smtp授权码

        $mail->From = "asinaqq@163.com"; //邮件发送者email地址
        $mail->FromName = "asinaqq";
        $mail->AddAddress($address);//收件人地址，可以替换成任何想要接收邮件的email信箱,格式是AddAddress("收件人email","收件人姓名")
        $mail->Subject = $from; //邮件标题
        $mail->Body = $mesg; //邮件内容
        //$mail->AltBody = "This is the body in plain text for non-HTML mail clients"; //附加信息，可以省略

        if(!$mail->Send()) {
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            return true;
        }
    }
}
