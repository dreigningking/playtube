<?php
// +------------------------------------------------------------------------+
// | @author Deen Doughouz (DoughouzForest)
// | @author_url 1: http://www.playtubescript.com
// | @author_url 2: http://codecanyon.net/user/doughouzforest
// | @author_email: wowondersocial@gmail.com   
// +------------------------------------------------------------------------+
// | PlayTube - The Ultimate Video Sharing Platform
// | Copyright (c) 2017 PlayTube. All rights reserved.
// +------------------------------------------------------------------------+
$whitelist = array('127.0.0.1', '::1');
// MySQL Hostname
$sql_db_host = "localhost";
if(!in_array($_SERVER['REMOTE_ADDR'], $whitelist)){
    // MySQL Database User
    $sql_db_user = "exenfdrm_bc7d6f4b36cc2f";
    // MySQL Database Password
    $sql_db_pass = "f556b82e";
    // MySQL Database Name
    $sql_db_name = "exenfdrm_tube";
    // Site URL
    $site_url = "https://tube.exenox.co"; 
}
else{
    // MySQL Database User
    $sql_db_user = "root";
    // MySQL Database Password
    $sql_db_pass = "";
    // MySQL Database Name
    $sql_db_name = "playtube";
    // Site URL
    $site_url = "http://localhost/playtube";

}

// Purchase code
//$purchase_code = "12345678"; // Your purchase code, don't give it to anyone. 
?>