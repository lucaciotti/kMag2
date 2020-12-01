<?php
define("SITE_PATH", getcwd());
include_once(SITE_PATH . '/libs/apiObj.php');
include_once(SITE_PATH . '/config/global_config.php'); ?>

<?php
//questa pagina esegue la query al db
$query = $_GET["query"];

$db = new apiObj();
$result = $db->execute($query);

echo $db->jsonMsg();
?>