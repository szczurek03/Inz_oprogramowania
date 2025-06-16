<?php
session_start();
require_once 'logout_functions.php';

logoutUser();

header('Cache-Control: no-cache, no-store, must-revalidate');
header('Location: loginSite.php');
exit;
?>