<?
include "../include.php";

setcookie($typset_settings->cookie, "", time() - 3600, "/");
header("Location: /");

?>