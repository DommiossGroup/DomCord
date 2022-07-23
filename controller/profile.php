<?php

if(isset($_GET['id'])){
    if(!empty($_GET['id'])){

        $sfc = $bdd->prepare("SELECT * FROM ".$_Config_['Database']['table_prefix']."_members WHERE id = ?");
        $sfc->execute(array(htmlspecialchars($_GET['id'])));

        if($sfc->rowCount() > 0){

            $profileinfo = $sfc->fetch();
            $profilerank = $bdd->prepare("SELECT * FROM ".$_Config_['Database']['table_prefix']."_ranks WHERE id = ?");
            $profilerank->execute(array($profileinfo['RANK_ID']));
            $profilerank = $profilerank->fetch();

            $lof = $bdd->prepare("SELECT * FROM ".$_Config_['Database']['table_prefix']."_messages WHERE USER_ID = ?"); // List of messages
            $lof->execute(array($profileinfo['id'])); // List of messages
            
            $lot = $bdd->prepare("SELECT * FROM ".$_Config_['Database']['table_prefix']."_topics WHERE USER_ID = ?"); // List of topics
            $lot->execute(array($profileinfo['id'])); // List of topics

            

            $rs = 0;
            $rl = $bdd->prepare("SELECT * FROM ".$_Config_['Database']['table_prefix']."_reactions WHERE POSTER_ID = ?");
            $rl->execute(array($profileinfo['id']));

            while($op = $rl->fetch()){
                

                $opl = $bdd->prepare("SELECT * FROM ".$_Config_['Database']['table_prefix']."_reactions_images WHERE id = ?");
                $opl->execute(array($op['REACTION_ID']));
                while($rsc = $opl->fetch()){

                    $rs = $rs + $rsc['GIFT'];


                }
            }

        }else{
            echo '<meta http-equiv="refresh" content="0;URL=?page=error.404">';
            die();
        }


    }else{
        echo '<meta http-equiv="refresh" content="0;URL=?page=error.404">';
        die();
    }
}else{
    echo '<meta http-equiv="refresh" content="0;URL=?page=error.404">';
    die();
}
