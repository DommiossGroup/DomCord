<?php

if (isset($_SESSION['id'])) {

    echo '<meta http-equiv="refresh" content="0;URL=?page=account">';
    die();
}

if (isset($_POST['connexion'])) {


    $mailconnexion = htmlspecialchars($_POST['mailconnexion']);

    $passwordconnexion = sha1($_POST['passwordconnexion']);


    if (!empty($mailconnexion) and !empty($passwordconnexion)) {

        $SQL = $bdd->prepare('SELECT * FROM `' . $_Config_['Database']['table_prefix'] . '_members` WHERE MAIL = ? AND PASSWORD = ?');

        $SQL->execute(array($mailconnexion, $passwordconnexion));

        $user_exist = $SQL->rowCount();

        if ($user_exist == 1) {

            $userinfo = $SQL->fetch();

            if ($passwordconnexion == $userinfo['PASSWORD']) {

                if ($userinfo['STATUS'] < 2) {
                    if ($userinfo['STATUS'] > 0) {
                        $_SESSION['MAIL'] = $userinfo['MAIL'];

                        $_SESSION['id'] = $userinfo['id'];

                        $error = '<div class="alert alert-success"><p><strong><i class="fas fa-check-circle"></i></strong> Successful connection ! You will be redirected</p></div><meta http-equiv="REFRESH" content="1;url=?page=home">';

                        $update = $bdd->prepare("UPDATE `" . $_Config_['Database']['table_prefix'] . "_members` SET `LAST_LOGIN`= NOW() WHERE id = ?");
                        $update->execute(array($userinfo['id']));
                    } else {

                        $error = '<div class="alert alert-danger"><p><strong><i class="fas fa-exclamation-circle text-danger"></i></strong> Please very your email with the link we sent you. Check your spams !</p></div>';
                    }
                } else {

                    $error = '<div class="alert alert-danger"><p><strong><i class="fas fa-exclamation-circle text-danger"></i></strong> Your account is currently banned from our website.</p></div>';
                }
            } else {
                $error = '<div class="alert alert-danger"><p><strong><i class="fas fa-exclamation-circle text-danger"></i></strong> Invalid email or password !</p></div>';
            }
        } else {

            $error = '<div class="alert alert-danger"><p><strong><i class="fas fa-exclamation-circle text-danger"></i></strong> Invalid email or password !</p></div>';
        }
    }
}
