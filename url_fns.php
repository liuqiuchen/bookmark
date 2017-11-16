<?php
require_once('db_fns.php');

function get_user_urls($username) {
    $conn = db_connect();
    $result = $conn->query("select bm_URL from bookmark where username = 
'".$username."'");

    if(!$result) {
        return false;
    }

    // create an array of the URLS
    $url_array = array();
    for($count = 1;$row = $result->fetch_row();++$count) {
        $url_array[$count] = $row[0];
    }
    return $url_array;
}

function add_bm($new_url) {
    echo 'Attempting to add '.htmlspecialchars($new_url).'<br/>';
    $valid_user = $_SESSION['valid_user'];

    $conn = db_connect();

    // check not a repeat bookmark
    $result = $conn->query("select * from bookmark where username='".$valid_user."'
    and bm_URL='".$new_url."'");

    if($result && ($result->num_rows > 0)) {
        throw new Exception('Bookmark already exists');
    }

    // insert the new bookmark
    if(!$conn->query("insert into bookmark values 
  ('".$valid_user."', '".$new_url."')")) {
        throw new Exception('Bookmark could not be inserted.');
    }
    return true;
}

function delete_bm($user, $url) {
    $conn = db_connect();

    // delete the bookmark
    if(!$conn->query("delete from bookmark where username='".$user."'
    and bm_url='".$url."'")) {
        throw new Exception('Bookmark could not be deleted');
    }
    return true;
}

function recommend_urls($valid_user) {
    /**
     * 我们将给人们提供半智能的建议。如果他们有一个与其他用户相同的URL，
     * 他们可能会喜欢这些人喜欢的其他网址。
     */
    $conn = db_connect();

    $query = "select bm_URL
	        from bookmark
	        where username in
	   	    (select distinct(b2.username)
            from bookmark b1, bookmark b2
		    where b1.username='".$valid_user."'
               and b1.username != b2.username
               and b1.bm_URL = b2.bm_URL)
	           and bm_URL not in
 		       (select bm_URL
				   from bookmark
				   where username='".$valid_user."')";

    if(!($result = $conn->query($query))) {
        throw new Exception('1. Could not find any bookmarks to recommend');
    }

    if($result->num_rows == 0) {
        throw new Exception('2. Could not find any bookmarks to recommend');
    }

    $urls = array();

    for($count = 0;$row = $result->fetch_object();$count++) {
        $urls[$count] = $row->bm_URL;
    }

    return $urls;

}
