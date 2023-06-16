<?php

function changeStep($newStep)
{
    $state["state"] = intval($newStep);
    $state = new Write("./state.yml", $state);
}

function firstConfiguration($name, $theme, $description, $tablePrefix, $language)
{
    if (!is_writable("../config/config.yml"))
        return false;

    $version = json_decode(file_get_contents("https://api.dommioss.fr/domcord/download/last_update.json"))[0]->version;

    $fc["General"]["name"] = $name;
    $fc["General"]["theme"] = $theme;
    $fc["General"]["description"] = $description;
    $fc["General"]["language"] = $language;
    $fc["General"]["staff_permission_level"] = 50;
    $fc["version"] = $version;
    $fc["developper_mod"] = false;
    $fc["Metadata"]["keywords"] = "DomCord, Forum";
    $fc["Metadata"]["robots"] = "noindex, nofollow";
    $fc["Security"]["max_account_per_ip"] = 2;
    $fc["Database"]["table_prefix"] = $tablePrefix;

    $fc["Additional"]["nametag_change"] = true;
    $fc["Additional"]["birthday_display"] = false;
    $fc["Additional"]["email_display"] = false;
    $fc["Additional"]["avatar_upload"] = true;

    $fc = new Write("../config/config.yml", $fc);

    return true;
}

function tryConnection($dbAdress, $dbName, $dbPort, $dbUser, $dbPassword)
{
    try {
        new PDO("mysql:host=" . $dbAdress . ";dbname=" . $dbName . ";port=" . $dbPort, $dbUser, $dbPassword);
    } catch (PDOException $e) {
        $db_connect_error = $e->getMessage();
        return false;
    }

    return true;
}

function configPrefix($tablePrefix)
{
    if (!is_writable("../config/config.yml"))
        return false;

    $config = new Read("../config/config.yml");
    $config = $config->GetTableau();

    $fc["General"]["name"] = $config["General"]["name"];
    $fc["General"]["theme"] = $config["General"]["theme"];
    $fc["General"]["description"] = $config["General"]["description"];
    $fc["General"]["language"] = $config["General"]["language"];
    $fc["General"]["staff_permission_level"] = $config["General"]["staff_permission_level"];
    $fc["version"] = $config["version"];
    $fc["developper_mod"] = false;
    $fc["Metadata"]["keywords"] = $config["Metadata"]["keywords"];
    $fc["Metadata"]["robots"] = $config["Metadata"]["robots"];
    $fc["Security"]["max_account_per_ip"] = $config["Security"]["max_account_per_ip"];
    $fc["Database"]["table_prefix"] = $tablePrefix;

    $fc["Additional"]["nametag_change"] = $config["Additional"]["nametag_change"];
    $fc["Additional"]["birthday_display"] = $config["Additional"]["birthday_display"];
    $fc["Additional"]["email_display"] = $config["Additional"]["email_display"];
    $fc["Additional"]["avatar_upload"] = $config["Additional"]["avatar_upload"];

    $fc = new Write("../config/config.yml", $fc);

    return true;
}

function configDatabase($name, $adress, $port, $user, $password)
{
    if (!is_writable("../config/database.yml"))
        return false;

    $fc["dbAdress"] = $adress;
    $fc["dbPort"] = $port;
    $fc["dbName"] = $name;
    $fc["dbUser"] = $user;
    $fc["dbPassword"] = $password;

    $fc = new Write("../config/database.yml", $fc);

    return true;
}

function putDatabaseContent()
{

    $database = new Read("../config/database.yml");
    $database = $database->GetTableau();

    $config = new Read("../config/config.yml");
    $config = $config->GetTableau();

    try {
        $bdd = new PDO("mysql:host=" . $database["dbAdress"] . ";dbname=" . $database["dbName"] . ";port=" . $database["dbPort"], $database["dbUser"], $database["dbPassword"]);
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
        $SQL = $bdd->query(str_replace("dc", $config["Database"]["table_prefix"], $item->command));
        unset($SQL);
    }

    return true;
}

function createAccount($username, $mail, $pwd)
{
    $database = new Read("../config/database.yml");
    $database = $database->GetTableau();

    $config = new Read("../config/config.yml");
    $config = $config->GetTableau();

    try {
        $bdd = new PDO("mysql:host=" . $database["dbAdress"] . ";dbname=" . $database["dbName"] . ";port=" . $database["dbPort"], $database["dbUser"], $database["dbPassword"]);
    } catch (PDOException $e) {
        $db_connect_error = $e->getMessage();
    }

    if ($db_connect_error) return false;

    $insert = $bdd->prepare("INSERT INTO `" . $config["Database"]["table_prefix"] . "_members`(`NAMETAG`, `MAIL`, `PASSWORD`, `DATE_CREATION`, `IP_ADRESS`, `STATUS`, `AVATAR_PATH`, `RANK_ID`) VALUES (?,?,?,NOW(),?,1,?,?)");
    $insert->execute(array($username, $mail, $pwd, $_SERVER["REMOTE_ADDR"], "default.png", "2"));
    return true;
}
