<?php
if (isset($userinfo['id'])) {
	if (isset($_POST['edit_profile'])) {
		if ($_Config_['Additional']['avatar_upload'] == 'true') {
			if (isset($_FILES['avatar']) and !empty($_FILES['avatar']['name'])) {
				$tailleMax = 2097152;
				$extensionsValides = array('jpg', 'jpeg', 'gif', 'png');
				if ($_FILES['avatar']['size'] <= $tailleMax) {
					$extensionUpload = strtolower(substr(strrchr($_FILES['avatar']['name'], '.'), 1));
					if (in_array($extensionUpload, $extensionsValides)) {
						$chemin = "themes/uploaded/profiles/" . $_SESSION['id'] . "." . $extensionUpload;
						$resultat = move_uploaded_file($_FILES['avatar']['tmp_name'], $chemin);
						if ($resultat) {
							$updateavatar = $bdd->prepare('UPDATE ' . $_Config_['Database']['table_prefix'] . '_members SET AVATAR_PATH = :avatar WHERE id = :id');
							$updateavatar->execute(array(
								'avatar' => $_SESSION['id'] . "." . $extensionUpload,
								'id' => $_SESSION['id']
							));
							$error = '<div class="alert alert-success"><p><strong><i class="fas fa-check-circle"></i></strong> Your profile has been edited with success !</p></div><meta http-equiv="REFRESH" content="1;url=?page=account&subpage=change_photo">';
						} else {
							$error = "<div class='alert alert-danger'><strong><i class='fas fa-exclamation-circle text-danger'></i></strong> Error importing your profile picture</div>";
						}
					} else {
						$error = "<div class='alert alert-danger'><strong><i class='fas fa-exclamation-circle text-danger'></i></strong> Your profile picture must be in jpg, jpeg, gif or png format</div>";
					}
				} else {
					$error = "<div class='alert alert-danger'><strong><i class='fas fa-exclamation-circle text-danger'></i></strong> Your profile picture must not exceed 2MB</div>";
				}
			}
		} else {
			$error = "<div class='alert alert-danger'><strong><i class='fas fa-exclamation-circle text-danger'></i></strong> This action has been cancelled because forum's owner has disabled it.</div>";
		}
	}

	if (isset($_POST['delete_avatar'])) {
		$updateuser = $bdd->prepare('UPDATE ' . $_Config_['Database']['table_prefix'] . '_members SET AVATAR_PATH = ? WHERE id = ?');
		$updateuser->execute(array("default.png", $userinfo['id']));

		$error = '<div class="alert alert-success"><p><strong><i class="fas fa-check-circle"></i></strong> Your avatar has been resetting with success !</p></div><meta http-equiv="REFRESH" content="1;url=?page=account&subpage=home">';
	}

	if (isset($_POST['edit_signature'])) {



		$updateuser = $bdd->prepare('UPDATE ' . $_Config_['Database']['table_prefix'] . '_members SET SIGNATURE = ? WHERE id = ?');
		$updateuser->execute(array($_POST['signature'], $userinfo['id']));

		$error = '<div class="alert alert-success"><p><strong><i class="fas fa-check-circle"></i></strong> Your signature has been edited with success !</p></div><meta http-equiv="REFRESH" content="1;url=?page=account&subpage=signature">';
	}


	if (isset($_POST['edit_account'])) {

		if (isset($_POST['description']) and isset($_POST['nametag'])) {

			if (empty($_POST['description'])) {
				$description = "No description given";
			} else {
				$description = htmlspecialchars($_POST['description']);
			}
			$nametag = $_POST['nametag'];

			if ($_Config_['Additional']['nametag_change'] == "true") {
				$updateuser = $bdd->prepare('UPDATE ' . $_Config_['Database']['table_prefix'] . '_members SET NAMETAG = ? WHERE id = ?');
				$updateuser->execute(array($_POST['nametag'], $userinfo['id']));
			}

			$updateuser = $bdd->prepare('UPDATE ' . $_Config_['Database']['table_prefix'] . '_members SET ABOUT = ? WHERE id = ?');
			$updateuser->execute(array($_POST['description'], $userinfo['id']));


			if (empty($_POST['github'])) {
				$_POST['github'] = "";
			}
			if (empty($_POST['discord'])) {
				$_POST['discord'] = "";
			}
			if (empty($_POST['twitter'])) {
				$_POST['twitter'] = "";
			}
			if (empty($_POST['website'])) {
				$_POST['website'] = "";
			}

			if (isset($_POST['github'])) {

				$update = $bdd->prepare("UPDATE `" . $_Config_['Database']['table_prefix'] . "_members` SET `GITHUB`= ? WHERE id = ?");
				$update->execute(array(htmlspecialchars($_POST['github']), $userinfo['id']));
			}
			if (isset($_POST['discord'])) {

				$update = $bdd->prepare("UPDATE `" . $_Config_['Database']['table_prefix'] . "_members` SET `DISCORD`= ? WHERE id = ?");
				$update->execute(array(htmlspecialchars($_POST['discord']), $userinfo['id']));
			}
			if (isset($_POST['twitter'])) {

				$update = $bdd->prepare("UPDATE `" . $_Config_['Database']['table_prefix'] . "_members` SET `TWITTER`= ? WHERE id = ?");
				$update->execute(array(htmlspecialchars($_POST['twitter']), $userinfo['id']));
			}
			if (isset($_POST['website'])) {

				$update = $bdd->prepare("UPDATE `" . $_Config_['Database']['table_prefix'] . "_members` SET `WEBSITE`= ? WHERE id = ?");
				$update->execute(array(htmlspecialchars($_POST['website']), $userinfo['id']));
			}

			$error = '<div class="alert alert-success"><p><strong><i class="fas fa-check-circle"></i></strong> Your profile has been edited with success !</p></div><meta http-equiv="REFRESH" content="1;url=?page=account&subpage=edit">';
		} else {
			$error = "<div class='alert alert-danger'><strong><i class='fas fa-exclamation-circle text-danger'></i></strong> Please enter all fields.</div>";
		}
	}
}
