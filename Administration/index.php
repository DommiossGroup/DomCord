<?php


include("../assets/classes/yml.class.php");

$_Config_ = new Read('../config/config.yml');
$_Config_ = $_Config_->GetTableau();


$_ThemeOption_ = new Read("../themes/" . $_Config_['General']['theme'] . "/info.yml");
$_ThemeOption_ = $_ThemeOption_->GetTableau();

// Database connection
$_database_ = new Read('../config/database.yml');
$_database_ = $_database_->GetTableau();

// Maintenance info
$_maintenance_ = new Read('../maintenance/maintenance.yml');
$_maintenance_ = $_maintenance_->GetTableau();

session_start();


$_license_ = new Read('../config/cms_info.yml');
$_license_ = $_license_->GetTableau();

$data = file_get_contents("https://api.dommioss.fr/domcord/licence_verify.php?key=" . $_license_['license_key'] . "&domain=" . $_SERVER['HTTP_HOST'] . "");
$obj = json_decode($data);

try {
	$bdd = new PDO('mysql:host=' . $_database_['dbAdress'] . ';dbname=' . $_database_['dbName'] . ';port=' . $_database_['dbPort'], $_database_['dbUser'], $_database_['dbPassword']);
} catch (PDOEXCEPTION $e) {
	print($e);
}


if (isset($_SESSION['id'])) {

	$requser = $bdd->prepare("SELECT * FROM " . $_Config_['Database']['table_prefix'] . "_members WHERE id = ?");

	$requser->execute(array($_SESSION['id']));

	$userinfo = $requser->fetch();

	$userrank = $bdd->prepare("SELECT * FROM " . $_Config_['Database']['table_prefix'] . "_ranks WHERE id = ?");
	$userrank->execute(array($userinfo['RANK_ID']));
	$userrank = $userrank->fetch();

	if (!isset($userrank['ADMIN_PANELACCESS']) or empty($userrank['ADMIN_PANELACCESS']) or $userrank['ADMIN_PANELACCESS'] !== "on") {
		header("Location: ../");
		die();
	}
} else {
	header("Location: ../");
	die();
}

if (isset($userrank['ADMIN_PANELACCESS']) and $userrank['ADMIN_PANELACCESS'] !== "on") {
	if ($_GET['page'] !== "error.403") {
		header("Location: ../");
		die();
	}
}

if (isset($_GET['page'])) {

	$page = htmlspecialchars($_GET['page']);
	$path = "pages/" . $page . ".php";


	if (file_exists($path)) {
		include($path);
	} else {
		include("pages/error.404.php");
	}
} else {

	$page = "home";
	$path = "pages/" . $page . ".php";


	if (file_exists($path)) {
		include($path);
	} else {
		include("pages/error.404.php");
	}
}

include("assets/includes/footer.php");
