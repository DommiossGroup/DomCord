<?php

$pagetitle = "Header links";
include("assets/includes/header.php");

if ($userrank["ADMIN_MANAGE_FORUMS"] !== "on") {
  echo '<meta http-equiv="refresh" content="0;URL=?page=error.403">';
  die();
} else {


  if (isset($_POST['add_link'])) {

    if (!empty($_POST['name']) and !empty($_POST['link'])) {

      $insert = $bdd->prepare("INSERT INTO `" . $_Config_['Database']['table_prefix'] . "_header`( `NAME`, `LINK`, `ICON`) VALUES (?,?,?)");
      $insert->execute(array(htmlspecialchars($_POST['name']), htmlspecialchars($_POST['link']), htmlspecialchars($_POST['icon'])));

      $badgeerror = '<div class="alert alert-success"><strong><i class="fas fa-check-circle"></i></strong> This link has been created.</div><meta http-equiv="refresh" content="1;URL=?page=headerlinks">';
    } else {
      $badgeerror = '<div class="alert alert-danger"><strong><i class="fas fa-exclamation-circle"></i></strong> Please enter all fields.</div>';
    }
  }

  $lfb = $bdd->query("SELECT * FROM " . $_Config_['Database']['table_prefix'] . "_header");

  if (isset($_GET['action']) and $_GET['action'] == "delete_link") {

    if (isset($_GET['linkid']) and !empty($_GET['linkid'])) {

      $dban = $bdd->prepare("DELETE FROM `" . $_Config_['Database']['table_prefix'] . "_header` WHERE id = ?");
      $dban->execute(array(htmlspecialchars($_GET['linkid'])));
      echo '<meta http-equiv="refresh" content="0;URL=?page=headerlinks">';
    }
  }
}

?>

<div class="section-body">
  <h2 class="section-title">Links list
  </h2>
  <div class="card">
    <div class="card-body">
      <table class="table">
        <thead>
          <tr>
            <th scope="col">Content</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($s = $lfb->fetch()) { ?>
            <tr>
              <td><i class='<?php echo $s['ICON']; ?>'></i> <?php echo $s['NAME']; ?></td>
              <td><a href="?page=headerlinks&action=delete_link&linkid=<?php echo $s['id']; ?>"><i class="fas fa-ban text-danger"></i></a></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>

    </div>
  </div>
</div>

<div class="section-body">
  <h2 class="section-title">Create link
  </h2>
  <div class="card">
    <div class="card-body">

      <?php if (isset($badgeerror)) {
        echo $badgeerror;
      } ?>
      <form method="POST">
        <label>Link Name</label>
        <input class="form-control" type="text" name="name" placeholder="Ex: Important"><br>
        <label>Fontawesome icon</label>
        <input class="form-control" type="text" name="icon" placeholder="Ex: fas fa-sitemap"><br>
        <label>Link</label>
        <input class="form-control" type="text" name="link" placeholder="Ex: ?page=home"><br>
        <br>
        <button class="btn btn-primary" type="submit" name="add_link"><i class="fas fa-edit"></i> Create link</button>
      </form>
    </div>
  </div>
</div>


</section>
</div>