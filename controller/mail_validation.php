<?php

// Cette section est temporairement désactivée
// This section is temporary disabled

/*
if(isset($_GET['code']) AND !empty($_GET['code'])){

    $cfc = $bdd->prepare("SELECT * FROM ".$_Config_['Database']['table_prefix']."_emailcode WHERE CODE = ?");
    $cfc->execute(array(htmlspecialchars($_GET['code'])));

    if($cfc->rowCount() > 0){
        $error = "<div class='alert alert-success'><strong><i class='fas fa-exclamation-circle text-success'></i></strong> Please wait... We are preparing your account...</div>";
        
        $cfc = $cfc->fetch();

        $valid = $bdd->prepare("UPDATE ".$_Config_['Database']['table_prefix']."_members SET STATUS = 1 WHERE MAIL = ?");
        $valid->execute(array($cfc['USER_MAIL']));

        $delete = $bdd->prepare("DELETE FROM ".$_Config_['Database']['table_prefix']."_emailcode WHERE CODE = ?");
    	$delete->execute(array(htmlspecialchars($_GET['code'])));

        echo '<meta http-equiv="refresh" content="2;URL=?page=login">';

    }else{
        $error = "<div class='alert alert-danger'><strong><i class='fas fa-exclamation-circle text-danger'></i></strong> Verification code is invalid.</div>";
        echo '<meta http-equiv="refresh" content="5;URL=?page=login">';
    }

}else{
    $error = "<div class='alert alert-danger'><strong><i class='fas fa-exclamation-circle text-danger'></i></strong> Verification code is invalid.</div>";
        echo '<meta http-equiv="refresh" content="5;URL=?page=login">';
}
*/
?>