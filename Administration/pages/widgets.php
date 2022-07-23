<?php

$pagetitle = "Widgets";
include("assets/includes/header.php");

if($userrank["SUPERADMIN"] !== "on"){ echo '<meta http-equiv="refresh" content="0;URL=?page=error.403">'; } 

if(isset($_GET['edit']) AND !empty($_GET['edit'])){

  $fichier = htmlspecialchars($_GET['edit']);

  if(file_exists("../widgets/".$fichier."/info.yml")){

    if($_GET['action'] == "disable"){

      $editionconfig['enabled'] = false;
      $editionconfig = new Write('../widgets/'.$fichier.'/status.yml', $editionconfig);
      echo '<meta http-equiv="refresh" content="0;URL=?page=widgets">';

    }elseif($_GET['action'] == "enable"){

      $configedit['enabled'] = true;
      $configedit = new Write('../widgets/'.$fichier.'/status.yml', $configedit);
      echo '<meta http-equiv="refresh" content="0;URL=?page=widgets">';

    }
  }else{
    echo '<meta http-equiv="refresh" content="0;URL=?page=widgets">';
  }

}

?>

          <div class="section-body">
            <h2 class="section-title">Widgets</h2>
            <p class="section-lead"><b><i class='fas fa-exclamation-triangle text-danger'></i></b> DomCord disclaims any damage to the site caused by unofficial extensions / widgets.</p>
            <div class="card">
              <div class="card-body">
                <table class="table">
                  <thead>
                    <tr>
                      <th scope="col">NAME</th>
                      <th scope="col">AUTHOR</th>
                      <th scope="col">VERSION</th>
                      <th scope="col">ACTION</th>
                    </tr>
                  </thead>
                  <tbody>
                <?php

    $scanwidget = scandir("../widgets/");

    foreach($scanwidget as $fichier){


        if (!in_array($fichier,array(".","..", "..."))){
            if(file_exists("../widgets/".$fichier."/info.yml") AND file_exists("../widgets/".$fichier."/code.php")){
                                    
                $_widgetinfo_ = new Read("../widgets/".$fichier."/info.yml");
                $_widgetinfo_ = $_widgetinfo_->GetTableau();

                $_widgetstatus_ = new Read("../widgets/".$fichier."/status.yml");
                $_widgetstatus_ = $_widgetstatus_->GetTableau();


?>
                    <tr>
                      <th><?php if($_widgetstatus_['enabled'] == 'true'){ echo '<b class="text-success">⚈</b>'; }else{ echo '<b class="text-danger">⚈</b>'; } ?> <?php echo ucfirst($_widgetinfo_['Informations']['name']); ?></th>
                      <td><?php echo $_widgetinfo_['Informations']['author']; ?></td>
                      <td><span class='badge bg-warning'><?php echo $_widgetinfo_['Informations']['version']; ?></span></td>
                      <?php if($_widgetstatus_['enabled'] == 'true'){ ?>
                          <td><a href="?page=widgets&edit=<?php echo $fichier; ?>&action=disable" class="btn btn-danger btn-sm"><i class="fas fa-times"></i> Disable</a></td>
                      <?php }else{ ?>
                          <td><a href="?page=widgets&edit=<?php echo $fichier; ?>&action=enable" class="btn btn-success btn-sm"><i class="fas fa-check"></i> Enable</a></td>
                      <?php } ?>
                    </tr>

          
          

<?php }}} ?>
                  </tbody>
                </table>

              </div>
            </div>
          </div>
        </section>
      </div>