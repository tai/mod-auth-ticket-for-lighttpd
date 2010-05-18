<?php

function make_googleauth_url($dest) {
    $base = "http://h.rakugaki.org:90/demo/";
    $dest = urlencode($dest);
    $args = array(
        "return_to"  => $base . "openid/login-relay.php?url=" . $dest,
        "realm"      => $base,

        "mode"        => "checkid_setup",
        "ns"          => "http://specs.openid.net/auth/2.0",
        "identity"    => "http://specs.openid.net/auth/2.0/identifier_select",
        "claimed_id"  => "http://specs.openid.net/auth/2.0/identifier_select",

        "ns.ext1"         => "http://openid.net/srv/ax/1.0",
        "ext1.mode"       => "fetch_request",
        "ext1.required"   => "email",
        "ext1.type.email" => "http://axschema.org/contact/email",
    );

    foreach ($args as $key => $value) {
        $opts[] = urlencode("openid." . $key) . '=' . urlencode($value);
    }

    return "https://www.google.com/accounts/o8/ud?" . implode('&', $opts);
}

$url = make_googleauth_url($_REQUEST['url']);
header("Location: " . $url);

?>
