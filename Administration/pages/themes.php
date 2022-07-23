<?php

$pagetitle = "Theme settings";
include("assets/includes/header.php");

if ($userrank["ADMIN_THEME_EDIT"] !== "on") {
  echo '<meta http-equiv="refresh" content="0;URL=?page=error.403">';
} else {
  if (isset($_POST['edit_theme'])) {

    if (isset($_POST['edit_theme']) and !empty($_POST['edit_theme'])) {


      $editionconfig['General']['name'] = $_Config_['General']['name'];
      $editionconfig['General']['language'] = $_Config_['General']['language'];
      $editionconfig['General']['theme'] = htmlspecialchars($_POST['edit_theme']);
      $editionconfig['General']['description'] = $_Config_['General']['description'];
      $editionconfig['General']['staff_permission_level'] = $_Config_['General']['staff_permission_level'];
      $editionconfig['version'] = $_Config_['version'];
      $editionconfig['developper_mod'] = $_Config_['developper_mod'];
      $editionconfig['Metadata']['keywords'] = $_Config_['Metadata']['keywords'];
      $editionconfig['Metadata']['robots'] = $_Config_['Metadata']['robots'];
      $editionconfig['Security']['max_account_per_ip'] = $_Config_['Security']['max_account_per_ip'];
      $editionconfig['Database']['table_prefix'] = $_Config_['Database']['table_prefix'];

      $editionconfig = new Write('../config/config.yml', $editionconfig);

      $selecerror = '<div class="alert alert-success"><strong><i class="fas fa-check-circle"></i></strong> Theme have been edited successfully.</div><meta http-equiv="refresh" content="1;URL=?page=themes">';
    } else {
      $selecerror = '<div class="alert alert-danger"><strong><i class="fas fa-exclamation-circle"></i></strong> The theme could not be changed. Please select a valid theme.</div>';
    }
  }


  if (isset($_POST['edit_theme_settings'])) {

    if (isset($_POST['background_img']) and !empty($_POST['background_img']) and isset($_POST['text_image_color']) and !empty($_POST['text_image_color']) and isset($_POST['fontawesome']) and !empty($_POST['fontawesome']) and isset($_POST['theme_color']) and !empty($_POST['theme_color'])) {


      $editionconfig['name'] = $_ThemeOption_['name'];
      $editionconfig['full_name'] = $_ThemeOption_['full_name'];
      $editionconfig['author'] = $_ThemeOption_['author'];
      $editionconfig['description'] = $_ThemeOption_['description'];
      $editionconfig['version'] = $_ThemeOption_['version'];
      $editionconfig['ownheader'] = $_ThemeOption_['ownheader'];
      $editionconfig['ownfooter'] = $_ThemeOption_['ownfooter'];
      $editionconfig['Personnalisation']['background_img'] = htmlspecialchars($_POST['background_img']);
      $editionconfig['Personnalisation']['text_image_color'] = htmlspecialchars($_POST['text_image_color']);
      $editionconfig['Personnalisation']['fontawesome'] = htmlspecialchars($_POST['fontawesome']);
      $editionconfig['Personnalisation']['theme_color'] = htmlspecialchars($_POST['theme_color']);


      $editionconfig['Discord']['discord_server_id'] = $_ThemeOption_['Discord']['discord_server_id'];
      $editionconfig['Discord']['discord_widget'] = $_ThemeOption_['Discord']['discord_widget'];
      $editionconfig['Discord']['discord_invitation_url'] = $_ThemeOption_['Discord']['discord_invitation_url'];



      $editionconfig = new Write('../themes/' . $_Config_["General"]["theme"] . '/info.yml', $editionconfig);

      $editerror = '<div class="alert alert-success"><strong><i class="fas fa-check-circle"></i></strong> Theme have been edited successfully.</div><meta http-equiv="refresh" content="1;URL=?page=themes">';
    } else {
      $editerror = '<div class="alert alert-danger"><strong><i class="fas fa-exclamation-circle"></i></strong> The theme could not be changed. Please select a valid theme.</div>';
    }
  }

  if (isset($_POST['download_theme']) and !empty($_POST['download_theme'])) {

    $jsonsubmit = file_get_contents("https://api.dommioss.fr/domcord/theme_list.php?key=" . $_license_['license_key'] . "&domain=" . $_SERVER['HTTP_HOST'] . "&id=" . $_POST['download_theme']);
    $jsonsubmit = json_decode($jsonsubmit);


    $filename = strtolower(str_replace(' ', '-', $jsonsubmit[0]->NAME));

    file_put_contents($filename, fopen($jsonsubmit[0]->GITHUB_REPOSITORY . "/archive/refs/heads/" . $jsonsubmit[0]->BRANCH_GITHUB . ".zip", 'r'));
    $zip = new ZipArchive;
    $res = $zip->open($filename);
    if ($res === TRUE) {
      $zip->extractTo("../themes/");
      $zip->close();
      unlink($filename);

      $dlerror = "<div class='alert alert-success'><b><i class='fas fa-exclamation-circle'></i></b> Theme installed successfully, redirection</div><meta http-equiv='refresh' content='2;URL='>";
    } else {
      $dlerror = "<div class='alert alert-danger'><b><i class='fas fa-exclamation-circle'></i></b> Archive extraction failed</div>";
    }
  }
}

