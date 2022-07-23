<?php

$pagetitle = "Home";
include("assets/includes/header.php");

$l_members = $bdd->query("SELECT * FROM " . $_Config_['Database']['table_prefix'] . "_members");
$l_members = $l_members->rowCount();

$l_messages = $bdd->query("SELECT * FROM " . $_Config_['Database']['table_prefix'] . "_messages");
$l_messages = $l_messages->rowCount();

$s_notes = $bdd->query("SELECT * FROM " . $_Config_['Database']['table_prefix'] . "_stickynotes");
$l_notes = $s_notes->rowCount();

$c_forums = $bdd->query("SELECT * FROM " . $_Config_['Database']['table_prefix'] . "_forum");
$c_category = $bdd->query("SELECT * FROM " . $_Config_['Database']['table_prefix'] . "_category");

$l_forums = $c_forums->rowCount() + $c_category->rowCount();

$c_score = $bdd->query("SELECT * FROM " . $_Config_['Database']['table_prefix'] . "_reactions");

$l_score = 0;
while ($op = $c_score->fetch()) {


  $opl = $bdd->prepare("SELECT * FROM " . $_Config_['Database']['table_prefix'] . "_reactions_images WHERE id = ?");
  $opl->execute(array($op['REACTION_ID']));
  while ($rsc = $opl->fetch()) {

    $l_score = $l_score + $rsc['GIFT'];
  }
}

if (isset($_POST['create_new_snote'])) {

  if (!empty($_POST['snote_content'])) {

    $SQL = $bdd->prepare("INSERT INTO `" . $_Config_['Database']['table_prefix'] . "_stickynotes`(`CONTENT`, `DATE_POST`, `AUTHOR`) VALUES (?,NOW(),?)");
    $SQL->execute(array($_POST['snote_content'], $userinfo['NAMETAG']));

    echo '<meta http-equiv="refresh" content="0;URL=?page=home">';
  }
}

if (isset($_GET['action'])) {
  if ($_GET['action'] == "clearnotes") {
    if ($userrank["SUPERADMIN"] == "on") {

      $SQL = $bdd->query("TRUNCATE `" . $_Config_['Database']['table_prefix'] . "_stickynotes`");
      echo '<meta http-equiv="refresh" content="0;URL=?page=home">';
    } else {
      echo '<meta http-equiv="refresh" content="0;URL=?page=error.403">';
    }
  } else {
    echo '<meta http-equiv="refresh" content="0;URL=?page=error.403">';
  }
}

?>
<h2 class="section-title">Forum <?php echo $_Config_['General']['name']; ?></h2>
<p class="section-lead">Powered by <a href="https://domcord.dommioss.fr/">DomCord</a></p>
<div class="row">
  <div class="col-12 col-md-6 col-lg-3">
    <div class="card card-primary">
      <div class="card-header">
        <h4><?php echo $l_members; ?> Users <i class="fas fa-users"></i></h4>
      </div>
    </div>
  </div>
  <div class="col-12 col-md-6 col-lg-3">
    <div class="card card-success">
      <div class="card-header">
        <h4><?php echo $l_messages; ?> Messages <i class="fas fa-users"></i></h4>
      </div>
    </div>
  </div>
  <div class="col-12 col-md-6 col-lg-3">
    <div class="card card-dark">
      <div class="card-header">
        <h4><?php echo $l_forums; ?> Forums & Categories <i class="fas fa-users"></i></h4>
      </div>
    </div>
  </div>
  <div class="col-12 col-md-6 col-lg-3">
    <div class="card card-warning">
      <div class="card-header">
        <h4><?php echo $l_score; ?> Global react score <i class="fas fa-trophy"></i></h4>
      </div>
    </div>
  </div>
  <div class="col-12 col-md-6 col-lg-3">
    <div class="card card-danger">
      <div class="card-header">
        <h4>PhP V<?php echo phpversion(); ?> <i class="fab fa-php"></i></h4>
      </div>
    </div>
  </div>
  
    <div class="col-12 col-md-6 col-lg-3">
      <a <?php if ($userrank["SUPERADMIN"] == "on") { echo 'href="?page=license"'; } ?> class="text-white">
        <?php if ($obj->status === 0) { ?>
          <div class="card bg-primary card-white">
            <div class="card-header">

              <h4 class="text-white">Valid License <i class="fas fa-tag"></i></h4>

            </div>
          </div>
        <?php } else { ?>
          <div class="card bg-danger card-white">
            <div class="card-header">

              <h4 class="text-white">Invalid License <i class="fas fa-tag"></i></h4>

            </div>
          </div>
        <?php } ?>
      </a>
    </div>
  <div class="col-12 col-md-6 col-lg-6">
    <div class="card card-hero">
      <div class="card-header">
        <div class="card-icon">
          <i class="far fa-question-circle"></i>
        </div>
        <div class="card-description"><i class="fas fa-sticky-note"></i> Sticky notes</div>
      </div>
      <div class="card-body p-0">
        <div class="tickets-list">
          <?php while ($sn = $s_notes->fetch()) { ?>
            <a class="ticket-item">
              <div class="ticket-title">
                « <?php echo $sn['CONTENT']; ?> »
              </div>
              <div class="ticket-info">
                <div><?php echo $sn['AUTHOR']; ?></div>
                <div class="bullet"></div>
                <div><?php echo date("d/m/Y H\hi", strtotime($sn['DATE_POST'])); ?></div>
              </div>
            </a>
          <?php } ?>

          <?php if ($userrank["SUPERADMIN"] == "on") { ?>
            <?php if ($l_notes > 0) { ?>
              <a href="?page=home&action=clearnotes" class="ticket-item ticket-more text-danger">
                Delete all <i class="fas fa-chevron-right"></i>
              </a>
            <?php } ?>
          <?php } ?>

        </div>
      </div>
      <div class="card-footer">
        <form method="POST">
          <div class="input-group mb-3">
            <input type="text" class="form-control" name="snote_content" placeholder="Note content">
            <button class="btn btn-outline-secondary" name="create_new_snote" type="submit">New</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="card-header bg-whitesmoke">
  <p>You can check for update by clicking on the next button: <a href="?page=update" class="btn btn-outline-success "><i class="fas fa-wrench"></i> CHECK FOR UPDATE</a></p>
</div>
</div>