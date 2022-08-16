<?php

$pagetitle = "Users";
include("assets/includes/header.php");

if ($userrank["SUPERADMIN"] !== "on") {
    echo '<meta http-equiv="refresh" content="0;URL=?page=error.403">';
    die();
}



if (isset($_POST['edit_status_account'])) {

    if (isset($_POST['status'])) {

        $update = $bdd->prepare("UPDATE `" . $_Config_['Database']['table_prefix'] . "_members` SET `STATUS`= ? WHERE id = ?");
        $update->execute(array(htmlspecialchars($_POST['status']), $_GET['memberid']));

        $error = '<div class="alert alert-success"><strong><i class="fas fa-check-circle"></i></strong> You succeffully edited this account.</div><meta http-equiv="refresh" content="1;URL=?page=users&action=edit&memberid=' . $_GET['memberid'] . '">';
    } else {

        $error = '<div class="alert alert-danger"><strong><i class="fas fa-exclamation-circle"></i></strong> Please enter all fields.</div>';
    }
}
if (isset($_POST['validateemail'])) {

    $update = $bdd->prepare("UPDATE `" . $_Config_['Database']['table_prefix'] . "_members` SET `STATUS`= 1 WHERE id = ?");
    $update->execute(array($_GET['memberid']));

    $error = '<div class="alert alert-success"><strong><i class="fas fa-check-circle"></i></strong> You succeffully edited this account.</div><meta http-equiv="refresh" content="1;URL=?page=users&action=edit&memberid=' . $_GET['memberid'] . '">';
}


if (isset($_POST['edit_rank_account'])) {

    if (isset($_POST['rank'])) {

        $update = $bdd->prepare("UPDATE `" . $_Config_['Database']['table_prefix'] . "_members` SET `RANK_ID`= ? WHERE id = ?");
        $update->execute(array(htmlspecialchars($_POST['rank']), $_GET['memberid']));

        $error = '<div class="alert alert-success"><strong><i class="fas fa-check-circle"></i></strong> You succeffully edited this account.</div><meta http-equiv="refresh" content="1;URL=?page=users&action=edit&memberid=' . $_GET['memberid'] . '">';
    } else {

        $error = '<div class="alert alert-danger"><strong><i class="fas fa-exclamation-circle"></i></strong> Please enter all fields.</div>';
    }
}
if (isset($_POST['edit_account'])) {

    if (!empty($_POST['nametag']) and !empty($_POST['mail'])) {

        $update = $bdd->prepare("UPDATE `" . $_Config_['Database']['table_prefix'] . "_members` SET `MAIL`= ? WHERE id = ?");
        $update->execute(array($_POST['mail'], $_GET['memberid']));

        $update = $bdd->prepare("UPDATE `" . $_Config_['Database']['table_prefix'] . "_members` SET `NAMETAG`= ? WHERE id = ?");
        $update->execute(array($_POST['nametag'], $_GET['memberid']));

        $error = '<div class="alert alert-success"><strong><i class="fas fa-check-circle"></i></strong> You succeffully edited this account.</div><meta http-equiv="refresh" content="1;URL=?page=users&action=edit&memberid=' . $_GET['memberid'] . '">';
    } else {

        $error = '<div class="alert alert-danger"><strong><i class="fas fa-exclamation-circle"></i></strong> Please enter all fields.</div>';
    }
}
if (isset($_POST['edit_profile_account'])) {

    if (empty($_POST['github'])) {
        $_POST['github'] = "";
    }
    if (empty($_POST['discord'])) {
        $_POST['discord'] = "";
    }
    if (empty($_POST['twitter'])) {
        $_POST['twitter'] = "";
    }
    if (empty($_POST['website'])) {
        $_POST['website'] = "";
    }

    if (isset($_POST['github'])) {

        $update = $bdd->prepare("UPDATE `" . $_Config_['Database']['table_prefix'] . "_members` SET `GITHUB`= ? WHERE id = ?");
        $update->execute(array(htmlspecialchars($_POST['github']), $_GET['memberid']));
    }
    if (isset($_POST['discord'])) {

        $update = $bdd->prepare("UPDATE `" . $_Config_['Database']['table_prefix'] . "_members` SET `DISCORD`= ? WHERE id = ?");
        $update->execute(array(htmlspecialchars($_POST['discord']), $_GET['memberid']));
    }
    if (isset($_POST['twitter'])) {

        $update = $bdd->prepare("UPDATE `" . $_Config_['Database']['table_prefix'] . "_members` SET `TWITTER`= ? WHERE id = ?");
        $update->execute(array(htmlspecialchars($_POST['twitter']), $_GET['memberid']));
    }
    if (isset($_POST['website'])) {

        $update = $bdd->prepare("UPDATE `" . $_Config_['Database']['table_prefix'] . "_members` SET `WEBSITE`= ? WHERE id = ?");
        $update->execute(array(htmlspecialchars($_POST['website']), $_GET['memberid']));
    }


    if (isset($_POST['github']) or isset($_POST['twitter']) or isset($_POST['website']) or isset($_POST['discord'])) {
        $error = '<div class="alert alert-success"><strong><i class="fas fa-check-circle"></i></strong> You succeffully edited this account.</div><meta http-equiv="refresh" content="1;URL=?page=users&action=edit&memberid=' . $_GET['memberid'] . '">';
    }
}

