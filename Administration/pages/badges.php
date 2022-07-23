<?php

$pagetitle = "Badges";
include("assets/includes/header.php");

if ($userrank["ADMIN_MANAGE_FORUMS"] !== "on") {
  echo '<meta http-equiv="refresh" content="0;URL=?page=error.403">';
  die();
} else {


  if (isset($_POST['add_badge'])) {

    if (isset($_POST['span']) and !empty($_POST['span']) and isset($_POST['name']) and !empty($_POST['name'])) {

      $insert = $bdd->prepare("INSERT INTO `" . $_Config_['Database']['table_prefix'] . "_badges`( `NAME`, `SPAN`) VALUES (?,?)");
      $insert->execute(array(htmlspecialchars($_POST['name']), htmlspecialchars($_POST['span'])));

      $badgeerror = '<div class="alert alert-success"><strong><i class="fas fa-check-circle"></i></strong> This badge has been created.</div><meta http-equiv="refresh" content="1;URL=?page=badges">';
    } else {
      $badgeerror = '<div class="alert alert-danger"><strong><i class="fas fa-exclamation-circle"></i></strong> Please enter all fields.</div>';
    }
  }

  $lfb = $bdd->query("SELECT * FROM " . $_Config_['Database']['table_prefix'] . "_badges");

  if (isset($_GET['action']) and $_GET['action'] == "delete_badge") {

    if (isset($_GET['badgeid']) and !empty($_GET['badgeid'])) {

      $dban = $bdd->prepare("DELETE FROM `" . $_Config_['Database']['table_prefix'] . "_badges` WHERE id = ?");
      $dban->execute(array(htmlspecialchars($_GET['badgeid'])));
      echo '<meta http-equiv="refresh" content="0;URL=?page=badges">';
    }
  }
}

?>

<div class="section-body">
  <h2 class="section-title">Badges list
  </h2>
  <div class="card">
    <div class="card-body">
      <table class="table">
        <thead>
          <tr>
            <th scope="col">Badge id</th>
            <th scope="col">Display</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($s = $lfb->fetch()) { ?>
            <tr>
              <th scope="row">#<?php echo $s['id']; ?></th>
              <td><span class='<?php echo $s['SPAN']; ?>'><?php echo $s['NAME']; ?></span></td>
              <td><a href="?page=badges&action=delete_badge&badgeid=<?php echo $s['id']; ?>"><i class="fas fa-ban text-danger"></i></a></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>

    </div>
  </div>
</div>

<div class="section-body">
  <h2 class="section-title">Create a badge
  </h2>
  <div class="card">
    <div class="card-body">

      <?php if (isset($badgeerror)) {
        echo $badgeerror;
      } ?>
      <form method="POST">
        <label>Badge Name</label>
        <input class="form-control" type="text" name="name" placeholder="Ex: Important"><br>
        <label>Badge color</label>
        <select class="form-control" name="span">
          <option value="badge bg-primary text-white" class="bg-primary">Primary</option>
          <option value="badge bg-secondary text-white" class="bg-secondary">Secondary</option>
          <option value="badge bg-danger text-white" class="bg-danger">Danger</option>
          <option value="badge bg-warning text-dark" class="bg-warning">Warning</option>
          <option value="badge bg-info text-white" class="bg-info">Info</option>
          <option value="badge bg-success text-white" class="bg-success">Success</option>
          <option value="badge bg-dark text-white" class="bg-dark">Dark</option>
          <option value="badge bg-light text-dark" class="bg-light">Light</option>
        </select><br>
        <br>
        <button class="btn btn-primary" type="submit" name="add_badge"><i class="fas fa-edit"></i> Create badge</button>
      </form>
    </div>
  </div>
</div>


</section>
</div>