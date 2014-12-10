<?php
if (empty($_GET["name"])){
	$name = "gila";
} else {
	$name = $_GET["name"];
}
//echo $name;
echo '<br>';
if (empty($_GET["type"])){
	$type = "tipe";
} else {
	$type = $_GET["type"];
}
//echo $type;
?>