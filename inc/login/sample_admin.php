<?php
include('php_lib_login_includes/login.inc.php');
lib_login_protect_page_uber();
?>

<html>
	<head><title>administration</title></head>
	<body>

<?php


echo $HEADER_TAG_OPEN."administration".$HEADER_TAG_CLOSE."<hr>";
lib_login_show_group_management_form($giderror);
echo "<hr>";
lib_login_show_log_form();
echo "<hr>";
lib_login_show_ip_ban_form($error);
echo "<hr>";
lib_login_show_uber_change_passwd_form($error);
echo "<hr>";
lib_login_show_delete_user_form($error);
?>

</body></html>

