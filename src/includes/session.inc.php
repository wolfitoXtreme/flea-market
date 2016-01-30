<?php
session_start();
//session_destroy();
if (!isset($_SESSION["userid"])) {
    $_SESSION["userid"] = session_id();
    //echo "new session<br />";
    //echo "session_id() = ".$_SESSION["userid"]."<br />";
}
else {
    //echo "session exist<br />";
}

//echo "session_id() = ".$_SESSION["userid"]."<br />";

$_SERVER["HTTP_REFERER"] != "" ? $_SESSION["reference"] = $_SERVER["HTTP_REFERER"] : $_SESSION["reference"] = "No reference";

//language
if ($_GET["lang"]) {
    $_SESSION["lang"] = $_GET["lang"];
}

//echo $_GET["lang"]."<br />";

# base URL
$GLOBALS["base_url"] = "http://".$_SERVER['HTTP_HOST']."/";

# Force Englis Language
$serverName = $_SERVER['SERVER_NAME'];
$path = $_SERVER['REQUEST_URI'];
$GLOBALS["fullUrlA"] = "http://www.".$serverName.$path;
$GLOBALS["fullUrlB"] = "http://".$serverName.$path;

if($GLOBALS["base_url"] == $GLOBALS["fullUrlA"] || $GLOBALS["base_url"] == $GLOBALS["fullUrlB"]){
    //echo "match<br />";
    $_SESSION["lang"] = "en"; 
}

// if NO language defined force as well
if(!isset($_SESSION["lang"])) {
    $_SESSION["lang"] = "en";
}

?>
