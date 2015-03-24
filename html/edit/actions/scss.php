<?
if (!isset($_SERVER["PATH_INFO"])) $_SERVER["PATH_INFO"] = $_SERVER["ORIG_PATH_INFO"]; // BlueHost fix
include "../components/autoload.php";
$scss = new scssc();
$scss->setImportPaths("../styles/");
$server = new scss_server("../styles", "../cache", $scss);
$server->serve();
?>
