<?php

if (!(isset($_SESSION['id']))) {


    $userrank['PERMISSION_LEVEL'] = 1;
}

if (!isset($_GET['id']) or !ctype_digit($_GET['id'])) {

    echo '<meta http-equiv="refresh" content="0;URL=?page=error.404">';
    die();
}

if (isset($_SESSION['id'])) {
    if (isset($_GET['action']) and $_GET['action'] == "report") {

        if (!empty($_GET['messageid'])) {

            $cfme = $bdd->prepare("SELECT * FROM " . $_Config_['Database']['table_prefix'] . "_messages WHERE TOPIC_ID = ? AND STATUS = 0 AND id = ?");
            $cfme->execute(array(htmlspecialchars($_GET['id']), htmlspecialchars($_GET['messageid'])));

            if ($cfme->rowCount() > 0) {

                $mr = $cfme->fetch();

                $insert = $bdd->prepare("INSERT INTO `" . $_Config_['Database']['table_prefix'] . "_reports`(`AUTHOR_ID`, `REPORTED_ID`, `TOPIC_ID`, `MESSAGE_ID`, `MESSAGE_CONTENT`, `LINK`) VALUES (?,?,?,?,?,?)");
                $insert->execute(array($userinfo['id'], $mr['USER_ID'], $mr['TOPIC_ID'], $mr['id'], $mr['CONTENT'], "?page=topic&id=" . htmlspecialchars($_GET['id']) . ""));

                echo '<meta http-equiv="refresh" content="0;URL=?page=topic&id=' . htmlspecialchars($_GET['id']) . '">';
                die();
            } else {
                echo '<meta http-equiv="refresh" content="0;URL=?page=topic&id=' . htmlspecialchars($_GET['id']) . '">';
                die();
            }
        }
    } elseif (isset($_GET['action']) and $_GET['action'] == "react") {
        if (!empty($_GET['messageid']) and !empty($_GET['reactionid'])) {

            if (isset($_SESSION['id'])) {
                $messageinfo = $bdd->prepare("SELECT * FROM " . $_Config_['Database']['table_prefix'] . "_messages WHERE id = ?");
                $messageinfo->execute(array(htmlspecialchars($_GET['messageid'])));
                $messageinfo = $messageinfo->fetch();


                $author = $bdd->prepare("SELECT * FROM " . $_Config_['Database']['table_prefix'] . "_members WHERE id = ?");
                $author->execute(array(htmlspecialchars($messageinfo['USER_ID'])));
                $author = $author->fetch();

                if ($author['id'] != $userinfo['id']) {

                    $cfrfm = $bdd->prepare("SELECT * FROM " . $_Config_['Database']['table_prefix'] . "_reactions WHERE USER_ID = ? AND MESSAGE_ID = ?");
                    $cfrfm->execute(array($userinfo['id'], htmlspecialchars($_GET['message_id'])));

                    if ($cfrfm->rowCount() == 0) {
                        $insert = $bdd->prepare("INSERT INTO `" . $_Config_['Database']['table_prefix'] . "_reactions`(`MESSAGE_ID`, `USER`, `POSTER_ID`, `REACTION_ID`, `USER_ID`) VALUES (?,?,?,?,?)");
                        $insert->execute(array(htmlspecialchars($_GET['messageid']), $userinfo['NAMETAG'], $messageinfo['USER_ID'], htmlspecialchars($_GET['reactionid']), $userinfo['id']));
                    } else {
                        $update = $bdd->prepare("UPDATE `" . $_Config_['Database']['table_prefix'] . "_reactions` SET `REACTION_ID`=? WHERE MESSAGE_ID = ?");
                        $update->execute(array(htmlspecialchars($_GET['reactionid']), htmlspecialchars($_GET['messageid'])));
                    }
                    echo '<meta http-equiv="refresh" content="0;URL=?page=topic&id=' . htmlspecialchars($_GET['id']) . '">';
                    die();
                } else {
                    echo '<meta http-equiv="refresh" content="0;URL=?page=topic&id=' . htmlspecialchars($_GET['id']) . '">';
                    die();
                }
            } else {

                echo '<meta http-equiv="refresh" content="0;URL=?page=topic&id=' . htmlspecialchars($_GET['id']) . '">';
                die();
            }
        } else {

            echo '<meta http-equiv="refresh" content="0;URL=?page=topic&id=' . htmlspecialchars($_GET['id']) . '">';
            die();
        }
    }

    if ($userrank['MESSAGE_DELETE'] == "on") {

        if (isset($_GET['action']) and $_GET['action'] == "delete") {

            if (!empty($_GET['messageid'])) {

                $cfme = $bdd->prepare("SELECT * FROM " . $_Config_['Database']['table_prefix'] . "_messages WHERE TOPIC_ID = ? AND STATUS = 0 AND id = ?");
                $cfme->execute(array(htmlspecialchars($_GET['id']), htmlspecialchars($_GET['messageid'])));

                if ($cfme->rowCount() > 0) {

                    $mr = $cfme->fetch();

                    $insert = $bdd->prepare("UPDATE `" . $_Config_['Database']['table_prefix'] . "_messages` SET `STATUS`='1' WHERE `id`=?");
                    $insert->execute(array($mr['id']));

                    echo '<meta http-equiv="refresh" content="0;URL=?page=topic&id=' . htmlspecialchars($_GET['id']) . '">';
                    die();
                } else {
                    echo '<meta http-equiv="refresh" content="0;URL=?page=topic&id=' . htmlspecialchars($_GET['id']) . '">';
                    die();
                }
            }
        }


        if (isset($_GET['action']) and $_GET['action'] == "repost") {

            if (!empty($_GET['messageid'])) {

                $cfme = $bdd->prepare("SELECT * FROM " . $_Config_['Database']['table_prefix'] . "_messages WHERE TOPIC_ID = ? AND STATUS = 1 AND id = ?");
                $cfme->execute(array(htmlspecialchars($_GET['id']), htmlspecialchars($_GET['messageid'])));

                if ($cfme->rowCount() > 0) {

                    $mr = $cfme->fetch();

                    $insert = $bdd->prepare("UPDATE `" . $_Config_['Database']['table_prefix'] . "_messages` SET `STATUS`='0' WHERE `id`=?");
                    $insert->execute(array($mr['id']));

                    echo '<meta http-equiv="refresh" content="0;URL=?page=topic&id=' . htmlspecialchars($_GET['id']) . '">';
                    die();
                } else {
                    echo '<meta http-equiv="refresh" content="0;URL=?page=topic&id=' . htmlspecialchars($_GET['id']) . '">';
                    die();
                }
            }
        }
    }
}

