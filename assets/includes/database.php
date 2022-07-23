<?php 

$_database_ = new Read('config/database.yml');
$_database_ = $_database_->GetTableau();

try {
	$bdd = new PDO('mysql:host=' .$_database_['dbAdress'] .';dbname=' .$_database_['dbName'].';port=' .$_database_['dbPort'], $_database_['dbUser'], $_database_['dbPassword']);

} catch (PDOEXCEPTION $e) {

	print($e);

}

if(!isset($e) AND empty($e)){
	$e = "Successufly connected !";
	print($e);
}
?>