if (isset($_POST['edit_password_account'])) {

    if (!empty($_POST['pass']) and !empty($_POST['passVerify'])) {
        $pass1 = htmlspecialchars($_POST['pass']);
        $pass2 = htmlspecialchars($_POST['passVerify']);

        $pass = sha1($pass1);
        $passVerify = sha1($pass2);
        $passNoHash = htmlspecialchars($pass1);
        $passNoHash2 = htmlspecialchars($pass2);
        $passLenght = strlen($passNoHash);

        if ($pass1 == $pass2) {

            $update = $bdd->prepare("UPDATE `" . $_Config_['Database']['table_prefix'] . "_members` SET `PASSWORD`= ? WHERE id = ?");
            $update->execute(array($pass, $_GET['memberid']));
            $error = '<div class="alert alert-success"><strong><i class="fas fa-check-circle"></i></strong> You succeffully edited this account.</div><meta http-equiv="refresh" content="1;URL=?page=users&action=edit&memberid=' . $_GET['memberid'] . '">';
        } else {
            $error = "<div class='alert alert-danger'><b><i class='fas fa-exclamation-circle text-danger'></i></b> Passwords does not match !</div>";
        }
    } else {
        $error = '<div class="alert alert-danger"><strong><i class="fas fa-exclamation-circle"></i></strong> Please enter all fields.</div>';
    }
}





if (isset($_POST['resetavatar'])) {



    $updateuser = $bdd->prepare('UPDATE ' . $_Config_['Database']['table_prefix'] . '_members SET AVATAR_PATH = ? WHERE id = ?');
    $updateuser->execute(array("default.png", $_GET['memberid']));

    $error = '<div class="alert alert-success"><p><strong><i class="fas fa-check-circle"></i></strong> Avatar has been resetting with success !</p></div><meta http-equiv="REFRESH" content="1;url=?page=users&action=edit&memberid=' . $_GET['memberid'] . '">';
}



if (isset($_GET['action']) and $_GET['action'] == "edit") {


    if (!empty($_GET['memberid'])) {

        $cfu = $bdd->prepare("SELECT * FROM " . $_Config_['Database']['table_prefix'] . "_members WHERE id = ?");
        $cfu->execute(array(htmlspecialchars($_GET['memberid'])));

        if ($cfu->rowCount() == 0) {
            echo '<meta http-equiv="refresh" content="0;URL=?page=error.404">';
        }

        $lfr = $bdd->query("SELECT * FROM " . $_Config_['Database']['table_prefix'] . "_ranks ORDER BY PERMISSION_LEVEL DESC");



        if (isset($_POST['loginasaccount'])) {



            $SQL = $bdd->prepare("SELECT * FROM " . $_Config_['Database']['table_prefix'] . "_members WHERE id = ?");
            $SQL->execute(array(htmlspecialchars($_GET['memberid'])));
            $userinfo = $SQL->fetch();
            $_SESSION['MAIL'] = $userinfo['MAIL'];
            $_SESSION['id'] = $userinfo['id'];
            echo '<meta http-equiv="refresh" content="0;URL=../?page=home">';
        }

        $pagetype = 1;
    } else {

        echo '<meta http-equiv="refresh" content="0;URL=?page=users">';
    }
} else {

    $pagetype = 2;
    $lfb = $bdd->query("SELECT * FROM " . $_Config_['Database']['table_prefix'] . "_members");
}

