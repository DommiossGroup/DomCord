<?php

$memberslist = $bdd->query("SELECT * FROM ".$_Config_['Database']['table_prefix']."_members");
$stafflist = $bdd->query("SELECT * FROM ".$_Config_['Database']['table_prefix']."_members");

if(isset($_GET['type'])){
    if($_GET['type'] == "staff"){
        $page = "staff";
    }else{
        $page = "user";
    }
}else{
    $page = "user";
}


?>