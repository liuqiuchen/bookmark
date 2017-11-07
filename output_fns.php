<?php

function do_html_header($title) {
    // print an HTML header
?>
<html>
<head>
    <title><?php echo $title;?></title>
    <style>

    </style>
</head>
<body>
    <img src="bookmark.gif" alt="PHPbookmark logo" border="0" align="left"
    valign="bottom" height="55" width="57">
    <h1>PHPbookmark</h1>
    <hr/>
<?php
    if($title) {
        do_html_heading($title);
    }
}

function do_html_heading($heading) {

}