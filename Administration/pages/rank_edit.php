<?php

$pagetitle = "Ranks";
include("assets/includes/header.php");

if ($userrank["ADMIN_RANK_EDIT"] !== "on") {
  echo '<meta http-equiv="refresh" content="0;URL=?page=error.403">';
}else{

  if (isset($_GET['id']) and !empty($_GET['id'])) {

    $lfr = $bdd->prepare("SELECT * FROM " . $_Config_['Database']['table_prefix'] . "_ranks WHERE id = ?");
    $lfr->execute(array(htmlspecialchars($_GET['id'])));

    if ($lfr->rowCount() < 1) {

      header("Location: ?page=ranks");
    }
  }


  while ($r = $lfr->fetch()) {





    if (isset($_POST['create_rank'])) {
      if (isset($_POST['name']) and !empty($_POST['name']) and isset($_POST['display']) and !empty($_POST['display']) and isset($_POST['permission_level']) and !empty($_POST['permission_level']) and isset($_POST['badge_color']) and !empty($_POST['badge_color'])) {


        $insert = $bdd->prepare("UPDATE `" . $_Config_['Database']['table_prefix'] . "_ranks` SET `NAME`=?,`DISPLAY`=?,`BADGE_COLOR`=?,`PERMISSION_LEVEL`=?,`SUPERADMIN`=?,`MAINTENANCE_MANAGE`=?,`ADMIN_BAN`=?,`MESSAGE_DELETE`=?,`ADMIN_PANELACCESS`=?,`ADMIN_WARN`=?,`ADMIN_EDIT_OTHER_MESSAGE`=?,`ADMIN_DELETE_TOPIC`=?,`ADMIN_MANAGE_FORUMS`=?,`ADMIN_MANAGE_CATEGORIES`=?,`ADMIN_PAGE_CREATE`=?,`ADMIN_TOPIC_MOVE`=?,`ADMIN_TOPIC_PREFIXCHANGE`=?,`ADMIN_RANK_EDIT`=?,`ADMIN_TOPIC_EDIT`=?,`ADMIN_THEME_EDIT`=? WHERE id = ?");

        if (empty($_POST['permission_superadmin'])) {
          $_POST['permission_superadmin'] = " ";
        }
        if (empty($_POST['permission_maintenance'])) {
          $_POST['permission_maintenance'] = " ";
        }
        if (empty($_POST['permission_ban'])) {
          $_POST['permission_ban'] = " ";
        }
        if (empty($_POST['permission_delete_message'])) {
          $_POST['permission_delete_message'] = " ";
        }
        if (empty($_POST['permission_access_panel'])) {
          $_POST['permission_access_panel'] = " ";
        }
        if (empty($_POST['permission_warn'])) {
          $_POST['permission_warn'] = " ";
        }
        if (empty($_POST['permission_edit_other_message'])) {
          $_POST['permission_edit_other_message'] = " ";
        }
        if (empty($_POST['permission_delete_topic'])) {
          $_POST['permission_delete_topic'] = " ";
        }
        if (empty($_POST['permission_admin_forums'])) {
          $_POST['permission_admin_forums'] = " ";
        }
        if (empty($_POST['permission_admin_categories'])) {
          $_POST['permission_admin_categories'] = " ";
        }
        if (empty($_POST['permission_create_page'])) {
          $_POST['permission_create_page'] = " ";
        }
        if (empty($_POST['permission_move'])) {
          $_POST['permission_move'] = " ";
        }
        if (empty($_POST['permission_prefix_discussions'])) {
          $_POST['permission_prefix_discussions'] = " ";
        }
        if (empty($_POST['permission_admin_ranks'])) {
          $_POST['permission_admin_ranks'] = " ";
        }
        if (empty($_POST['permission_moderation_tools'])) {
          $_POST['permission_moderation_tools'] = " ";
        }
        if (empty($_POST['permission_theme_edit'])) {
          $_POST['permission_theme_edit'] = " ";
        }

        if ($_POST['permission_superadmin'] == "on") {
          $_POST['permission_maintenance'] = "on";
          $_POST['permission_ban'] = "on";
          $_POST['permission_delete_message'] = "on";
          $_POST['permission_access_panel'] = "on";
          $_POST['permission_warn'] = "on";
          $_POST['permission_edit_other_message'] = "on";
          $_POST['permission_delete_topic'] = "on";
          $_POST['permission_admin_forums'] = "on";
          $_POST['permission_admin_categories'] = "on";
          $_POST['permission_create_page'] = "on";
          $_POST['permission_move'] = "on";
          $_POST['permission_prefix_discussions'] = "on";
          $_POST['permission_admin_ranks'] = "on";
          $_POST['permission_moderation_tools'] = "on";
          $_POST['permission_theme_edit'] = "on";
        }

        $insert->execute(array($_POST['name'], $_POST['display'], $_POST['badge_color'], $_POST['permission_level'], $_POST['permission_superadmin'], $_POST['permission_maintenance'], $_POST['permission_ban'], $_POST['permission_delete_message'], $_POST['permission_access_panel'], $_POST['permission_warn'], $_POST['permission_edit_other_message'], $_POST['permission_delete_topic'], $_POST['permission_admin_forums'], $_POST['permission_admin_categories'], $_POST['permission_create_page'], $_POST['permission_move'], $_POST['permission_prefix_discussions'], $_POST['permission_admin_ranks'], $_POST['permission_moderation_tools'], $_POST['permission_theme_edit'], htmlspecialchars($_GET['id'])));

        $secerror = '<div class="alert alert-success"><strong><i class="fas fa-check-circle"></i></strong> Ranks edited.</div><meta http-equiv="refresh" content="1;URL=?page=rank_edit&id=' . $_GET['id'] . '"">';
      } else {
        $secerror = '<div class="alert alert-danger"><strong><i class="fas fa-exclamation-circle"></i></strong> Ranks could not be edit. Please enter all fields.</div>';
      }
    }
?>


    <div class="section-body">
      <h2 class="section-title">Edit rank </h2>
      <div class="card">
        <div class="card-body">

          <?php if (isset($secerror)) {
            echo $secerror;
          } ?>
          <form method="POST">
            <div class="row text-center align-center">
              <div class="col-4">
                <label>Name</label>
                <input class="form-control" type="text" name="name" value="<?php echo $r['NAME']; ?>"><br>
              </div>
              <div class="col-4">
                <label>Display mode</label>
                <select class="form-control" name="display">

                  <option <?php if ($r['DISPLAY'] == "1") {
                            echo "selected";
                          } ?> value="1">Display</option>
                  <option <?php if ($r['DISPLAY'] == "0") {
                            echo "selected";
                          } ?> value="0">Do not display</option>

                </select><br>
              </div>
              <div class="col-4">
                <label>Permission level</label> <small>(Not under 1)</small>
                <input class="form-control" type="number" value="<?php echo $r['PERMISSION_LEVEL']; ?>" name="permission_level"><br>
              </div>
              <div class="col-12">
                <label>Badge background color</label>
                <select class="form-control" name="badge_color">
                  <option <?php if ($r['BADGE_COLOR'] == "bg-primary") {
                            echo "selected";
                          } ?> value="bg-primary" class="bg-primary">Primary</option>
                  <option <?php if ($r['BADGE_COLOR'] == "bg-secondary") {
                            echo "selected";
                          } ?> value="bg-secondary" class="bg-secondary">Secondary</option>
                  <option <?php if ($r['BADGE_COLOR'] == "bg-danger") {
                            echo "selected";
                          } ?> value="bg-danger" class="bg-danger">Danger</option>
                  <option <?php if ($r['BADGE_COLOR'] == "bg-warning") {
                            echo "selected";
                          } ?> value="bg-warning" class="bg-warning">Warning</option>
                  <option <?php if ($r['BADGE_COLOR'] == "bg-info") {
                            echo "selected";
                          } ?> value="bg-info" class="bg-info">Info</option>
                  <option <?php if ($r['BADGE_COLOR'] == "bg-success") {
                            echo "selected";
                          } ?> value="bg-success" class="bg-success">Success</option>
                  <option <?php if ($r['BADGE_COLOR'] == "bg-dark") {
                            echo "selected";
                          } ?> value="bg-dark" class="bg-dark">Dark</option>
                </select><br>
              </div>

              <div class="col-2">
                <label>Superadmin</label><br>
                <center><input <?php if ($r['SUPERADMIN'] == "on") {
                                  echo "checked";
                                } ?> type="checkbox" name="permission_superadmin"></center>
              </div>
              <div class="col-2">
                <label>Manage maintenance</label><br>
                <center><input <?php if ($r['MAINTENANCE_MANAGE'] == "on") {
                                  echo "checked";
                                } ?> type="checkbox" name="permission_maintenance"></center>
              </div>
              <div class="col-2">
                <label>Ban a user</label><br>
                <center><input <?php if ($r['ADMIN_BAN'] == "on") {
                                  echo "checked";
                                } ?> type="checkbox" name="permission_ban"></center>
              </div>
              <div class="col-2">
                <label>Warn a user</label><br>
                <center><input <?php if ($r['ADMIN_WARN'] == "on") {
                                  echo "checked";
                                } ?> type="checkbox" name="permission_warn"></center>
              </div>
              <div class="col-2">
                <label>Delete a message</label><br>
                <center><input <?php if ($r['MESSAGE_DELETE'] == "on") {
                                  echo "checked";
                                } ?> type="checkbox" name="permission_delete_message"></center>
              </div>
              <div class="col-2">
                <label><b class="text-danger">Access to admin panel</b></label><br>
                <center><input <?php if ($r['ADMIN_PANELACCESS'] == "on") {
                                  echo "checked";
                                } ?> type="checkbox" name="permission_access_panel"></center>
              </div>
              <div class="col-2">
                <label>Edit other messages</label><br>
                <center><input <?php if ($r['ADMIN_EDIT_OTHER_MESSAGE'] == "on") {
                                  echo "checked";
                                } ?> type="checkbox" name="permission_edit_other_message"></center>
              </div>
              <div class="col-2">
                <label>Delete topics</label><br>
                <center><input <?php if ($r['ADMIN_DELETE_TOPIC'] == "on") {
                                  echo "checked";
                                } ?> type="checkbox" name="permission_delete_topic"></center>
              </div>
              <div class="col-2">
                <label>Manage forums</label><br>
                <center><input <?php if ($r['ADMIN_MANAGE_FORUMS'] == "on") {
                                  echo "checked";
                                } ?> type="checkbox" name="permission_admin_forums"></center>
              </div>
              <div class="col-2">
                <label>Manage categories</label><br>
                <center><input <?php if ($r['ADMIN_MANAGE_CATEGORIES'] == "on") {
                                  echo "checked";
                                } ?> type="checkbox" name="permission_admin_categories"></center>
              </div>
              <div class="col-2">
                <label>Create a page</label><br>
                <center><input <?php if ($r['ADMIN_PAGE_CREATE'] == "on") {
                                  echo "checked";
                                } ?> type="checkbox" name="permission_create_page"></center>
              </div>
              <div class="col-2">
                <label>Move a topic</label><br>
                <center><input <?php if ($r['ADMIN_TOPIC_MOVE'] == "on") {
                                  echo "checked";
                                } ?> type="checkbox" name="permission_move"></center>
              </div>
              <div class="col-2">
                <label>Change topic's prefix</label><br>
                <center><input <?php if ($r['ADMIN_TOPIC_PREFIXCHANGE'] == "on") {
                                  echo "checked";
                                } ?> type="checkbox" name="permission_prefix_discussions"></center>
              </div>
              <div class="col-2">
                <label>Manage ranks</label><br>
                <center><input <?php if ($r['ADMIN_RANK_EDIT'] == "on") {
                                  echo "checked";
                                } ?> type="checkbox" name="permission_admin_ranks"></center>
              </div>
              <div class="col-2">
                <label><b class="text-info">Use moderation tools</b></label><br>
                <center><input <?php if ($r['ADMIN_TOPIC_EDIT'] == "on") {
                                  echo "checked";
                                } ?> type="checkbox" name="permission_moderation_tools"></center>
              </div>
              <div class="col-2">
                <label>Edit themes</label><br>
                <center><input <?php if ($r['ADMIN_THEME_EDIT'] == "on") {
                                  echo "checked";
                                } ?> type="checkbox" name="permission_theme_edit"></center>
              </div>



            </div>

            <button class="btn btn-primary" type="submit" name="create_rank"><i class="fas fa-edit"></i> Edit rank <small><span class="badge <?php echo $r['BADGE_COLOR']; ?> text-white"><?php echo $r['NAME']; ?></span></small></button>
        </div>


        </form>
      </div>
    </div>
    </div>


    </section>

<?php }
} ?>