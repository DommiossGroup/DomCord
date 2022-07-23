<?php



function changeStep($newStep)
{
    $c['state'] = intval($newStep);
    $c = new Write('state.yml', $c);
}

function firstConfiguration($name, $theme, $description, $tablePrefix, $language)
{
    if (is_writable('../config/config.yml')) {
        $version = json_decode(file_get_contents('https://api.dommioss.fr/domcord/download/last_update.json'))[0]->version;

        $fc['General']['name'] = $name;
        $fc['General']['theme'] = $theme;
        $fc['General']['description'] = $description;
        $fc['General']['language'] = $language;
        $fc['General']['staff_permission_level'] = 50;
        $fc['version'] = $version;
        $fc['developper_mod'] = false;
        $fc['Metadata']['keywords'] = "DomCord, Forum";
        $fc['Metadata']['robots'] = "noindex, nofollow";
        $fc['Security']['max_account_per_ip'] = 2;
        $fc['Database']['table_prefix'] = $tablePrefix;

        $fc['Additional']['nametag_change'] = true;
        $fc['Additional']['birthday_display'] = false;
        $fc['Additional']['email_display'] = false;
        $fc['Additional']['avatar_upload'] = true;


        $fc = new Write('../config/config.yml', $fc);
        return true;
    } else {
        return false;
    }
}

function tryConnection($dbAdress, $dbName, $dbPort, $dbUser, $dbPassword)
{
    try {

        new PDO('mysql:host=' . $dbAdress . ';dbname=' . $dbName . ';port=' . $dbPort, $dbUser, $dbPassword);
    } catch (PDOException $e) {
        $db_connect_error = $e->getMessage();
    }

    if (isset($db_connect_error))
        return false;
    return true;
}

function configPrefix($tablePrefix)
{
    if (is_writable('../config/config.yml')) {

        $_Config_ = new Read('../config/config.yml');
        $_Config_ = $_Config_->GetTableau();

        $fc['General']['name'] = $_Config_['General']['name'];
        $fc['General']['theme'] = $_Config_['General']['theme'];
        $fc['General']['description'] = $_Config_['General']['description'];
        $fc['General']['language'] = $_Config_['General']['language'];
        $fc['General']['staff_permission_level'] = $_Config_['General']['staff_permission_level'];
        $fc['version'] = $_Config_['version'];
        $fc['developper_mod'] = false;
        $fc['Metadata']['keywords'] = $_Config_['Metadata']['keywords'];
        $fc['Metadata']['robots'] = $_Config_['Metadata']['robots'];
        $fc['Security']['max_account_per_ip'] = $_Config_['Security']['max_account_per_ip'];
        $fc['Database']['table_prefix'] = $tablePrefix;

        $fc['Additional']['nametag_change'] = $_Config_['Additional']['nametag_change'];
        $fc['Additional']['birthday_display'] = $_Config_['Additional']['birthday_display'];
        $fc['Additional']['email_display'] = $_Config_['Additional']['email_display'];
        $fc['Additional']['avatar_upload'] = $_Config_['Additional']['avatar_upload'];


        $fc = new Write('../config/config.yml', $fc);
        return true;
    } else {
        return false;
    }
}

function configDatabase($name, $adress, $port, $user, $password)
{
    if (is_writable('../config/database.yml')) {
        $fc['dbAdress'] = $adress;
        $fc['dbPort'] = $port;
        $fc['dbName'] = $name;
        $fc['dbUser'] = $user;
        $fc['dbPassword'] = $password;


        $fc = new Write('../config/database.yml', $fc);
        return true;
    } else {
        return false;
    }
}

function putDatabaseContent()
{

    $_Database_ = new Read('../config/database.yml');
    $_Database_ = $_Database_->GetTableau();

    $_Config_ = new Read('../config/config.yml');
    $_Config_ = $_Config_->GetTableau();

    try {

        $bdd = new PDO('mysql:host=' . $_Database_['dbAdress'] . ';dbname=' . $_Database_['dbName'] . ';port=' . $_Database_['dbPort'], $_Database_['dbUser'], $_Database_['dbPassword']);
    } catch (PDOException $e) {
        $db_connect_error = $e->getMessage();
    }

    if ($db_connect_error) return false;

    $json = file_get_contents("https://api.dommioss.fr/domcord/databaseInformations.json");
    $tab = json_decode($json);
    if (!$json) {
        return false;
    }

    foreach ($tab as $item) {
        $SQL = $bdd->query(str_replace('dc', $_Config_['Database']['table_prefix'], $item->command));
        unset($SQL);
    }

    return true;
}

function createAccount($username, $mail, $pwd)
{
    $_Database_ = new Read('../config/database.yml');
    $_Database_ = $_Database_->GetTableau();

    $_Config_ = new Read('../config/config.yml');
    $_Config_ = $_Config_->GetTableau();

    try {

        $bdd = new PDO('mysql:host=' . $_Database_['dbAdress'] . ';dbname=' . $_Database_['dbName'] . ';port=' . $_Database_['dbPort'], $_Database_['dbUser'], $_Database_['dbPassword']);
    } catch (PDOException $e) {
        $db_connect_error = $e->getMessage();
    }

    if ($db_connect_error) return false;

    $insert = $bdd->prepare('INSERT INTO `' . $_Config_['Database']['table_prefix'] . '_members`(`NAMETAG`, `MAIL`, `PASSWORD`, `DATE_CREATION`, `IP_ADRESS`, `STATUS`, `AVATAR_PATH`, `RANK_ID`) VALUES (?,?,?,NOW(),?,1,?,?)');
    $insert->execute(array($username, $mail, $pwd, $_SERVER['REMOTE_ADDR'], "default.png", "2"));
    return true;
}