?>



<div class="section-body">
  <h2 class="section-title">Downloaded themes</h2>
  <div class="card">
    <div class="card-body">
      <?php if (isset($selecerror)) {
        echo $selecerror;
      } ?>

      <form method="POST">
        <?php

        echo '<table class="table table-striped table-bordered">';
        echo ' <thead>';
        echo '  <th>Name</th>';
        echo '  <th>Path</th>';
        echo '  <th>Author</th>';
        echo '  <th>Version</th>';
        echo '  <th>Actions</th>';
        echo ' </thead>';
        echo '<tbody>';
        $x = scandir("../themes");
        foreach ($x as $key => $value) {

          if ('.' !== $value && '..' !== $value && 'uploaded' !== $value) {
            $_currentthemeopion_ = new Read("../themes/" . $value . "/info.yml");
            $_currentthemeopion_ = $_currentthemeopion_->GetTableau();
            if (isset($_currentthemeopion_) and !empty($_currentthemeopion_)) {
              echo '<tr>';
              echo "<td>" . $_currentthemeopion_['name'] . "</td>";
              echo "<td><small>../themes/" . $value . "</small></td>";
              echo "<td>" . $_currentthemeopion_['author'] . "</td>";
              echo "<td>" . $_currentthemeopion_['version'] . "</td>";
              if ($value == $_Config_['General']['theme']) {
                echo '<td><button class="btn btn-primary" disabled><i class="fas fa-check-double"></i> Enabled</button></td></td>';
              } else {
                echo '<td><button type="submit" class="btn btn-success" name="edit_theme" value="' . $value . '"><i class="fas fa-check"></i> Enable</button></td></td>';
              }
              echo "</tr>";
            }
          }

          // _currentthemeopion_
        }
        echo '</tbody></table>';
        ?>
      </form>
    </div>
  </div>
</div>
<div class="section-body">
  <h2 class="section-title">Free available themes</h2>
  <div class="card">
    <div class="card-body">
      <?php if (isset($dlerror)) {
        echo $dlerror;
      } ?>
      <form method="POST">
        <?php
        $json = file_get_contents("https://api.dommioss.fr/domcord/theme_list.php?key=" . $_license_['license_key'] . "&domain=" . $_SERVER['HTTP_HOST'] . "");
        $tab = json_decode($json);
        if ($json) {
          echo '<table class="table table-striped table-bordered">';
          echo ' <thead>';
          echo '  <th>Name</th>';
          echo '  <th>Version</th>';
          echo '  <th>Actions</th>';
          echo ' </thead>';

          foreach ($tab as $item) {
            echo '<tr>';
            // Name & Official Badge
            if ($item->OFFICIAL == 1) {
              echo '<td>' . $item->NAME . ' <i class=\'fas fa-star text-warning\'></i></td>';
            } else {
              echo '<td>' . $item->NAME . '</td>';
            }
            echo '<td><span class="badge bg-primary text-white">' . $item->VERSION . '</span></td>';
            echo '<td><button type="submit" class="btn btn-success" name="download_theme" value="' . $item->id . '"><i class="fas fa-download"></i> Download</button></td>';
            echo '</tr>';
          }


          echo '</table>';
        } else {
          echo "<div class='alert alert-danger'><b><i class='fas fa-exclamation-circle'></i></b> Error while joining API</div>";
        }
        ?>
      </form>
    </div>
  </div>
