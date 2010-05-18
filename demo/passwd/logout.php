<?php

setcookie("AuthByPasswd", "", time() - 3600, "/");

$dest = $_REQUEST['url'] ? $_REQUEST['url'] : "./";
header("Location: " . urldecode($dest));

?>
