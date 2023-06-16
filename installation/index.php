<?php
include("../assets/classes/yml.class.php");

$state = new Read("./state.yml");
$state = $state->GetTableau();
$state = $state["state"];

include("./assets/controllers/functions.php");
include("./assets/controllers/verifications.php");
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DomCord - Configuration du CMS</title>
    <link rel="icon" href="./assets/img/icon.png">
    <script src="https://kit.fontawesome.com/0e2dd8d853.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="./assets/css/demo.css">
</head>

<body>

    <div class="credit">Auteur : Groupe Dommioss - Distribué par : <a title="CMS de Forum 100% gratuit" href="https://domcord.dommioss.fr/" target="_blank">DomCord <i class="fa-solid fa-arrow-up-right-from-square"></i></a></div>

    <form method="POST" id="msform">

        <div class="title">
            <h2>Configuration de DomCord</h2>
            <p>Pour utiliser notre CMS, vous devez suivre les instructions suivantes.</p>
            <?php if (isset($generror)) echo "<br>" . $generror; ?>
        </div>

        <ul id="progressbar">
            <li <?php if (isset($state) && $state >= 1) echo 'class="active"'; ?>>Clé de Licence</li>
            <li <?php if (isset($state) && $state >= 2) echo 'class="active"'; ?>>Personnalisation</li>
            <li <?php if (isset($state) && $state >= 3) echo 'class="active"'; ?>>Base de données</li>
            <li <?php if (isset($state) && $state >= 4) echo 'class="active"'; ?>>Compte Superadministrateur</li>
            <li <?php if (isset($state) && $state >= 5) echo 'class="active"'; ?>>Finalisation</li>
        </ul>

        <?php if (isset($state) && $state === 1) { ?>

            <fieldset>
                <h3>Renseignez votre clé licence</h3>
                <h6><a href="https://domcord.dommioss.fr/mes-licences" target="_blank">Je n'ai pas de clé licence</a></h6>
                <?php if (is_writable("./state.yml")) { ?>
                    <div class="mform-group fg_2">
                        <input type="text" class="form-control" name="key" placeholder="Clé de licence (ex: JwaQu8GAa5C7duX76gZVK2P3Uy63288mw2Q2xNxyQ4naaTwQ3YzP8nKr3W46)">
                    </div>
                    <button type="submit" name="state1check" class="action-button">Continuer</button>
                <?php } else { ?>
                    <div class="alert alert-warning">Veuillez assigner la permission d'écrire au fichier <code>installation/state.yml</code> pour continuer.</div>
                <?php } ?>
            </fieldset>

        <?php } elseif (isset($state) && $state === 2) { ?>

            <fieldset>
                <h3>Personnalisez votre site</h3>
                <div class="mform-group">
                    <select class="product_select" name="lang">
                        <option value="fr_FR">1. Français</option>
                        <option value="en_US">2. Anglais</option>
                    </select>
                </div>
                <div class="mform-group fg_2 abc">
                    <input type="text" class="form-control" name="name" placeholder="Nom du Forum">
                </div>
                <div class="mform-group fg_2">
                    <input type="text" class="form-control" name="description" placeholder="Description du Forum">
                </div>
                <button type="submit" name="state2confirm" class="action-button">Continuer</button>
            </fieldset>

        <?php } elseif (isset($state) && $state == 3) { ?>

            <fieldset>
                <h3>Configurez la base de donnée*</h3>
                <h6>Celle-ci permet de stocker les données de votre forum<br><small>*Base de donnée <b>SQL SEULEMENT</b> (MariaDB, MySQL)</small></h6>
                <div class="mform-group fg_2">
                    <input type="text" class="form-control" name="dbAdress" placeholder="Adresse de la base de données (ex: localhost) [SANS PORT]">
                </div>
                <div class="mform-group fg_2">
                    <input type="number" class="form-control" name="dbPort" placeholder="Port de la base de données (ex: 3306)">
                </div>
                <div class="mform-group fg_2">
                    <input type="text" class="form-control" name="dbUser" placeholder="Utilisateur de la base de données">
                </div>
                <div class="mform-group fg_2">
                    <input type="password" class="form-control" name="dbPassword" placeholder="Mot de passe de la base de données">
                </div>
                <div class="mform-group">
                    <select class="product_select" name="prefix">
                        <option disabled selected>Choissez un préfixe de table SQL</option>
                        <option value="dc">1. dc_</option>
                        <option value="forum">2. forum_</option>
                        <option value="mnf">3. mnf_</option>
                    </select>
                </div>
                <div class="mform-group fg_2 abc">
                    <input type="text" class="form-control" name="dbName" placeholder="Nom de la base de données">
                </div>
                <button type="submit" name="state3confirm" class="action-button">Continuer</button>
            </fieldset>

        <?php } elseif (isset($state) && $state == 4) { ?>

            <fieldset>
                <h3>Créer mon compte Superadministrateur</h3>
                <h6>Ne perdez pas vos <b>identifiants</b></h6>
                <div class="mform-group fg_2">
                    <input type="text" class="form-control" placeholder="Pseudonyme" name="nametag">
                </div>
                <div class="mform-group fg_2">
                    <input type="email" class="form-control" placeholder="Adresse e-mail" name="mail">
                </div>
                <div class="mform-group fg_2">
                    <input type="password" class="form-control" placeholder="Mot de passe" name="pass">
                </div>
                <button type="submit" name="state4confirm" class="action-button">Continuer</button>
            </fieldset>

        <?php } elseif (isset($state) && $state > 4) { ?>

            <fieldset>
                <h3>Vous avez terminé la configuration</h3>
                <h6><b>Veuillez supprimer le dossier <code>installation/</code> de votre FTP/SFTP</b></h6>
                <div class="passport">
                    <a href="../" class="action-button">Terminer</a>
                </div>
            </fieldset>

        <?php } ?>
    </form>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.min.js"></script>
    <script src="./assets/js/script.js"></script>

</body>

</html>