<?php

$pagetitle = "Reports";
include("assets/includes/header.php");

if ($userrank["MESSAGE_DELETE"] !== "on") {
  echo '<meta http-equiv="refresh" content="0;URL=?page=error.403">';
  die();
}else{

  $lfb = $bdd->query("SELECT * FROM " . $_Config_['Database']['table_prefix'] . "_reports");
  $lfb2 = $bdd->query("SELECT * FROM " . $_Config_['Database']['table_prefix'] . "_reports");

  if (isset($_GET['action']) and $_GET['action'] == "delete_report" and $userrank["MESSAGE_DELETE"] == "on") {

    if (isset($_GET['reportid']) and !empty($_GET['reportid'])) {

      $dban = $bdd->prepare("DELETE FROM `" . $_Config_['Database']['table_prefix'] . "_reports` WHERE id = ?");
      $dban->execute(array(htmlspecialchars($_GET['reportid'])));
      echo '<meta http-equiv="refresh" content="0;URL=?page=reports">';
    }
  }
}


?>


<div class="section-body">
  <h2 class="section-title">Reports list
  </h2>
  <div class="card">
    <div class="card-body">
      <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">Report id</th>
            <th scope="col">Message</th>
            <th scope="col">Message author</th>
            <th scope="col">Report author</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($s = $lfb->fetch()) {


            $ra = $bdd->prepare("SELECT * FROM " . $_Config_['Database']['table_prefix'] . "_members WHERE id = ?");
            $ra->execute(array($s['REPORTED_ID']));
            $ra = $ra->fetch();

            $ma = $bdd->prepare("SELECT * FROM " . $_Config_['Database']['table_prefix'] . "_members WHERE id = ?");
            $ma->execute(array($s['AUTHOR_ID']));
            $ma = $ma->fetch();


          ?>
            <tr class="border-primary">
              <th scope="row">#<?php echo $s['id']; ?></th>
              <td><?php
                  if (strlen($s['MESSAGE_CONTENT']) >= 100) {
                    $chaine = substr($s['MESSAGE_CONTENT'], 0, 100);
                    $espace = strrpos($chaine, " ");
                    $chaine = substr($chaine, 0, $espace) . " ...";

                    echo $chaine;
                  } else {
                    echo $s['MESSAGE_CONTENT'];
                  }

                  ?></td>
              <td><?php echo $ra['NAMETAG']; ?></td>
              <td><?php echo $ma['NAMETAG']; ?></td>
              <td><a href="../<?php echo $s['LINK']; ?>"><i class="fas fa-share text-primary"></i></a> <a href="?page=reports&action=delete_report&reportid=<?php echo $s['id']; ?>"><i class="fas fa-ban text-danger"></i></a></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>

    </div>
  </div>
</div>


</section>
</div>