if (isset($_GET['id'])) {
    if (!empty($_GET['id'])) {
        $sfc = $bdd->prepare("SELECT * FROM " . $_Config_['Database']['table_prefix'] . "_topics WHERE id = ?");
        $sfc->execute(array(htmlspecialchars($_GET['id'])));
        $sfcnb = $sfc->rowCount();
        $sfc = $sfc->fetch();
        $pagetitle = $sfc['NAME'];

        if ($sfcnb > 0) {

            $lom = $bdd->prepare("SELECT * FROM " . $_Config_['Database']['table_prefix'] . "_messages WHERE TOPIC_ID = ? "); // List of messages
            $lom->execute(array($sfc['id'])); // List of messages


            $cfp = $bdd->prepare("SELECT * FROM " . $_Config_['Database']['table_prefix'] . "_forum WHERE id = ?");
            $cfp->execute(array(htmlspecialchars($sfc['FORUM_ID'])));
            $cfp = $cfp->fetch();


            $bf = $bdd->prepare("SELECT * FROM " . $_Config_['Database']['table_prefix'] . "_badges WHERE id = ?");
            $bf->execute(array($sfc['BADGE_ID']));
            $bf = $bf->fetch();

            if (isset($bf) and !empty($bf)) $topic_badge_span = "<span class='" . $bf['SPAN'] . "'>" . $bf['NAME'] . "</span>";
        } else {
            header("Location: ?page=error.404");
            die();
        }
    } else {
        header("Location: ?page=error.404");
        die();
    }
} else {
    header("Location: ?page=error.404");
    die();
}


