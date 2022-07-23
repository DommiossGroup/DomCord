<?php

$pagetitle = "Banlist";
include("assets/includes/header.php");

if ($userrank["ADMIN_BAN"] !== "on") {
  echo '<meta http-equiv="refresh" content="0;URL=?page=error.403">';
  die();
} else {


  if (isset($_POST['add_ip_ban'])) {

    if (isset($_POST['ip']) and !empty($_POST['ip']) and isset($_POST['reason']) and !empty($_POST['reason'])) {

      $insert = $bdd->prepare("INSERT INTO `" . $_Config_['Database']['table_prefix'] . "_bans_ip`( `ADRESS_IP`, `REASON`, `AUTHOR_ID`) VALUES (?,?,?)");
      $insert->execute(array(htmlspecialchars($_POST['ip']), htmlspecialchars($_POST['reason']), $userinfo['id']));

      $banerror = '<div class="alert alert-success"><strong><i class="fas fa-check-circle"></i></strong> ' . $_POST["ip"] . ' has been banned.</div><meta http-equiv="refresh" content="1;URL=?page=banlist">';
    } else {
      $banerror = '<div class="alert alert-danger"><strong><i class="fas fa-exclamation-circle"></i></strong> Please enter all fields.</div>';
    }
  }

  $lfb = $bdd->query("SELECT * FROM " . $_Config_['Database']['table_prefix'] . "_bans_ip");

  if (isset($_GET['banid']) and $_GET['action'] == "delete_ipban") {

    if (isset($_GET['banid']) and !empty($_GET['banid'])) {

      $dban = $bdd->prepare("DELETE FROM `" . $_Config_['Database']['table_prefix'] . "_bans_ip` WHERE id = ?");
      $dban->execute(array(htmlspecialchars($_GET['banid'])));
      echo '<meta http-equiv="refresh" content="0;URL=?page=banlist">';
    }
  }
}

?>

<div class="section-body">
  <h2 class="section-title">Banip listing
  </h2>
  <div class="card">
    <div class="card-body">
      <table class="table">
        <thead>
          <tr>
            <th scope="col">IP Adress</th>
            <th scope="col">Reason</th>
            <th scope="col">Author <i>(#id)</i></th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($s = $lfb->fetch()) {

            $cfa = $bdd->prepare("SELECT * FROM " . $_Config_['Database']['table_prefix'] . "_members WHERE id = ?");
            $cfa->execute(array($s['AUTHOR_ID']));
            $cfa = $cfa->fetch();

          ?>
            <tr>
              <th scope="row"><?php echo $s['ADRESS_IP']; ?></th>
              <td><?php echo $s['REASON']; ?></td>
              <td><?php echo $cfa['NAMETAG']; ?> <i>(#<?php echo $s['id']; ?>)</i></td>
              <td><a href="?page=banlist&action=delete_ipban&banid=<?php echo $s['id']; ?>"><i class="fas fa-ban text-danger"></i></a></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>

    </div>
  </div>
</div>

<div class="section-body">
  <h2 class="section-title">Ban an IP address
  </h2>
  <div class="card">
    <div class="card-body">

      <?php if (isset($banerror)) {
        echo $banerror;
      } ?>
      <form method="POST">
        <label>IP Adress</label>
        <input class="form-control" type="text" name="ip" placeholder="Ex: 127.0.0.1"><br>
        <label>Bannissement reason</label>
        <input class="form-control" type="text" name="reason" placeholder="Ex: You have violated the terms of use"><br>
        <br>
        <button class="btn btn-primary" type="submit" name="add_ip_ban"><i class="fas fa-ban"></i> Ban this IP adress</button>
      </form>
    </div>
  </div>
</div>


</section>
</div>