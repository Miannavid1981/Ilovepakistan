<?php

/* Handy Code Provided by STEPHENCARR.NET */

$iPod = stripos($_SERVER['HTTP_USER_AGENT'], "iPod");
$iPhone = stripos($_SERVER['HTTP_USER_AGENT'], "iPhone");
$iPad = stripos($_SERVER['HTTP_USER_AGENT'], "iPad");
$Android = stripos($_SERVER['HTTP_USER_AGENT'], "Android");
$Web = stripos($_SERVER['HTTP_USER_AGENT'], "Chrome");

// Check if the user agent contains "Mozilla" (typical for web browsers)

// Check if user is using iPod, iPhone, or iPad...
if ($iPod || $iPhone || $iPad) {
    // Send these people to Apple Store
    header('Location: https://apps.apple.com/pk/app/ezeeperks/id1635043627'); // Apple Store link here
} else if ($Android) {
    // Send these people to Android Store
    header('Location: https://play.google.com/store/apps/details?id=com.allaaddin.customer'); // Android Store link here
} else if ($Web) {
    // Redirect web users to the specified website
    header('Location: https://www.allaaddin.com'); // Your website link here
}
/* Handy Code Provided by STEPHENCARR.NET */

?>