if ($cfp['PERMISSION_SEE_LEVEL'] > $userrank['PERMISSION_LEVEL']) {

    header("Location: ?page=error.404");
    die();
}

if (isset($_POST['reply'])) {

    if (isset($_POST['content']) and !empty($_POST['content'])) {

        $insert = $bdd->query("INSERT INTO `" . $_Config_['Database']['table_prefix'] . "_messages`(`USER_ID`, `CONTENT`, `DATE_POST`, `TOPIC_ID`, `FORUM_ID`) VALUES (" . $userinfo['id'] . ",'" . $_POST['content'] . "',NOW()," . $sfc['id'] . "," . $sfc['FORUM_ID'] . ")");


        $error = '<div class="alert alert-success"><p><strong><i class="fas fa-check-circle"></i></strong> Your message has been sended with success !</p></div><meta http-equiv="REFRESH" content="0;url=?page=topic&id=' . htmlspecialchars($_GET['id']) . '">';
    } else {
        $error = "<div class='alert alert-danger'><strong><i class='fas fa-exclamation-circle text-danger'></i></strong> Please type a valid message.</div>";
    }
}



if (isset($userrank['ADMIN_TOPIC_EDIT']) and $userrank['ADMIN_TOPIC_EDIT'] == "on") {
    if (isset($_POST['edit_topic'])) {

        if ($userrank['ADMIN_TOPIC_EDIT'] == "on") {

            if (isset($_POST['name']) and !empty($_POST['name'])) {

                $bdd->query("UPDATE `" . $_Config_['Database']['table_prefix'] . "_topics` SET `NAME`='" . htmlspecialchars($_POST['name']) . "' WHERE id = '" . htmlspecialchars($sfc['id']) . "'");
            } else {
                $error = "<div class='alert alert-danger'><strong><i class='fas fa-exclamation-circle text-danger'></i></strong> A topic musts be named.</div>";
            }


            if ($userrank['ADMIN_TOPIC_PREFIXCHANGE'] == "on") {
                if (isset($_POST['badge'])) {

                    $bdd->query("UPDATE `" . $_Config_['Database']['table_prefix'] . "_topics` SET `BADGE_ID`='" . htmlspecialchars($_POST['badge']) . "' WHERE id = '" . htmlspecialchars($sfc['id']) . "'");
                }
            }

            if (isset($_POST['pinned']) and !empty($_POST['pinned'])) {

                $bdd->query("UPDATE `" . $_Config_['Database']['table_prefix'] . "_topics` SET `PINNED`='" . htmlspecialchars($_POST['pinned']) . "' WHERE id = '" . htmlspecialchars($sfc['id']) . "'");
            } else {
                $bdd->query("UPDATE `" . $_Config_['Database']['table_prefix'] . "_topics` SET `PINNED`= NULL WHERE id = '" . htmlspecialchars($sfc['id']) . "'");
            }

            if (isset($_POST['lock'])) {

                if ($_POST['lock'] == "on") {
                    $lock = "1";
                } else {
                    $lock = "0";
                }

                $bdd->query("UPDATE `" . $_Config_['Database']['table_prefix'] . "_topics` SET `STATUT`='" . htmlspecialchars($lock) . "' WHERE id = '" . htmlspecialchars($sfc['id']) . "'");
            } else {

                if ($_POST['lock'] == "on") {
                    $lock = "1";
                } else {
                    $lock = "0";
                }

                $bdd->query("UPDATE `" . $_Config_['Database']['table_prefix'] . "_topics` SET `STATUT`='" . htmlspecialchars($lock) . "' WHERE id = '" . htmlspecialchars($sfc['id']) . "'");
            }

            header("Location: ?page=topic&id=" . $sfc['id'] . "");
        }
    }
}
