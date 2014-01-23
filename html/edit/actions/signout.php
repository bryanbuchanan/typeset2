<?
include "../include.php";

setcookie($typeset_settings->cookie, "", time() - 3600, "/");
header("Location: /");

?>