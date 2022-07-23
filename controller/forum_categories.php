<?php

if (!(isset($_SESSION['id']))) $userrank['PERMISSION_LEVEL'] = 1;

if (isset($_GET['id'])) {
    if (!empty($_GET['id'])) {

        $sfc = $bdd->prepare("SELECT * FROM " . $_Config_['Database']['table_prefix'] . "_forum WHERE id = ?");
        $sfc->execute(array(htmlspecialchars($_GET['id'])));


        if ($sfc->rowCount() > 0) {

            while ($cat = $sfc->fetch()) {
                if ($userrank['PERMISSION_LEVEL'] >= $cat['PERMISSION_SEE_LEVEL']) {
                    $pagetitle = strtoupper($cat['NAME']);
                    $permission_write_levelhere = $cat['PERMISSION_WRITE_LEVEL'];
                    $permission_see_levelhere = $cat['PERMISSION_SEE_LEVEL'];
                } else {
                    header("Location: ?page=error.404");
                }
            }
        } else {
            header("Location: ?page=error.404");
        }
    } else {
        header("Location: ?page=error.404");
    }
} else {
    header("Location: ?page=error.404");
}

$listpinnedmessage = $bdd->prepare("SELECT * FROM " . $_Config_['Database']['table_prefix'] . "_topics WHERE FORUM_ID = ? AND PINNED = 'on'");
$listpinnedmessage->execute(array(htmlspecialchars($_GET['id'])));

$listcategory = $bdd->prepare("SELECT * FROM " . $_Config_['Database']['table_prefix'] . "_topics WHERE FORUM_ID = ? AND PINNED IS NULL");
$listcategory->execute(array(htmlspecialchars($_GET['id'])));

if (isset($_SESSION['id'])) {
    if (isset($_POST['post_topic'])) {

        if (isset($_POST['content']) and !empty($_POST['content']) and isset($_POST['name']) and !empty($_POST['name'])) {


            $timestamp = time();
            $datemtn = date("Y-m-d H:i:s", $timestamp);



            $create = $bdd->prepare("INSERT INTO `" . $_Config_['Database']['table_prefix'] . "_topics`(`USER_ID`, `DATE_CREATION`, `STATUT`, `FORUM_ID`, `NAME`) VALUES (?,?,?,?,?)");
            $create->execute(array($userinfo['id'], $datemtn, 0, htmlspecialchars($_GET['id']), htmlspecialchars($_POST['name'])));

            $cfi = $bdd->query("SELECT * FROM `" . $_Config_['Database']['table_prefix'] . "_topics` WHERE DATE_CREATION = '" . $datemtn . "'");
            $cfi = $cfi->fetch();

            $insert = $bdd->prepare("INSERT INTO `" . $_Config_['Database']['table_prefix'] . "_messages`(`USER_ID`, `CONTENT`, `DATE_POST`, `TOPIC_ID`, `FORUM_ID`) VALUES (?,?,NOW(),?,?)");
            $insert->execute(array($userinfo['id'], $_POST['content'], $cfi['id'], htmlspecialchars($_GET['id'])));

            $laf = $bdd->prepare("SELECT * FROM " . $_Config_['Database']['table_prefix'] . "_follow WHERE TYPE = 'FORUM' AND SPACE_ID = ?");
            $laf->execute(array(htmlspecialchars($_GET['id'])));
            if ($laf->rowCount() > 0) {

                while ($p = $laf->fetch()) {

                    $iinl = $bdd->prepare("INSERT INTO `" . $_Config_['Database']['table_prefix'] . "_notifications`(`USER_ID`, `READ_STATUS`, `TYPE`, `HTML_CONTENT`, `NOTIF_USERAVATAR`) VALUES (?,?,?,?,?)");
                    $iinl->execute(array($p['id'], 0, "new_topic", $userinfo['NAMETAG'] . " opened the discussion \"<a href='?page=topic&id=" . $cfi['id'] . "'>LOL</a>\" dans ce forum", $userinfo['AVATAR_PATH']));
                }
            }

            header("Location: ?page=topic&id=" . $cfi['id'] . "");
        } else {
            $error = "<div class='alert alert-danger'><strong><i class='fas fa-exclamation-circle text-danger'></i></strong> Please type all fields.</div>";
        }
    }
} else {
    $error = "<div class='alert alert-danger'><strong><i class='fas fa-exclamation-circle text-danger'></i></strong> You cannot create a topic if you are not logged in</div>";
}

if (isset($_POST['follow'])) {
    if (isset($_SESSION['id'])) {
        $lfff = $bdd->prepare("SELECT * FROM " . $_Config_['Database']['table_prefix'] . "_follow WHERE TYPE = 'FORUM' AND SPACE_ID = ? AND USER_ID = ?");
        $lfff->execute(array(htmlspecialchars($_GET['id']), $userinfo['id']));
        $lfff = $lfff->rowCount();

        if ($lfff > 0) {
            $del_follow = $bdd->prepare("DELETE FROM " . $_Config_['Database']['table_prefix'] . "_follow WHERE USER_ID = ?");
            $del_follow->execute(array($userinfo['id']));
        } else {
            $add_follow = $bdd->prepare("INSERT INTO `" . $_Config_['Database']['table_prefix'] . "_follow`(`USER_ID`, `TYPE`, `SPACE_ID`) VALUES (?,?,?)");
            $add_follow->execute(array($userinfo['id'], "forum", htmlspecialchars($_GET['id'])));
        }
        header("Location: ?page=home");
    }
}

