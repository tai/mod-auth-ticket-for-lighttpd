<html>
<body>
<a href="../openid/login.php?url=<?= urlencode($_SERVER['SCRIPT_NAME']); ?>">login</a>, 
<a href="../openid/logout.php?url=<?= urlencode($_SERVER['SCRIPT_NAME']); ?>">logout</a>
<hr />
You are accessing as <?= $_SERVER["PHP_AUTH_USER"] ? $_SERVER["PHP_AUTH_USER"] : "anonymous" ?>
<br />
<?php

phpinfo();

?>
