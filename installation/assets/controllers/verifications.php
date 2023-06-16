<?php

if (isset($_POST["state1check"])) {

    if (isset($_POST["key"]) && !empty($_POST["key"])) {
        $check = json_decode(file_get_contents("https://api.dommioss.fr/domcord/licence_verify.php?key=" . $_POST["key"] . "&domain=" . $_SERVER["HTTP_HOST"]));

        switch ($check->code) {
            case 200:
                changeStep(2);
                $l["license_key"] = htmlspecialchars($_POST["key"]);
                $l = new Write("../config/cms_info.yml", $l);

                $generror = "<div class='alert alert-success'>La clé a été <b>validée</b>.</div>";
                echo '<meta http-equiv="refresh" content="1;URL=index.php">';
                break;
            default:
                $generror = "<div class='alert alert-danger'>La clé de licence <b>n'a pas pu être validée</b>.</div>";
                break;
        }
    } else {
        $generror = '<div class="alert alert-danger">Veuillez renseigner <b>tous</b> les champs.</div>';
    }
}

if (isset($_POST["state2confirm"])) {

    if (!isset($_POST["name"]) || empty($_POST["name"]))
        return $generror = "<div class='alert alert-danger'>Veuillez renseigner <b>tous</b> les champs.</div>";

    if (!isset($_POST["description"]) || empty($_POST["description"]))
        return $generror = "<div class='alert alert-danger'>Veuillez renseigner <b>tous</b> les champs.</div>";

    if (!isset($_POST["lang"]) || empty($_POST["lang"]))
        return $generror = "<div class='alert alert-danger'>Veuillez renseigner <b>tous</b> les champs.</div>";

    if (!firstConfiguration(htmlspecialchars($_POST["name"]), "DomCord-Default-Theme-main", htmlspecialchars($_POST["description"]), "dc", htmlspecialchars($_POST["lang"])))
        return $generror = "<div class='alert alert-danger'>Une erreur est survenue.</div>";

    $generror = "<div class='alert alert-success'>Les paramètres ont bien été enregistrés.</div>";
    echo '<meta http-equiv="refresh" content="1;URL=index.php">';
    changeStep(3);
}

if (isset($_POST["state3confirm"])) {

    if (!isset($_POST["dbPort"]) || empty($_POST["dbPort"]))
        return $generror = "<div class='alert alert-danger'>Veuillez renseigner le <b>port</b>.</div>";
    if (!isset($_POST["dbPort"]) || empty($_POST["prefix"]))
        return $generror = "<div class='alert alert-danger'>Veuillez renseigner le <b>préfixe</b> de table.</div>";
    if (!isset($_POST["dbPort"]) || empty($_POST["dbAdress"]))
        return $generror = "<div class='alert alert-danger'>Veuillez renseigner l'<b>adresse</b> de la base de donnée.</div>";
    if (!isset($_POST["dbPort"]) || empty($_POST["dbPassword"]))
        return $generror = "<div class='alert alert-danger'>Veuillez renseigner le <b>mot de passe</b>.</div>";
    if (!isset($_POST["dbPort"]) || empty($_POST["dbName"]))
        return $generror = "<div class='alert alert-danger'>Veuillez renseigner le <b>nom</b> de la base de donnée.</div>";
    if (!isset($_POST["dbPort"]) || empty($_POST["dbUser"]))
        return $generror = "<div class='alert alert-danger'>Veuillez renseigner le <b>nom d'utilisateur</b> SQL.</div>";

    if (!tryConnection($_POST["dbAdress"], $_POST["dbName"], $_POST["dbPort"], $_POST["dbUser"], $_POST["dbPassword"]))
        return $generror = "<div class='alert alert-danger'>Une erreur est survenue lors de la connexion, vérifiez les informations saisies.</div>";

    if (!configPrefix($_POST["prefix"]))
        return $generror = "<div class='alert alert-danger'>Une erreur est survenue lors de la modification du préfixe.</div>";

    if (!configDatabase($_POST["dbName"], $_POST["dbAdress"], $_POST["dbPort"], $_POST["dbUser"], $_POST["dbPassword"]))
        return $generror = "<div class='alert alert-danger'>Une erreur est survenue lors de la modification des informations SQL.</div>";

    if (!putDatabaseContent())
        return $generror = "<div class='alert alert-danger'>Une erreur est survenue lors de l'insertion du contenu de base de donnée.</div>";

    $generror = "<div class='alert alert-success'>Votre base de donnée a été configurée avec succès.</div>";
    echo '<meta http-equiv="refresh" content="1;URL=index.php">';
    changeStep(4);
}

if (isset($_POST["state4confirm"])) {

    if (!isset($_POST["nametag"]) || empty($_POST["nametag"]))
        return $generror = "<div class='alert alert-danger'>Veuillez renseigner votre <b>nom d'utilisateur</b>.</div>";
    if (!isset($_POST["mail"]) || empty($_POST["mail"]))
        return $generror = "<div class='alert alert-danger'>Veuillez renseigner votre <b>adresse e-mail</b>.</div>";
    if (!isset($_POST["pass"]) || empty($_POST["pass"]))
        return $generror = "<div class='alert alert-danger'>Veuillez renseigner votre <b>mot de passe</b>.</div>";

    $username = htmlspecialchars($_POST["nametag"]);
    $mail = htmlspecialchars($_POST["mail"]);
    $pass = htmlspecialchars($_POST["pass"]);
    $hashedPass = sha1($_POST["pass"]);
    $passLenght = strlen($pass);

    if ($passLenght < 5)
        return $generror = "<div class='alert alert-danger'>Votre mot de passe doit contenir au moins <b>5 caractères</b>.</div>";

    if (!filter_var($mail, FILTER_VALIDATE_EMAIL))
        return $generror = "<div class='alert alert-danger'>Votre adresse e-mail n'est <b>pas valide</b>.</div>";

    if (!createAccount($username, $mail, $hashedPass))
        return $generror = "<div class='alert alert-danger'>Une erreur est survenue lors de la création du compte</div>";

    $generror = "<div class='alert alert-success'>Votre compte a été créé avec succès.</div>";
    echo '<meta http-equiv="refresh" content="1;URL=index.php">';
    changeStep(5);
}
