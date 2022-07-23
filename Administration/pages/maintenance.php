<?php

$pagetitle = "Maintenance settings";
include("assets/includes/header.php");


if ($userrank["MAINTENANCE_MANAGE"] !== "on") {
  echo '<meta http-equiv="refresh" content="0;URL=?page=error.403">';
}else{
  if (isset($_POST['edit_general'])) {

    if (isset($_POST['message']) and !empty($_POST['message']) and isset($_POST['status']) and !empty($_POST['status'])) {


      $editionconfig['message'] = htmlspecialchars($_POST['message']);
      $editionconfig['status'] = htmlspecialchars($_POST['status']);

      $editionconfig = new Write('../maintenance/maintenance.yml', $editionconfig);

      $secerror = '<div class="alert alert-success"><strong><i class="fas fa-check-circle"></i></strong> Settings have been edited successfully.</div><meta http-equiv="refresh" content="1;URL=?page=maintenance">';
    } else {
      $secerror = '<div class="alert alert-danger"><strong><i class="fas fa-exclamation-circle"></i></strong> The parameters could not be changed. Please enter all fields.</div>';
    }
  }
}

?>

<div class="section-body">
  <h2 class="section-title">Maintenance Settings</h2>
  <div class="card">
    <div class="card-body">
      <?php if ($_maintenance_['status'] == "true") { ?><div class="alert alert-danger"><strong><i class="fas fa-exclamation-circle"></i></strong> Your website is actually under maintenance.</div><?php } ?>
      <?php if ($_maintenance_['status'] !== "true") { ?><div class="alert alert-info"><strong><i class="fas fa-exclamation-circle"></i></strong> Everyone can access to your website.</div><?php } ?>

      <?php if (isset($secerror)) {
        echo $secerror;
      } ?>
      <form method="POST">
        <label>Maintenance message</label><small>(Without HTML)</small>
        <input class="form-control" type="text" name="message" value="<?php echo $_maintenance_['message']; ?>"><br>

        <label>Maintenance mode</label>
        <select class="form-control" name="status">

          <option value="true" <?php if ($_maintenance_['status'] == "true") {
                                  echo "selected";
                                } ?>>Enabled</option>
          <option value="false" <?php if ($_maintenance_['status'] !== "true") {
                                  echo "selected";
                                } ?>>Disabled</option>

        </select><br>
        <button class="btn btn-primary" type="submit" name="edit_general"><i class="fas fa-edit"></i> Edit</button>
      </form>
    </div>
  </div>
</div>


</section>
</div>