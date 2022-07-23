<?php

$pagetitle = "Additional settings";
include("assets/includes/header.php");


if ($userrank["SUPERADMIN"] !== "on") {
  echo '<meta http-equiv="refresh" content="0;URL=?page=error.403">';
} else {



  if (isset($_POST['edit_favicon'])) {

    if (isset($_FILES['favicon']) and !empty($_FILES['favicon']['name'])) {
      $tailleMax = 3000000;
      $extensionsValides = array('ico');
      if ($_FILES['favicon']['size'] <= $tailleMax) {
        $extensionUpload = strtolower(substr(strrchr($_FILES['favicon']['name'], '.'), 1));
        if (in_array($extensionUpload, $extensionsValides)) {
          $chemin = "../themes/uploaded/favicon." . $extensionUpload;
          $resultat = move_uploaded_file($_FILES['favicon']['tmp_name'], $chemin);
          if ($resultat) {
            $favierror = '<div class="alert alert-success"><p><strong><i class="fas fa-check-circle"></i></strong> Your favicon has been edited with success !</p></div><meta http-equiv="REFRESH" content="1;url=?page=additional_settings">';
          } else {
            $favierror = "<div class='alert alert-danger'><strong><i class='fas fa-exclamation-circle text-danger'></i></strong> Error while importing your favicon</div>";
          }
        } else {
          $favierror = "<div class='alert alert-danger'><strong><i class='fas fa-exclamation-circle text-danger'></i></strong> Your favicon must be in <b>ico</b> format</div>";
        }
      } else {
        $favierror = "<div class='alert alert-danger'><strong><i class='fas fa-exclamation-circle text-danger'></i></strong> Your favicon must not exceed 3MB</div>";
      }
    }
  }

  if (isset($_POST['edit_additional'])) {



    $editionconfig['General']['name'] = $_Config_['General']['name'];
    $editionconfig['General']['language'] = $_Config_['General']['language'];
    $editionconfig['General']['theme'] = $_Config_['General']['theme'];
    $editionconfig['General']['description'] = $_Config_['General']['description'];
    $editionconfig['General']['staff_permission_level'] = $_Config_['General']['staff_permission_level'];
    $editionconfig['version'] = $_Config_['version'];
    $editionconfig['developper_mod'] = $_Config_['developper_mod'];
    $editionconfig['Metadata']['keywords'] = $_Config_['Metadata']['keywords'];
    $editionconfig['Metadata']['robots'] = $_Config_['Metadata']['robots'];
    $editionconfig['Security']['max_account_per_ip'] = $_Config_['Security']['max_account_per_ip'];
    $editionconfig['Database']['table_prefix'] = $_Config_['Database']['table_prefix'];


    if (empty($_POST['nametag_change'])) {
      $_POST['nametag_change'] = "false";
    } else {
      $_POST['nametag_change'] = "true";
    }
    if (empty($_POST['birthday_display'])) {
      $_POST['birthday_display'] = "false";
    } else {
      $_POST['birthday_display'] = "true";
    }
    if (empty($_POST['email_display'])) {
      $_POST['email_display'] = "false";
    } else {
      $_POST['email_display'] = "true";
    }
    if (empty($_POST['avatar_upload'])) {
      $_POST['avatar_upload'] = "false";
    } else {
      $_POST['avatar_upload'] = "true";
    }

    $editionconfig['Additional']['nametag_change'] = $_POST['nametag_change'];
    $editionconfig['Additional']['birthday_display'] = $_POST['birthday_display'];
    $editionconfig['Additional']['email_display'] = $_POST['email_display'];
    $editionconfig['Additional']['avatar_upload'] = $_POST['avatar_upload'];

    $editionconfig = new Write('../config/config.yml', $editionconfig);

    $generror = '<div class="alert alert-success"><strong><i class="fas fa-check-circle"></i></strong> Settings have been edited successfully.</div><meta http-equiv="refresh" content="1;URL=?page=additional_settings">';
  }
}

?>

<div class="section-body">
  <h2 class="section-title">Additional Settings</h2>
  <div class="card">
    <div class="card-body">
      <?php if (isset($generror)) {
        echo $generror;
      } ?>
      <form method="POST">
        <label>Users can change their nametag</label>
        <input class="checkbox" type="checkbox" name="nametag_change" <?php if (isset($_Config_['Additional']['nametag_change']) and $_Config_['Additional']['nametag_change'] == "true") {
                                                                        echo "checked";
                                                                      } ?>><br>

        <label>Display birth dates</label>
        <input class="checkbox" type="checkbox" name="birthday_display" <?php if (isset($_Config_['Additional']['birthday_display']) and $_Config_['Additional']['birthday_display'] == "true") {
                                                                          echo "checked";
                                                                        } ?>><br>

        <label>Display email addresses</label>
        <input class="checkbox" type="checkbox" name="email_display" <?php if (isset($_Config_['Additional']['email_display']) and $_Config_['Additional']['email_display'] == "true") {
                                                                        echo "checked";
                                                                      } ?>><br>

        <label>Allow users to upload an avatar</label>
        <input class="checkbox" type="checkbox" name="avatar_upload" <?php if (isset($_Config_['Additional']['avatar_upload']) and $_Config_['Additional']['avatar_upload'] == "true") {
                                                                        echo "checked";
                                                                      } ?>><br>


        <br>
        <button class="btn btn-primary" type="submit" name="edit_additional"><i class="fas fa-edit"></i> Edit</button>
      </form>
    </div>
  </div>
</div>
<div class="section-body">
  <h2 class="section-title">Edit favicon</h2>
  <div class="card">
    <div class="card-body">
      <?php if (isset($favierror)) {
        echo $favierror;
      } ?>
      <form method="POST" enctype="multipart/form-data">
        <label>Profile icon</label> <small>(Max. 3 Mb)</small>
        <input type="file" name="favicon" class="form-control">

        <br>
        <button class="btn btn-primary" type="submit" name="edit_favicon"><i class="fas fa-edit"></i> Edit</button>
      </form>
    </div>
  </div>
</div>



</section>
</div>