<?php
// dummy account for demo
function check_user($user, $pass) {
  return $user == "tai" && $pass == "hogehoge";
}

function encrypt($buf, $key, $keylen) {
    $n = strlen($buf);
    for ($i = 0; $i < $n; $i++) {
        $c = ord($buf[$i]);
        $c ^= ($i > 0 ? ord($buf[$i - 1]) : 0) ^ ord($key[$i % $keylen]);
        $buf[$i] = chr($c);
    }
    return $buf;
}

function make_cookie($key, $data) {
    $now = time();
    $now = $now - $now % 5;
    $tmp = md5($now . $key, TRUE);

    $enc = bin2hex(encrypt($data, $tmp, strlen($tmp)));
    $sig = md5($key . $now . $enc);
    return "crypt:" . $sig . ":" . $enc;
}

// check identity
if (! check_user($_POST["username"], $_POST["password"])) {
    $dest = "login.php?url=" . urlencode(urldecode($_POST['url']));
    header("Location: ". $dest);
    exit(0);
}

//echo "<pre>"; print_r($_POST); exit(0);

// set verified identity in a cookie
$secret = base64_encode($_POST["username"] . ":dummytext");
$cookie = make_cookie("sharedsecret.passwd", $secret);
setcookie("AuthByPasswd", $cookie, 0, "/", "", FALSE, TRUE);
header("Location: " . urldecode($_POST["url"]));

?>