</div>
<div class="section-body">
  <h2 class="section-title">Current theme settings</h2>
  <div class="card">
    <div class="card-body">
      <?php if (isset($editerror)) {
        echo $editerror;
      } ?>
      <form method="POST">
        <label>Background image</label>
        <input type="text" class="form-control" name="background_img" placeholder="Background image url" value="<?php echo $_ThemeOption_['Personnalisation']['background_img']; ?>"><br>

        <div class="row">
          <div class="col-4">
            <label>Text on image color</label>
            <select class="form-control" name="text_image_color">
              <option value="primary" class="bg-primary" <?php if ($_ThemeOption_['Personnalisation']['text_image_color'] == "primary") {
                                                            echo "selected";
                                                          } ?>>Primary</option>
              <option value="secondary" class="bg-secondary" <?php if ($_ThemeOption_['Personnalisation']['text_image_color'] == "secondary") {
                                                                echo "selected";
                                                              } ?>>Secondary</option>
              <option value="danger" class="bg-danger" <?php if ($_ThemeOption_['Personnalisation']['text_image_color'] == "danger") {
                                                          echo "selected";
                                                        } ?>>Danger</option>
              <option value="warning" class="bg-warning" <?php if ($_ThemeOption_['Personnalisation']['text_image_color'] == "warning") {
                                                            echo "selected";
                                                          } ?>>Warning</option>
              <option value="info" class="bg-info" <?php if ($_ThemeOption_['Personnalisation']['text_image_color'] == "info") {
                                                      echo "selected";
                                                    } ?>>Info</option>
              <option value="success" class="bg-success" <?php if ($_ThemeOption_['Personnalisation']['text_image_color'] == "success") {
                                                            echo "selected";
                                                          } ?>>Success</option>
              <option value="dark" class="bg-dark" <?php if ($_ThemeOption_['Personnalisation']['text_image_color'] == "dark") {
                                                      echo "selected";
                                                    } ?>>Dark</option>
              <option value="light" class="bg-light" <?php if ($_ThemeOption_['Personnalisation']['text_image_color'] == "light") {
                                                        echo "selected";
                                                      } ?>>Light</option>
            </select><br>
          </div>
          <div class="col-4">
            <label>Theme color</label>
            <select class="form-control" name="theme_color">
              <option class="bg-primary" <?php if ($_ThemeOption_['Personnalisation']['theme_color'] == "primary") {
                                            echo "selected";
                                          } ?>>Primary</option>
              <option class="bg-secondary" <?php if ($_ThemeOption_['Personnalisation']['theme_color'] == "secondary") {
                                              echo "selected";
                                            } ?>>Secondary</option>
              <option value="danger" class="bg-danger" <?php if ($_ThemeOption_['Personnalisation']['theme_color'] == "danger") {
                                                          echo "selected";
                                                        } ?>>Danger</option>
              <option value="warning" class="bg-warning" <?php if ($_ThemeOption_['Personnalisation']['theme_color'] == "warning") {
                                                            echo "selected";
                                                          } ?>>Warning</option>
              <option value="info" class="bg-info" <?php if ($_ThemeOption_['Personnalisation']['theme_color'] == "info") {
                                                      echo "selected";
                                                    } ?>>Info</option>
              <option value="success" class="bg-success" <?php if ($_ThemeOption_['Personnalisation']['theme_color'] == "success") {
                                                            echo "selected";
                                                          } ?>>Success</option>
              <option value="dark" class="bg-dark" <?php if ($_ThemeOption_['Personnalisation']['theme_color'] == "dark") {
                                                      echo "selected";
                                                    } ?>>Dark</option>
              <option value="light" class="bg-light" <?php if ($_ThemeOption_['Personnalisation']['theme_color'] == "light") {
                                                        echo "selected";
                                                      } ?>>Light</option>
            </select><br>
          </div>
          <div class="col-4">
            <label>Use fontawesome ?</label>
            <select class="form-control" name="fontawesome">
              <option value="true" <?php if ($_ThemeOption_['Personnalisation']['fontawesome'] == "true") {
                                      echo "selected";
                                    } ?>>Yes</option>
              <option value="false" <?php if ($_ThemeOption_['Personnalisation']['fontawesome'] !== "true") {
                                      echo "selected";
                                    } ?>>No</option>
            </select><br>
          </div>

          <button class="btn btn-primary" type="submit" name="edit_theme_settings"><i class="fas fa-edit"></i> Edit</button>

        </div>
      </form>
    </div>
  </div>
</div>



</section>
</div>