<?php

$pagetitle = "Categories";
include("assets/includes/header.php");

if($userrank["ADMIN_MANAGE_CATEGORIES"] !== "on"){ echo '<meta http-equiv="refresh" content="0;URL=?page=error.403">'; die(); }else{



if(isset($_POST['add_forum'])){

  if(!empty($_POST['name'])){

    if(empty($_POST['order'])){ $_POST['order'] = "0"; }

    $insert = $bdd->prepare("INSERT INTO `".$_Config_['Database']['table_prefix']."_category`( `NAME`, `ORDER_LISTING`) VALUES (?,?)");
    $insert->execute(array(htmlspecialchars($_POST['name']), $_POST['order']));
    
    $error = '<div class="alert alert-success"><strong><i class="fas fa-check-circle"></i></strong> This category has been created.</div><meta http-equiv="refresh" content="1;URL=?page=categories">';

  }else{
    $error = '<div class="alert alert-danger"><strong><i class="fas fa-exclamation-circle"></i></strong> Please enter all fields.</div>';
  }

}

if(isset($_POST['deletecategory'])){

  $del = $bdd->prepare("DELETE FROM `".$_Config_['Database']['table_prefix']."_category` WHERE id = ?");
  $del->execute(array($_GET['categoryid']));
  echo '<meta http-equiv="refresh" content="0;URL=?page=categories">';

}


if(isset($_GET['action']) AND $_GET['action'] == "edit"){


  if(!empty($_GET['categoryid'])){

    $cfu = $bdd->prepare("SELECT * FROM ".$_Config_['Database']['table_prefix']."_category WHERE id = ?");
    $cfu->execute(array(htmlspecialchars($_GET['categoryid'])));

    if($cfu->rowCount() == 0){ echo '<meta http-equiv="refresh" content="0;URL=?page=error.404">'; }





    $pagetype = 1;



	if(isset($_POST['edit_category'])){

		if(!empty($_POST['name']) AND !empty($_POST['order'])){


			if(empty($_POST['icon'])){ $_POST['icon'] = ""; }
			if(empty($_POST['permission_see_level'])){ $_POST['permission_see_level'] = "0"; }
			if(empty($_POST['permission_write_level'])){ $_POST['permission_write_level'] = "0"; }

			$ins = $bdd->prepare("UPDATE `".$_Config_['Database']['table_prefix']."_category` SET `NAME`= ? WHERE id = ?");
			$ins->execute(array($_POST['name'], htmlspecialchars($_GET['categoryid'])));

			$ins = $bdd->prepare("UPDATE `".$_Config_['Database']['table_prefix']."_category` SET `ICON`= ? WHERE id = ?");
			$ins->execute(array($_POST['icon'], htmlspecialchars($_GET['categoryid'])));

			$ins = $bdd->prepare("UPDATE `".$_Config_['Database']['table_prefix']."_category` SET `PERMISSION_WRITE_LEVEL`= ? WHERE id = ?");
			$ins->execute(array($_POST['permission_write_level'], htmlspecialchars($_GET['categoryid'])));

			$ins = $bdd->prepare("UPDATE `".$_Config_['Database']['table_prefix']."_category` SET `PERMISSION_SEE_LEVEL`= ? WHERE id = ?");
			$ins->execute(array($_POST['permission_see_level'], htmlspecialchars($_GET['categoryid'])));

			$ins = $bdd->prepare("UPDATE `".$_Config_['Database']['table_prefix']."_category` SET `ORDER_LISTING`= ? WHERE id = ?");
			$ins->execute(array($_POST['order'], htmlspecialchars($_GET['categoryid'])));

			$error = '<div class="alert alert-success"><strong><i class="fas fa-check-circle"></i></strong> You succeffully edited this category.</div><meta http-equiv="refresh" content="1;URL=?page=categories&action=edit&categoryid='.$_GET['categoryid'].'">';

		}else{
			
			$error = '<div class="alert alert-danger"><strong><i class="fas fa-exclamation-circle"></i></strong> Please enter all fields.</div>';         			
		}

	}


  }else{
    
    echo '<meta http-equiv="refresh" content="0;URL=?page=categories">';
  
  }

}else{

  $pagetype = 2;
  $lfb = $bdd->query("SELECT * FROM ".$_Config_['Database']['table_prefix']."_category ORDER BY ORDER_LISTING DESC");

}

if($pagetype == 2){
?>


          <div class="section-body">
            <h2 class="section-title">Categories list</h2>
            <div class="card">
              <div class="card-body">
                <table class="table">
                  <thead>
                    <tr>
                      <th scope="col">Name</th>
                      <th scope="col">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php while($s = $lfb->fetch()){ ?>

                      <tr>
                        <td><?php echo $s['NAME']; ?></td>
                        <td><a href="?page=categories&action=edit&categoryid=<?php echo $s['id']; ?>"><i class="fas fa-edit text-primary"></i></a></td>
                      </tr>

                    <?php } ?>
                  </tbody>
                </table>

              </div>
            </div>
          </div>


          <div class="section-body">
            <h2 class="section-title">Create a category
</h2>
            <div class="card">
              <div class="card-body">

              <?php if(isset($error)){ echo $error; } ?>
                <form method="POST">
                  <label>Category Name</label>
                  <input class="form-control" type="text" name="name" placeholder="Ex: Announcements"><br>
                  <label>Order number</label>
                  <input class="form-control" type="number" name="order" value="0"><br>
                  <br>
                  <button class="btn btn-primary" type="submit" name="add_forum"><i class="fas fa-edit"></i> Create category</button>
                </form>
              </div>
            </div>
          </div>

        </section>
      </div>
<?php }elseif($pagetype == 1){ 

  while($r = $cfu->fetch()){
  ?>

<?php if(isset($error)){ echo $error; } ?>
          <div class="section-body">
            <h2 class="section-title"><?php echo $r['NAME']; ?></h2>
            <div class="card">
              <div class="card-body">
                
                <div class="row">

                  <div class="col-12">

                    <b>CATEGORY EDITION</b><br><br>
                      <div class="row">

                          <div class="col-7"><form method="POST">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" value="<?php echo $r['NAME']; ?>"><br>

                            <label>Order number</label>
                            <input type="number" class="form-control" required="" name="order" value="<?php echo $r['ORDER_LISTING']; ?>"><br>
                            
                            
                            <label>Icon</label>
                            <input type="text" class="form-control" name="icon" value="<?php echo $r['ICON']; ?>"><br>
                            
                            <label>Permission write level</label>
                            <input type="number" class="form-control" name="permission_write_level" value="<?php echo $r['PERMISSION_WRITE_LEVEL']; ?>"><br>
                            
                            <label>Permission see level</label>
                            <input type="number" class="form-control" name="permission_see_level" value="<?php echo $r['PERMISSION_SEE_LEVEL']; ?>"><br>

                            <button type="submit" class="btn btn-primary" name="edit_category"><i class="fas fa-edit"></i> Edit</button>
                            
                          </form></div>  
                          <div class="col-5">
                            
                          <div class="d-grid gap-2"><label>Action(s)</label><form method="post"><button type="submit" class="btn btn-danger btn-sm" name="deletecategory"><i class="fas fa-portrait"></i> Delete category</button></form></div>
                          </div>
                            
                      </div>
                    

                  </div>

                </div></div></div>

              </div>
            </div>
  <?php }}} ?>