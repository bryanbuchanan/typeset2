<?
require "../library/scss/scss.inc.php";
$scss = new scssc();
$scss->setImportPaths("../styles/");
$server = new scss_server("../styles", "../cache", $scss);
$server->serve();
?>