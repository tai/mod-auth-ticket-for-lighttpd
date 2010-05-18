<html>
<head>
<title>please login</title>
</head>
<body>
[<a href="./">dir</a>]
<hr />
<pre>
Enter username and password:
<form method="post" action="check.php">
Username: <input name="username" size="20" value="tai" />
Password: <input name="password" size="20" value="hogehoge" />
<input type="submit" />
<input type="hidden" name="url" value="<?= urlencode($_REQUEST['url']); ?>" />
</form>
</pre>
</body>
</html>
