<?php

function check_user() {
    $dest = "https://www.google.com/accounts/o8/ud";
    $args = $_SERVER['QUERY_STRING'];
    $args = preg_replace('/openid.mode=\w+/',
                         'openid.mode=check_authentication', $args);

    $ch = curl_init($dest);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $ret = curl_exec($ch);
    curl_close($ch);

    // verify
    return preg_match('/is_valid:true/', $ret) > 0;
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

//phpinfo(); exit(0);

if (! check_user()) {
    $dest = "login.php?url=" . urlencode(urldecode($_REQUEST['url']));
    header("Location: " . $dest);
    exit(0);
}

// generate auth cookie
$user   = $_REQUEST['openid_ext1_value_email'];
$secret = base64_encode($user . ":dummytext");
$cookie = make_cookie("sharedsecret.openid", $secret);
setcookie("AuthByOpenID", $cookie, 0, "/", "", FALSE, TRUE);

// jump back to original location
$dest = $_REQUEST['url'] ? $_REQUEST['url'] : "./";
header("Location: " . urldecode($dest));

?>
