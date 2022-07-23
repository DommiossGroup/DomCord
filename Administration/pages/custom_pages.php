<?php

$pagetitle = "Custom Pages";
include("assets/includes/header.php");

if ($userrank["ADMIN_PAGE_CREATE"] !== "on") {
  echo '<meta http-equiv="refresh" content="0;URL=?page=error.403">';
  die();
} else {


  if (isset($_GET['action']) and $_GET['action'] == "delete_page") {

    if (isset($_GET['pageid']) and !empty($_GET['pageid'])) {

      $dban = $bdd->prepare("DELETE FROM `" . $_Config_['Database']['table_prefix'] . "_pages` WHERE id = ?");
      $dban->execute(array(htmlspecialchars($_GET['pageid'])));
      echo '<meta http-equiv="refresh" content="0;URL=?page=custom_pages">';
    }
  }


  if (isset($_POST['edit_page'])) {

    if (!empty($_POST['content']) and !empty($_POST['name'])) {

      $update = $bdd->prepare("UPDATE `" . $_Config_['Database']['table_prefix'] . "_pages` SET `NAME`= ? WHERE id = ?");
      $update->execute(array(htmlspecialchars($_POST['name']), htmlspecialchars($_GET['pageid'])));

      $update = $bdd->prepare("UPDATE `" . $_Config_['Database']['table_prefix'] . "_pages` SET `CONTENU`= ? WHERE id = ?");
      $update->execute(array($_POST['content'], htmlspecialchars($_GET['pageid'])));

      $error = '<div class="alert alert-success"><strong><i class="fas fa-check-circle"></i></strong> You succeffully edited this page.</div><meta http-equiv="refresh" content="1;URL=?page=custom_pages&action=edit&pageid=' . $_GET['pageid'] . '">';
    } else {

      $error = '<div class="alert alert-danger"><strong><i class="fas fa-exclamation-circle"></i></strong> Please enter all fields.</div>';
    }
  }

  if (isset($_POST['create_page'])) {

    if (!empty($_POST['name']) and !empty($_POST['content'])) {

      if ($_POST['name'] == "account") {
        $error = "<div class='alert alert-danger'><b><i class='fas fa-exclamation-circle'></i></b> This name is reserved to DomCord system.</div>";
      } else

      if ($_POST['name'] == "banned") {
        $error = "<div class='alert alert-danger'><b><i class='fas fa-exclamation-circle'></i></b> This name is reserved to DomCord system.</div>";
      } else

      if ($_POST['name'] == "error.403") {
        $error = "<div class='alert alert-danger'><b><i class='fas fa-exclamation-circle'></i></b> This name is reserved to DomCord system.</div>";
      } else

      if ($_POST['name'] == "forum_categorie") {
        $error = "<div class='alert alert-danger'><b><i class='fas fa-exclamation-circle'></i></b> This name is reserved to DomCord system.</div>";
      } else

      if ($_POST['name'] == "home") {
        $error = "<div class='alert alert-danger'><b><i class='fas fa-exclamation-circle'></i></b> This name is reserved to DomCord system.</div>";
      } else

      if ($_POST['name'] == "login") {
        $error = "<div class='alert alert-danger'><b><i class='fas fa-exclamation-circle'></i></b> This name is reserved to DomCord system.</div>";
      } else

      if ($_POST['name'] == "register") {
        $error = "<div class='alert alert-danger'><b><i class='fas fa-exclamation-circle'></i></b> This name is reserved to DomCord system.</div>";
      } else

      if ($_POST['name'] == "members") {
        $error = "<div class='alert alert-danger'><b><i class='fas fa-exclamation-circle'></i></b> This name is reserved to DomCord system.</div>";
      } else

      if ($_POST['name'] == "profile") {
        $error = "<div class='alert alert-danger'><b><i class='fas fa-exclamation-circle'></i></b> This name is reserved to DomCord system.</div>";
      } else

      if ($_POST['name'] == "topics") {
        $error = "<div class='alert alert-danger'><b><i class='fas fa-exclamation-circle'></i></b> This name is reserved to DomCord system.</div>";
      } else {
        $path = "?page=" . strtolower(htmlspecialchars($_POST['name'])) . "";
        $path = str_replace(' ', '_', $path);

        $insert = $bdd->prepare("INSERT INTO `" . $_Config_['Database']['table_prefix'] . "_pages`(`NAME`, `PATH`, `CONTENU`) VALUES (?,?,?)");
        $insert->execute(array(htmlspecialchars($_POST['name']), $path, $_POST['content']));


        $error = "<div class='alert alert-success'><b><i class='fas fa-exclamation-circle'></i></b> Page created.</div><meta http-equiv='refresh' content='0;URL=?page=custom_pages'>";
      }
    }
  }

  if (isset($_GET['action']) and $_GET['action'] == "edit") {


    if (!empty($_GET['pageid'])) {

      $cfu = $bdd->prepare("SELECT * FROM " . $_Config_['Database']['table_prefix'] . "_pages WHERE id = ?");
      $cfu->execute(array(htmlspecialchars($_GET['pageid'])));

      if ($cfu->rowCount() == 0) {
        echo '<meta http-equiv="refresh" content="0;URL=?page=error.404">';
      }




      $pagetype = 1;
    } else {

      echo '<meta http-equiv="refresh" content="0;URL=?page=custom_pages">';
    }
  } else {

    $pagetype = 2;
    $lfb = $bdd->query("SELECT * FROM " . $_Config_['Database']['table_prefix'] . "_pages");
  }

  if ($pagetype == 2) {
?>

    <div class="section-body">
      <h2 class="section-title">Pages list
      </h2>
      <?php if (isset($error)) {
        echo $error;
      } ?>
      <div class="card">
        <div class="card-body">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">Name</th>
                <th scope="col">Path</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php while ($s = $lfb->fetch()) { ?>

                <tr>
                  <td><?php echo $s['NAME']; ?></td>
                  <td><?php echo $s['PATH']; ?></td>
                  <td><a href="../<?php echo $s['PATH']; ?>"><i class="fas fa-share text-primary"></i></a> <a href="?page=custom_pages&action=edit&pageid=<?php echo $s['id']; ?>"><i class="fas fa-edit text-primary"></i></a> <a href="?page=custom_pages&action=delete_page&pageid=<?php echo $s['id']; ?>"><i class="fas fa-ban text-danger"></i></a></td>
                </tr>

              <?php } ?>
            </tbody>
          </table>
          <hr>

        </div>
      </div>
    </div>
    <div class="section-body">
      <h2 class="section-title">Create a custom page
      </h2>
      <div class="card">
        <div class="card-body">
          <form method="POST">
            <label>Page name</label>
            <input type="text" class="form-control" name="name"><br>

            <label>Page content</label>
            <textarea id="editor1" name="content"></textarea>
            <script>
              CKEDITOR.replace('editor1');
            </script>


            <hr>
            <button type="submit" class="btn btn-primary" name="create_page"><i class="fas fa-plus"></i> Create page</button>
          </form>

        </div>
      </div>
    </div>



    </section>
    </div>
    <?php } elseif ($pagetype == 1) {

    while ($r = $cfu->fetch()) {
    ?>

      <?php if (isset($error)) {
        echo $error;
      } ?>
      <div class="section-body">
        <h2 class="section-title"><?php echo $r['NAME']; ?></h2>
        <div class="card">
          <div class="card-body">

            <form method="POST">
              <label>Page name</label>
              <input type="text" class="form-control" name="name" value="<?php echo $r['NAME']; ?>"><br>

              <label>Page content</label>
              <textarea id="editor1" name="content"><?php echo $r['CONTENU']; ?></textarea>
              <script>
                CKEDITOR.replace('editor1');
              </script>


              <hr>
              <button type="submit" class="btn btn-primary" name="edit_page"><i class="fas fa-plus"></i> Edit page</button>
            </form>


          </div>
        </div>


      </div>
      </div>
<?php }
  }
} ?>