<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/kMag2/libs/apiObj.php'); ?>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/kMag2/config/global_config.php'); ?>

<?php
//questa pagina esegue la query al db
$query = $_GET["query"];

$db = new apiObj();
$result = $db->execute($query);

echo $db->jsonMsg();
?>