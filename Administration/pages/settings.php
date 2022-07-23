<?php

$pagetitle = "Main settings";
include("assets/includes/header.php");


if ($userrank["SUPERADMIN"] !== "on") {
  echo '<meta http-equiv="refresh" content="0;URL=?page=error.403">';
} else {
  if (isset($_POST['edit_general'])) {

    if (isset($_POST['developper_mod']) and !empty($_POST['developper_mod']) and isset($_POST['description']) and !empty($_POST['description']) and isset($_POST['name']) and !empty($_POST['name'])) {

      $editionconfig['General']['name'] = htmlspecialchars($_POST['name']);
      $editionconfig['General']['language'] = htmlspecialchars($_POST['language']);
      $editionconfig['General']['theme'] = $_Config_['General']['theme'];
      $editionconfig['General']['description'] = htmlspecialchars($_POST['description']);
      $editionconfig['General']['staff_permission_level'] = $_Config_['General']['staff_permission_level'];
      $editionconfig['version'] = $_Config_['version'];
      $editionconfig['developper_mod'] = htmlspecialchars($_POST['developper_mod']);
      $editionconfig['Metadata']['keywords'] = $_Config_['Metadata']['keywords'];
      $editionconfig['Metadata']['robots'] = $_Config_['Metadata']['robots'];
      $editionconfig['Security']['max_account_per_ip'] = $_Config_['Security']['max_account_per_ip'];
      $editionconfig['Database']['table_prefix'] = $_Config_['Database']['table_prefix'];

      $editionconfig['Additional']['nametag_change'] = $_Config_['Additional']['nametag_change'];
      $editionconfig['Additional']['birthday_display'] = $_Config_['Additional']['birthday_display'];
      $editionconfig['Additional']['email_display'] = $_Config_['Additional']['email_display'];
      $editionconfig['Additional']['avatar_upload'] = $_Config_['Additional']['avatar_upload'];

      $editionconfig = new Write('../config/config.yml', $editionconfig);

      $generror = '<div class="alert alert-success"><strong><i class="fas fa-check-circle"></i></strong> Settings have been edited successfully.</div><meta http-equiv="refresh" content="1;URL=?page=settings">';
    } else {
      $generror = '<div class="alert alert-danger"><strong><i class="fas fa-exclamation-circle"></i></strong> The parameters could not be changed. Please enter all fields.</div>';
    }
  }


  if (isset($_POST['edit_seo'])) {

    if (isset($_POST['robots']) and !empty($_POST['robots']) and isset($_POST['keywords']) and !empty($_POST['keywords'])) {


      $editionconfig['General']['name'] = $_Config_['General']['name'];
      $editionconfig['General']['language'] = $_Config_['General']['language'];
      $editionconfig['General']['theme'] = $_Config_['General']['theme'];
      $editionconfig['General']['description'] = $_Config_['General']['description'];
      $editionconfig['General']['staff_permission_level'] = $_Config_['General']['staff_permission_level'];
      $editionconfig['version'] = $_Config_['version'];
      $editionconfig['developper_mod'] = $_Config_['developper_mod'];
      $editionconfig['Metadata']['keywords'] = htmlspecialchars($_POST['keywords']);
      $editionconfig['Metadata']['robots'] = htmlspecialchars($_POST['robots']);
      $editionconfig['Security']['max_account_per_ip'] = $_Config_['Security']['max_account_per_ip'];
      $editionconfig['Database']['table_prefix'] = $_Config_['Database']['table_prefix'];

      $editionconfig['Additional']['nametag_change'] = $_Config_['Additional']['nametag_change'];
      $editionconfig['Additional']['birthday_display'] = $_Config_['Additional']['birthday_display'];
      $editionconfig['Additional']['email_display'] = $_Config_['Additional']['email_display'];
      $editionconfig['Additional']['avatar_upload'] = $_Config_['Additional']['avatar_upload'];

      $editionconfig = new Write('../config/config.yml', $editionconfig);

      $seoerror = '<div class="alert alert-success"><strong><i class="fas fa-check-circle"></i></strong> Settings have been edited successfully.</div><meta http-equiv="refresh" content="1;URL=?page=settings">';
    } else {
      $seoerror = '<div class="alert alert-danger"><strong><i class="fas fa-exclamation-circle"></i></strong> The parameters could not be changed. Please enter all fields.</div>';
    }
  }



  if (isset($_POST['edit_security'])) {

    if (isset($_POST['max_account_per_ip']) and !empty($_POST['max_account_per_ip']) and isset($_POST['staff_permission_level']) and !empty($_POST['staff_permission_level'])) {


      $editionconfig['General']['name'] = $_Config_['General']['name'];
      $editionconfig['General']['language'] = $_Config_['General']['language'];
      $editionconfig['General']['theme'] = $_Config_['General']['theme'];
      $editionconfig['General']['description'] = $_Config_['General']['description'];
      $editionconfig['General']['staff_permission_level'] = htmlspecialchars($_POST['staff_permission_level']);
      $editionconfig['version'] = $_Config_['version'];
      $editionconfig['developper_mod'] = $_Config_['developper_mod'];
      $editionconfig['Metadata']['keywords'] = $_Config_['Metadata']['keywords'];
      $editionconfig['Metadata']['robots'] = $_Config_['Metadata']['robots'];
      $editionconfig['Security']['max_account_per_ip'] = htmlspecialchars($_POST['max_account_per_ip']);
      $editionconfig['Database']['table_prefix'] = $_Config_['Database']['table_prefix'];

      $editionconfig['Additional']['nametag_change'] = $_Config_['Additional']['nametag_change'];
      $editionconfig['Additional']['birthday_display'] = $_Config_['Additional']['birthday_display'];
      $editionconfig['Additional']['email_display'] = $_Config_['Additional']['email_display'];
      $editionconfig['Additional']['avatar_upload'] = $_Config_['Additional']['avatar_upload'];

      $editionconfig = new Write('../config/config.yml', $editionconfig);

      $secerror = '<div class="alert alert-success"><strong><i class="fas fa-check-circle"></i></strong> Settings have been edited successfully.</div><meta http-equiv="refresh" content="1;URL=?page=settings">';
    } else {
      $secerror = '<div class="alert alert-danger"><strong><i class="fas fa-exclamation-circle"></i></strong> The parameters could not be changed. Please enter all fields.</div>';
    }
  }
}

