<?php

$pagetitle = "Forums";
include("assets/includes/header.php");

if ($userrank["ADMIN_MANAGE_CATEGORIES"] !== "on") {
    echo '<meta http-equiv="refresh" content="0;URL=?page=error.403">';
    die();
} else {


    if (isset($_POST['add_forum'])) {

        if (!empty($_POST['name'])) {

            if (empty($_POST['order'])) {
                $_POST['order'] = "0";
            }

            $insert = $bdd->prepare("INSERT INTO `" . $_Config_['Database']['table_prefix'] . "_forum`( `NAME`, `PARENT_ID`, `ORDER_LISTING`, `PERMISSION_WRITE_LEVEL`, `PERMISSION_SEE_LEVEL`) VALUES (?,?,?,0,0)");
            $insert->execute(array(htmlspecialchars($_POST['name']), $_POST['parent_id'], $_POST['order']));

            $error = '<div class="alert alert-success"><strong><i class="fas fa-check-circle"></i></strong> This forum has been created.</div><meta http-equiv="refresh" content="1;URL=?page=forums">';
        } else {
            $error = '<div class="alert alert-danger"><strong><i class="fas fa-exclamation-circle"></i></strong> Please enter all fields.</div>';
        }
    }



    if (isset($_POST['deletecategory'])) {



        $delAll = $bdd->prepare('DELETE FROM `' . $_Config_['Database']['table_prefix'] . '_topics` WHERE FORUM_ID = ?')->execute(array($_GET['categoryid']));
        $delAll = $bdd->prepare('DELETE FROM `' . $_Config_['Database']['table_prefix'] . '_messages` WHERE FORUM_ID = ?')->execute(array($_GET['categoryid']));

        $del = $bdd->prepare("DELETE FROM `" . $_Config_['Database']['table_prefix'] . "_forum` WHERE id = ?");
        $del->execute(array($_GET['categoryid']));
        echo '<meta http-equiv="refresh" content="0;URL=?page=forums">';
    }

    if (isset($_GET['action']) and $_GET['action'] == "edit") {


        if (!empty($_GET['categoryid'])) {

            $cfu = $bdd->prepare("SELECT * FROM " . $_Config_['Database']['table_prefix'] . "_forum WHERE id = ?");
            $cfu->execute(array(htmlspecialchars($_GET['categoryid'])));

            if ($cfu->rowCount() == 0) {
                echo '<meta http-equiv="refresh" content="0;URL=?page=error.404">';
            }





            $pagetype = 1;



            if (isset($_POST['edit_category'])) {

                if (!empty($_POST['name'])) {


                    if (empty($_POST['icon'])) {
                        $_POST['icon'] = "";
                    }
                    if (empty($_POST['order'])) {
                        $_POST['order'] = "";
                    }
                    if (empty($_POST['permission_see_level'])) {
                        $_POST['permission_see_level'] = "0";
                    }
                    if (empty($_POST['permission_write_level'])) {
                        $_POST['permission_write_level'] = "0";
                    }

                    $ins = $bdd->prepare("UPDATE `" . $_Config_['Database']['table_prefix'] . "_forum` SET `NAME`= ? WHERE id = ?");
                    $ins->execute(array($_POST['name'], htmlspecialchars($_GET['categoryid'])));

                    $ins = $bdd->prepare("UPDATE `" . $_Config_['Database']['table_prefix'] . "_forum` SET `ICON`= ? WHERE id = ?");
                    $ins->execute(array($_POST['icon'], htmlspecialchars($_GET['categoryid'])));

                    $ins = $bdd->prepare("UPDATE `" . $_Config_['Database']['table_prefix'] . "_forum` SET `DESCRIPTION`= ? WHERE id = ?");
                    $ins->execute(array($_POST['description'], htmlspecialchars($_GET['categoryid'])));

                    $ins = $bdd->prepare("UPDATE `" . $_Config_['Database']['table_prefix'] . "_forum` SET `PARENT_ID`= ? WHERE id = ?");
                    $ins->execute(array($_POST['parent_id'], htmlspecialchars($_GET['categoryid'])));

                    $ins = $bdd->prepare("UPDATE `" . $_Config_['Database']['table_prefix'] . "_forum` SET `PERMISSION_WRITE_LEVEL`= ? WHERE id = ?");
                    $ins->execute(array($_POST['permission_write_level'], htmlspecialchars($_GET['categoryid'])));

                    $ins = $bdd->prepare("UPDATE `" . $_Config_['Database']['table_prefix'] . "_forum` SET `PERMISSION_SEE_LEVEL`= ? WHERE id = ?");
                    $ins->execute(array($_POST['permission_see_level'], htmlspecialchars($_GET['categoryid'])));

                    $ins = $bdd->prepare("UPDATE `" . $_Config_['Database']['table_prefix'] . "_forum` SET `ORDER_LISTING`= ? WHERE id = ?");
                    $ins->execute(array($_POST['order'], htmlspecialchars($_GET['categoryid'])));

                    $error = '<div class="alert alert-success"><strong><i class="fas fa-check-circle"></i></strong> You succeffully edited this category.</div><meta http-equiv="refresh" content="1;URL=?page=forums&action=edit&categoryid=' . $_GET['categoryid'] . '">';
                } else {

                    $error = '<div class="alert alert-danger"><strong><i class="fas fa-exclamation-circle"></i></strong> Please enter all fields.</div>';
                }
            }
        } else {

            echo '<meta http-equiv="refresh" content="0;URL=?page=forums">';
        }
    } else {

        $pagetype = 2;
        $lfb = $bdd->query("SELECT * FROM " . $_Config_['Database']['table_prefix'] . "_forum ORDER BY ORDER_LISTING");
    }

    if ($pagetype == 2) {
?>


        <div class="section-body">
            <h2 class="section-title">Forums list</h2>
            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($s = $lfb->fetch()) { ?>

                                <tr>
                                    <td><?php echo $s['NAME']; ?></td>
                                    <td><a href="?page=forums&action=edit&categoryid=<?php echo $s['id']; ?>"><i class="fas fa-edit text-primary"></i></a></td>
                                </tr>

                            <?php } ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>



        <div class="section-body">
            <h2 class="section-title">Create a forum
            </h2>
            <div class="card">
                <div class="card-body">

                    <?php if (isset($error)) {
                        echo $error;
                    } ?>
                    <form method="POST">
                        <label>Forum Name</label>
                        <input class="form-control" type="text" name="name" placeholder="Ex: Announcements"><br>
                        <label>Order number</label>
                        <input class="form-control" type="number" name="order" value="0"><br>
                        <label>Parent category</label>
                        <select class="form-control" name="parent_id">



                            <?php
                            $cfu = $bdd->query("SELECT * FROM " . $_Config_['Database']['table_prefix'] . "_category ORDER BY ORDER_LISTING");

                            while ($y = $cfu->fetch()) {

                            ?>

                                <option value="<?php echo $y['id']; ?>"><?php echo $y['NAME']; ?></option>

                            <?php } ?>
                        </select><br>
                        <br>
                        <button class="btn btn-primary" type="submit" name="add_forum"><i class="fas fa-edit"></i> Create forum</button>
                    </form>
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
                <h2 class="section-title"><?php echo $r['NAME']; ?></h2>
                <div class="card">
                    <div class="card-body">

                        <div class="row">

                            <div class="col-12">

                                <b>FORUM EDITION</b><br><br>
                                <div class="row">

                                    <div class="col-7">
                                        <form method="POST">
                                            <label>Name</label>
                                            <input type="text" class="form-control" name="name" value="<?php echo $r['NAME']; ?>"><br>

                                            <label>Description</label>
                                            <input type="text" class="form-control" name="description" value="<?php echo $r['DESCRIPTION']; ?>"><br>

                                            <label>Order number</label>
                                            <input type="number" class="form-control" required="" name="order" value="<?php echo $r['ORDER_LISTING']; ?>"><br>

                                            <label>Parent category</label>
                                            <select class="form-control" name="parent_id">



                                                <?php
                                                $cfu = $bdd->query("SELECT * FROM " . $_Config_['Database']['table_prefix'] . "_category ORDER BY ORDER_LISTING");

                                                while ($y = $cfu->fetch()) {

                                                ?>

                                                    <option <?php if ($y['id'] == $r['PARENT_ID']) {
                                                                echo "selected";
                                                            } ?> value="<?php echo $y['id']; ?>"><?php echo $y['NAME']; ?></option>

                                                <?php } ?>
                                            </select>

                                            <label>Icon</label>
                                            <input type="text" class="form-control" name="icon" value="<?php echo $r['ICON']; ?>"><br>

                                            <label>Permission write level</label>
                                            <input type="number" class="form-control" name="permission_write_level" value="<?php echo $r['PERMISSION_WRITE_LEVEL']; ?>"><br>

                                            <label>Permission see level</label>
                                            <input type="number" class="form-control" name="permission_see_level" value="<?php echo $r['PERMISSION_SEE_LEVEL']; ?>"><br>

                                            <button type="submit" class="btn btn-primary" name="edit_category"><i class="fas fa-edit"></i> Edit</button>

                                        </form>
                                    </div>
                                    <div class="col-5">

                                        <div class="d-grid gap-2"><label>Action(s)</label>
                                            <form method="post"><button type="submit" class="btn btn-danger btn-sm" name="deletecategory"><i class="fas fa-portrait"></i> Delete forum</button></form>
                                        </div>
                                    </div>

                                </div>


                            </div>

                        </div>
                    </div>
                </div>

            </div>




            </div>
<?php }
    }
} ?>