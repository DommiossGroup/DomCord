    
        <title><?php echo $pagetitle; ?> | <?php echo $_Config_['General']['name']; ?></title>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
            <div class="container px-4">
                <a class="navbar-brand"><?php echo $_Config_['General']['name']; ?></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ms-auto">
                        <?php while($p = $headerlinks->fetch()){ ?>
                            <li class="nav-item"><a class="nav-link" href="<?php echo $p['LINK']; ?>"><i class="<?php echo $p['ICON']; ?>"></i> <?php echo $p['NAME']; ?></a></li>
                        <?php } ?>
                        
                        <?php if(isset($_SESSION['id'])){ ?>

                            <li class="nav-item dropdown">
                              <a class="nav-link" type="button" data-bs-toggle="modal" data-bs-target="#notifmodal">
                              <i class="fas fa-bell"></i>
                              <?php if(isset($nb_unread) AND $nb_unread > 0){ ?>
                              <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                <?php if(isset($nb_unread)){ echo $nb_unread; } ?>
                              </span> <?php } ?>

                              </a>                            
                            </li>
                            <li class="nav-item dropdown">
                              <a class="nav-link dropdown-toggle" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img class="rounded-circle z-depth-2" width="30" height="30" src="themes/uploaded/profiles/<?php echo $userinfo['AVATAR_PATH']; ?>" data-holder-rendered="true"> <b><?php echo $userinfo['NAMETAG']; ?></b> <div class="spinner-grow spinner-grow-sm <?php if($userinfo['STATUS'] == 0){ echo 'bg-warning'; }elseif($userinfo['STATUS'] == 1){ echo 'bg-success'; }else{ echo 'bg-danger'; } ?>" role="status"><span class="visually-hidden">Loading...</span></div>
                              </a>
                                <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
                                    <li><a class="dropdown-item" href="?page=account">My Account</a></li>
                                    <?php if(isset($userrank['ADMIN_PANELACCESS']) AND $userrank['ADMIN_PANELACCESS'] == "on"){ ?>
                                        <li><a class="dropdown-item bg-danger" href="Administration/">Admin panel</a></li>
                                    <?php } ?>
                                    <li><a class="dropdown-item" href="?action=disconnect">Logout</a></li>
                                </ul>
                            
                            </li>
                        <?php }else{ ?>
                            <li class="nav-item dropdown">
                              <a class="nav-link dropdown-toggle" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Portal
                              </a>
                              <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
                                <li><a class="dropdown-item" href="?page=login">Sign in</a></li>
                                <li><a class="dropdown-item" href="?page=register">Sign up</a></li>
                              </ul>
                            </li>

                        <?php } ?>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="modal fade" id="notifmodal" tabindex="-1" aria-labelledby="notifmodal" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Unread notifications</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <?php if(isset($_SESSION['id'])){ ?>
                <?php if(isset($notificationlist_unread) AND $notificationlist_unread->rowCount() < 1){ ?><div class="alert alert-danger"><b><i class='fas fa-bell'></i></b> You have any unread notification</div><?php } ?>
                <?php while($p = $notificationlist_unread->fetch()){ 
                                  
                                  if(!empty($p['NOTIF_USERAVATAR'])){ 
                                    if(file_exists("themes/uploaded/profiles/".$p['NOTIF_USERAVATAR'])){ 
                                      $p_avatar = "profiles/".$p['NOTIF_USERAVATAR']; 
                                    }else{ 
                                      $p_avatar = "unknown.jpg";   
                                    } 
                                  }else{ 
                                    $p_avatar = "unknown.jpg"; 
                                  }

                                ?>
                                  <li class="dropdown-item"><p style="width: 100%"><img class="rounded-circle z-depth-2" width="30" height="30" src="themes/uploaded/<?php echo $p_avatar; ?>" data-holder-rendered="true"> <?php echo $p['HTML_CONTENT']; ?></p></li>
                                <?php } ?>
                                <?php } ?>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                <a href="?page=<?php echo $page; ?>&action=markallread" class="btn btn-danger btn-sm">Mark all has read</a>
              </div>
            </div>
          </div>
        </div>