?>

<div class="section-body">
  <h2 class="section-title">General Settings</h2>
  <div class="card">
    <div class="card-body">
      <?php if (isset($generror)) {
        echo $generror;
      } ?>
      <form method="POST">
        <label>Forum name</label>
        <input class="form-control" type="text" name="name" placeholder="Type a name for your forum" value="<?php echo $_Config_['General']['name']; ?>"><br>
        <label>Forum description</label>
        <input class="form-control" type="text" name="description" placeholder="Type a description for your forum" value="<?php echo $_Config_['General']['description']; ?>"><br>

        <label>Developper Mode</label>
        <select class="form-control" name="developper_mod">

          <option value="true" <?php if ($_Config_['developper_mod'] == "true") {
                                  echo "selected";
                                } ?>>Enabled</option>
          <option value="false" <?php if ($_Config_['developper_mod'] !== "true") {
                                  echo "selected";
                                } ?>>Disabled</option>

        </select><br>
        <label>Language</label>
        <select class="form-control" name="language">

        <?php

        $x = scandir("../assets/lang/");
        foreach ($x as $key => $value) {

          if ('.' !== $value && '..' !== $value) {

            if($_Config_['General']['language'] == str_replace('.php', '', $value)) $selectValue = "selected";
            if(!isset($selectValue)) $selectValue = "";

            echo "<option value='".str_replace('.php', '', $value)."' ".$selectValue.">".str_replace('.php', '', $value)."</option>";
            unset($selectValue);
          }

        }
        echo '</tbody></table>';
        ?>

        </select><br>
        <button class="btn btn-primary" type="submit" name="edit_general"><i class="fas fa-edit"></i> Edit</button>
      </form>
    </div>
  </div>
</div>

<div class="section-body">
  <h2 class="section-title">Security settings</h2>
  <div class="card">
    <div class="card-body">
      <?php if (isset($secerror)) {
        echo $secerror;
      } ?>
      <form method="POST">
        <label>Max account per ip</label>
        <input class="form-control" type="number" name="max_account_per_ip" placeholder="Max account per ip" value="<?php echo $_Config_['Security']['max_account_per_ip']; ?>"><br>

        <label>Staff permission level</label>
        <input class="form-control" type="number" name="staff_permission_level" placeholder="Staff permission level" value="<?php echo $_Config_['General']['staff_permission_level']; ?>"><br>
        <button class="btn btn-primary" type="submit" name="edit_security"><i class="fas fa-edit"></i> Edit</button>
      </form>
    </div>
  </div>
</div>

<div class="section-body">
  <h2 class="section-title">SEO settings</h2>
  <div class="card">
    <div class="card-body">
      <?php if (isset($seoerror)) {
        echo $seoerror;
      } ?>
      <form method="POST">
        <label>Keywords</label> <small>(separated by a comma)</small>
        <input class="form-control" type="text" name="keywords" placeholder="Keywords" value="<?php echo $_Config_['Metadata']['keywords']; ?>"><br>

        <label>Robots</label>
        <select class="form-control" name="robots">

          <option <?php if ($_Config_['Metadata']['robots'] == "index, follow") {
                    echo "selected";
                  } ?> value="index, follow">Index, Follow</option>
          <option <?php if ($_Config_['Metadata']['robots'] == "noindex, nofollow") {
                    echo "selected";
                  } ?> value="noindex, nofollow">Noindex, Nofollow</option>
          <option <?php if ($_Config_['Metadata']['robots'] == "index, nofollow") {
                    echo "selected";
                  } ?> value="index, nofollow">Index, Nofollow</option>
          <option <?php if ($_Config_['Metadata']['robots'] == "noindex, follow") {
                    echo "selected";
                  } ?> value="noindex, follow">Noindex, Follow</option>

        </select><br>


        <button class="btn btn-primary" type="submit" name="edit_seo"><i class="fas fa-edit"></i> Edit</button>
      </form>
    </div>
  </div>
</div>

</section>
</div>