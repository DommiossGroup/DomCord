<?php

include("../assets/classes/yml.class.php");
include("./assets/controllers/ymlFiles.php");
include("./assets/controllers/functions.php");
include("./assets/controllers/verifications.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DomCord - Configuration du CMS </title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta.2/css/bootstrap.css'>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.1.2/css/intlTelInput.css'>
    <link rel='stylesheet' href='https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css'>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css'>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel='icon' href="assets/img/loader.png">

<link rel="stylesheet" href="assets/css/demo.css">

</head>
<style>
    body {

        background-image: url('assets/img/background.webp');
        background-size: cover;
        background-repeat: no-repeat;


    }
</style>

<body>

    <header class="credit">Auteur: Groupe Dommioss - Distribué par: <a title="CMS de Forum 100% gratuit" href="https://domcord.dommioss.fr/" target="_blank">DomCord</a></header>
    <main>
        <article>

            <section class="multi_step_form">
                <form method="POST" id="msform">

                    <div class="tittle">
                        <h2>Configuration de DomCord</h2>
                        <p>Pour utiliser notre CMS, vous devez suivre les instructions suivantes.</p>
                        <?php if (isset($state1error)) echo "<br>" . $state1error; ?>
                        <?php if (isset($generror)) echo "<br>" . $generror; ?>

                    </div>

                    <ul id="progressbar">
                        <li <?php if (isset($state) && $state > 0) echo 'class="active"'; ?>>Téléchargement</li>
                        <li <?php if (isset($state) && $state > 1) echo 'class="active"'; ?>>Clé de Licence</li>
                        <li <?php if (isset($state) && $state > 2) echo 'class="active"'; ?>>Personnalisation</li>
                        <li <?php if (isset($state) && $state > 3) echo 'class="active"'; ?>>Base de données</li>
                        <li <?php if (isset($state) && $state > 4) echo 'class="active"'; ?>>Compte Superadministrateur</li>
                    </ul>
                    <?php if (isset($state) && $state == 1) { ?>

                        <fieldset>
                            <h3>Renseignez votre clé licence</h3>
                            <h6>Elle permet de vous authentifier auprès de nos API.<br><a href="https://domcord.dommioss.fr/?page=licenses" target="_blank">Je n'ai pas de clé licence</a></h6>
                            <?php
                            switch (is_writable('./state.yml')) {
                                case true:
                                    echo '<div class="form-group fg_2">
                                <input type="text" class="form-control" name="key" placeholder="Clé de licence (ex: JwaQu8GAa5C7duX76gZVK2P3Uy63288mw2Q2xNxyQ4naaTwQ3YzP8nKr3W46)">
                            </div>
                            <button type="submit" name="state1check" class="next action-button">Continuer</button>';
                                    break;
                                default:
                                    echo "<div class='alert alert-warning'>Veuillez assigner la permission d'écrire au fichier <code>installation/state.yml</code> pour continuer.</div>";
                                    break;
                            }
                            ?>




                        </fieldset>
                    <?php } elseif (isset($state) && $state == 2) { ?>
                        <fieldset>
                            <h3>Personnalisez votre site</h3>
                            <div class="form-group">
                                <select class="product_select" name="lang">
                                    <option value="fr_FR">1. Français</option>
                                    <option value="en_US">2. Anglais</option>
                                </select>
                            </div>
                            <div class="form-group fg_2">
                                <input type="text" class="form-control" name="name" placeholder="Nom du Forum">
                            </div>
                            <div class="form-group fg_2">
                                <input type="text" class="form-control" name="description" placeholder="Description du Forum">
                            </div>
                            <button type="submit" name="state2confirm" class="next action-button">Continuer</button>
                        </fieldset>

                    <?php } elseif (isset($state) && $state == 3) { ?>
                        <fieldset>
                            <h3>Configurez la base de donnée*</h3>
                            <h6>Celle-ci permet de stocker les données de votre forum<br><small>*Base de donnée <b>SQL SEULEMENT</b> (MariaDB, MySQL)</small></h6>
                            <div class="form-group fg_2">
                                <input type="text" class="form-control" name="dbAdress" placeholder="Adresse de la Base De Données (ex: localhost) [SANS PORT]">
                            </div>
                            <div class="form-group fg_2">
                                <input type="text" class="form-control" name="dbUser" placeholder="Utilisateur SQL">
                            </div>
                            <div class="form-group fg_2">
                                <input type="password" class="form-control" name="dbPassword" placeholder="Mot de passe SQL">
                            </div>
                            <select class="product_select" name="prefix">
                                <option disabled selected>Choissez un préfixe de table SQL</option>
                                <option disabled>----------------</option>
                                <option value="dc">1. Par défaut (dc)</option>
                                <option value="forum">2. forum</option>
                                <option value="mnf">3. mnf</option>
                            </select>
                            <div class="form-group fg_2">
                                <input type="text" class="form-control" name="dbName" placeholder="Nom de la BDD">
                            </div>
                            <div class="form-group fg_2">
                                <input type="number" class="form-control" name="dbPort" placeholder="Port de la BDD">
                            </div>
                            <button type="submit" name="state3confirm" class="next action-button">Continuer</button>
                        </fieldset>

                    <?php } elseif (isset($state) && $state == 4) { ?>
                        <fieldset>
                            <h3>Créer mon compte Superadministrateur</h3>
                            <h6>Ne perdez pas vos <b>identifiants</b></h6>
                            <div class="form-group fg_2">
                                <input type="text" class="form-control" placeholder="Pseudonyme" name="nametag">
                            </div>
                            <div class="form-group fg_2">
                                <input type="email" class="form-control" placeholder="Adresse e-mail" name="mail">
                            </div>
                            <div class="form-group fg_2">
                                <input type="password" class="form-control" placeholder="Mot de passe" name="pass">
                            </div>
                            <button type="submit" name="state4confirm" class="next action-button">Continuer</button>
                        </fieldset>

                    <?php } elseif (isset($state) && $state > 4) { ?>
                        <fieldset>
                            <h3>Vous avez terminé la configuration</h3>
                            <h6><b>Veuillez supprimer le dossier <code>./installation/</code> de votre FTP/SFTP</b></h6>
                            <h6><b>Veuillez supprimer le dossier <code>./installControllers/</code> de votre FTP/SFTP</b></h6>
                            <div class="passport">
                                <h4>Télécharger le CMS <br>Saisir la clé de licence <br>Personnaliser votre forum<br> Configurer la base de donnée<br> Créer un compte Superadministrateur.</h4>
                                <a href="#" class="don_icon"><i class="ion-android-done"></i></a>
                                <a href="../" class="next action-button">Terminer</a>
                            </div>
                        </fieldset>
                    <?php } ?>
                </form>
            </section>

        </article>
    </main>


    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/js/bootstrap.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.1.2/js/intlTelInput.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.min.js'></script>
    <script src="assets/js/script.js"></script>

</body>

</html>