if ($pagetype == 2) {
?>


    <div class="section-body">
        <h2 class="section-title">Members list
        </h2>
        <div class="card">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Nametag</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($s = $lfb->fetch()) {


                            $userinforank = $bdd->prepare("SELECT * FROM " . $_Config_['Database']['table_prefix'] . "_ranks WHERE id = ?");
                            $userinforank->execute(array($s['RANK_ID']));
                            $userinforank = $userinforank->fetch();

                        ?>

                            <tr>
                                <td>
                                    <?php if ($userinforank['PERMISSION_LEVEL'] > $_Config_['General']['staff_permission_level']) {
                                        echo '<i class="fas fa-hammer text-danger"></i>';
                                    } ?>
                                    <?php if ($userinforank['SUPERADMIN'] == "on") {
                                        echo '<i class="fas fa-crown text-warning"></i>';
                                    } ?>

                                    <?php echo $s['NAMETAG']; ?></td>
                                <td><a href="?page=users&action=edit&memberid=<?php echo $s['id']; ?>"><i class="fas fa-edit text-primary"></i></a></td>
                            </tr>

                        <?php } ?>
                    </tbody>
                </table>
                <hr><i class="fas fa-hammer text-danger"></i> Staff member | <i class="fas fa-crown text-warning"></i> Super-administrator

            </div>
        </div>
    </div>



    </section>
    </div>
    <?php } elseif ($pagetype == 1) {

    while ($r = $cfu->fetch()) {
    ?>

        <?php if (isset($error)) {
            echo $error;
        } ?>
        <div class="section-body">
            <h2 class="section-title"><img class="rounded-circle z-depth-2" width="30" height="30" src="../themes/uploaded/profiles/<?php echo $r['AVATAR_PATH']; ?>" data-holder-rendered="true"> <?php echo $r['NAMETAG']; ?></h2>
            <div class="card">
                <div class="card-body">

                    <div class="row">

                        <div class="col-6">

                            <b>ACCOUNT EDITION</b><br><br>
                            <div class="row">
                                <div class="col-7">
                                    <form method="POST">
                                        <label>Nametag</label>
                                        <input type="text" class="form-control" name="nametag" value="<?php echo $r['NAMETAG']; ?>"><br>

                                        <label>Email adress</label>
                                        <input type="email" class="form-control" required="" name="mail" value="<?php echo $r['MAIL']; ?>"><br>
                                        <button type="submit" class="btn btn-primary" name="edit_account"><i class="fas fa-edit"></i> Edit</button>

                                    </form>
                                </div>
                                <div class="col-5">

                                    <div class="d-grid gap-2"><label>Avatar</label>
                                        <form method="post"><button type="submit" class="btn btn-danger btn-sm" name="resetavatar"><i class="fas fa-portrait"></i> Reset user avatar</button></form><br>
                                        <?php if ($r['STATUS'] == 0) { ?>
                                            <label>Avatar</label>
                                            <form method="post"><button type="submit" class="btn btn-success btn-sm" name="validateemail"><i class="fas fa-check"></i> Validate user's email</button></form>
                                        <?php } ?>

                                    </div>
                                </div>

                            </div>


                        </div>
                        <div class="col-6"><b>REGISTERING INFORMATIONS</b><br><br>
                            <div class="row">
                                <div class="col-6">
                                    <label>Last connection date</label>
                                    <input type="text" class="form-control" disabled value="<?php echo date("d/m/Y H:m", strtotime($r['LAST_LOGIN'])); ?>">
                                </div>
                                <div class="col-6">
                                    <label>Registration date</label>
                                    <input type="text" class="form-control" disabled value="<?php echo date("d/m/Y", strtotime($r['DATE_CREATION'])); ?>"><br>
                                </div>
                                <div class="col-12">
                                    <label>Registration IP address</label>
                                    <input type="text" class="form-control" disabled value="<?php echo $r['IP_ADRESS']; ?>">
                                </div>
                            </div>



                        </div>

                    </div>
                </div>
            </div>

            <div class="row">

                <div class="col-6">
                    <div class="card">
                        <div class="card-body">

                            <b>ACCOUNT SECURITY</b><br><br>
                            <div class="row">
                                <div class="col-7">

                                    <form method="POST"><label>Account status</label>
                                        <div class="input-group mb-3">
                                            <select class="form-control border-primary" name="status">
                                                <option <?php if ($r['STATUS'] == "0") {
                                                            echo "selected";
                                                        } ?> value="0">Confirmation waiting</option>
                                                <option <?php if ($r['STATUS'] == "1") {
                                                            echo "selected";
                                                        } ?> value="1">Active</option>
                                                <option <?php if ($r['STATUS'] == "2") {
                                                            echo "selected";
                                                        } ?> value="2">Disabled</option>
                                            </select>
                                            <button type="submit" class="btn btn-primary" name="edit_status_account"><i class="fas fa-edit"></i> Edit</button>
                                        </div>
                                    </form><br>
                                    <form method="POST"><label>Account rank</label>
                                        <div class="input-group mb-3">
                                            <select class="form-control border-primary" name="rank">
                                                <?php while ($si = $lfr->fetch()) { ?>
                                                    <option <?php if ($r['RANK_ID'] == $si['id']) {
                                                                echo "selected";
                                                            } ?> value="<?php echo $si['id']; ?>"><?php echo $si['NAME']; ?></option>
                                                <?php } ?>
                                            </select>
                                            <button type="submit" class="btn btn-primary" name="edit_rank_account"><i class="fas fa-edit"></i> Edit</button>
                                        </div>
                                    </form>
                                </div>
                                <hr>
                                <div class="col-5">

                                    <div class="d-grid gap-2"><label>Superadmin extension</label>
                                        <form method="post"><button type="submit" class="btn btn-primary btn-sm" name="loginasaccount"><i class="fas fa-fingerprint"></i> Log in as <?php echo $r['NAMETAG']; ?></button></form>
                                    </div>
                                </div>
                                
                                <?php if(intval($_GET['memberid']) === intval($userinfo['id'])) echo '<br><div class="alert alert-warning"><b>Be careful !</b> You should not edit your own account !</div>'; ?>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">

                            <b>Password change</b><br><br>
                            <div class="row">
                                <div class="col-12">


                                    <form method="POST">
                                        <label>New password</label>
                                        <input type="password" name="pass" class="form-control border-primary"><br>
                                        <label>Confirm password</label>
                                        <input type="password" name="passVerify" class="form-control border-primary"><br>
                                        <hr>
                                        <button type="submit" class="btn btn-primary" name="edit_password_account"><i class="fas fa-edit"></i> Edit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card">


                        <div class="card-body"><b>PROFILE INFORMATIONS</b><br><br>
                            <form method="POST">
                                <label>Github</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon3">github.com/</span>
                                    <input type="text" class="form-control border-primary" name="github" value='<?php echo $r["GITHUB"]; ?>'>
                                </div>
                                <label>Discord</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon3"><i class="fab fa-discord text-primary"></i></span>
                                    <input type="text" class="form-control border-primary" name="discord" value='<?php echo $r["DISCORD"]; ?>'>
                                </div>
                                <label>Twitter</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon3">twitter.com/</span>
                                    <input type="text" class="form-control border-primary" name="twitter" value='<?php echo $r["TWITTER"]; ?>'>
                                </div>
                                <label>Website</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon3"><i class="fas fa-sitemap text-primary"></i></span>
                                    <input type="text" class="form-control border-primary" name="website" value='<?php echo $r["WEBSITE"]; ?>'>
                                </div>
                                <button type="submit" class="btn btn-primary" name="edit_profile_account"><i class="fas fa-edit"></i> Edit</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>

        </div>
        </div>
<?php }
} ?>