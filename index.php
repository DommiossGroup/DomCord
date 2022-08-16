<?php

if (file_exists("installation/") || file_exists("installControllers/")) {

	header("Location: installation/");
	die();
}

include("./assets/classes/yml.class.php");

$_Config_ = new Read('config/config.yml');
$_Config_ = $_Config_->GetTableau();

if (!isset($_Config_['General']) || empty($_Config_['General'])) die();

// Themes and Languages

$_ThemeOption_ = new Read("themes/" . $_Config_['General']['theme'] . "/info.yml");
$_ThemeOption_ = $_ThemeOption_->GetTableau();

include("assets/lang/" . $_Config_['General']['language'] . ".php");

// Database connection
$_database_ = new Read('config/database.yml');
$_database_ = $_database_->GetTableau();


$_maintenance_ = new Read('maintenance/maintenance.yml');
$_maintenance_ = $_maintenance_->GetTableau();


session_start();

try {
	$bdd = new PDO('mysql:host=' . $_database_['dbAdress'] . ';dbname=' . $_database_['dbName'] . ';port=' . $_database_['dbPort'] . ';charset=utf8mb4', $_database_['dbUser'], $_database_['dbPassword']);
} catch (PDOEXCEPTION $e) {
	$_license_ = new Read('./config/cms_info.yml');
	$_license_ = $_license_->GetTableau();

	echo str_replace('{ERROR_DETAILS}', $e, file_get_contents("https://api.dommioss.fr/cdn/domcord/error-database.php?contenu=" . $e->getCode() . "&licencekey=" . $_license_['license_key'] . "&domain=" . $_SERVER['HTTP_HOST']));

	die();
}


if (isset($_SESSION['id'])) {

	$requser = $bdd->prepare("SELECT * FROM " . $_Config_['Database']['table_prefix'] . "_members WHERE id = ?");
	$requser->execute(array($_SESSION['id']));
	if ($requser->rowCount() > 0) {

		$userinfo = $requser->fetch();

		$userrank = $bdd->prepare("SELECT * FROM " . $_Config_['Database']['table_prefix'] . "_ranks WHERE id = ?");
		$userrank->execute(array($userinfo['RANK_ID']));
		$userrank = $userrank->fetch();

		if (isset($userinfo['STATUS']) and $userinfo['STATUS'] == 2) {
			session_destroy();
			echo '<meta http-equiv="refresh" content="0;URL=?page=login">';
			die();
		}
	} else {
		session_destroy();
		echo '<meta http-equiv="refresh" content="0;URL=?page=login">';
		die();
	}
}

if (isset($_GET['action']) and !empty($_GET['action'])) {

	if ($_GET['action'] == "disconnect") {


		$_SESSION = array();

		session_destroy();
		header("Location: ?page=home");
	} elseif ($_GET['action'] == "markallread") {


		if (isset($_SESSION['id'])) {

			$mahr = $bdd->prepare("UPDATE `" . $_Config_['Database']['table_prefix'] . "_notifications` SET READ_STATUS = 1 WHERE USER_ID = ?");
			$mahr->execute(array($userinfo['id']));
			header("Location: ?page=" . htmlspecialchars($_GET['page']) . "");
		}
		header("Location: ?page=" . htmlspecialchars($_GET['page']) . "");
	} else {
	}
}

// Widget scanning

$widgetnumber = 0;
foreach (scandir("widgets/") as $fichier) {

	if (!in_array($fichier, array(".", "..", "..."))) {
		if (file_exists("widgets/" . $fichier . "/info.yml") and file_exists("widgets/" . $fichier . "/code.php")) {
			$widgetnumber = $widgetnumber + 1;
		}
	}
}

// Includes


$headerlinks = $bdd->query("SELECT * FROM " . $_Config_['Database']['table_prefix'] . "_header");

if (isset($_SESSION['id'])) {

	$notificationlist_unread = $bdd->prepare("SELECT * FROM " . $_Config_['Database']['table_prefix'] . "_notifications WHERE USER_ID = ? AND READ_STATUS = 0");
	$notificationlist_unread->execute(array(htmlspecialchars($_SESSION['id'])));
	$nb_unread = $notificationlist_unread->rowCount();
}


$listlinks = $bdd->query("SELECT * FROM " . $_Config_['Database']['table_prefix'] . "_footer WHERE TYPE = 'LINKS'");
$listpages = $bdd->query("SELECT * FROM " . $_Config_['Database']['table_prefix'] . "_footer WHERE TYPE = 'PAGES'");
$listcontacts = $bdd->query("SELECT * FROM " . $_Config_['Database']['table_prefix'] . "_footer WHERE TYPE = 'CONTACT' LIMIT 4");



// Maintenance system

if ($_maintenance_['status'] !== "true") {
	include("assets/includes/header.php");
} else {
	if (isset($userrank['SUPERADMIN']) and $userrank['SUPERADMIN'] == "on") {
		include("assets/includes/header.php");
	} else {
		include("maintenance/maintenance.php");
		exit();
	}
}

// Ban checker

$cib = $bdd->prepare("SELECT * FROM " . $_Config_['Database']['table_prefix'] . "_bans_ip WHERE ADRESS_IP = ?");
$cib->execute(array($_SERVER['REMOTE_ADDR']));
if ($cib->rowCount() > 0) {
	$cib = $cib->fetch();
	include("themes/" . $_Config_['General']['theme'] . "/banned.php");
	if ($_ThemeOption_['ownheader'] == "false") {
		include("assets/includes/navbar.php");
	}
	if ($_ThemeOption_['ownfooter'] == "false") {
		include("assets/includes/footer.php");
	}
	die();
}

// Page content including

if (isset($_GET['page'])) {
	$page = htmlspecialchars($_GET['page']);
} else {
	$page = "home";
}
$path = "themes/" . $_Config_['General']['theme'] . "/" . $page . ".php";

if (file_exists($path)) {
	include($path);
} else {
	$cfp = $bdd->prepare("SELECT * FROM " . $_Config_['Database']['table_prefix'] . "_pages WHERE PATH = ?");
	$cfp->execute(array("?page=" . $_GET['page']));

	if ($cfp->rowCount() > 0) {
		$cfp = $cfp->fetch();
		include("themes/" . $_Config_['General']['theme'] . "/custom.php");
	} else {
		if (file_exists("themes/" . $_Config_['General']['theme'] . "/error.404.php")) {
			include("themes/" . $_Config_['General']['theme'] . "/error.404.php");
		} else {
			echo str_replace('{ERROR_DETAILS}', 'Theme folder could not be find.', file_get_contents("https://api.dommioss.fr/cdn/domcord/error-database.php"));
			die();
		}
	}
}



if ($_ThemeOption_['ownfooter'] == "false") {
	include("assets/includes/footer.php");
}

if (isset($needconnection) and $needconnection == true and !isset($_SESSION['id'])) {
	echo '<meta http-equiv="refresh" content="0;URL=?page=login"';
	die();
}

if ($_ThemeOption_['ownheader'] == "false") {
	include("assets/includes/navbar.php");
}
