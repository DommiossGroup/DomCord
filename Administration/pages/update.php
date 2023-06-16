<?php

$pagetitle = "Check for update";
include("assets/includes/header.php");

if ($userrank["SUPERADMIN"] !== "on") {
	echo '<meta http-equiv="refresh" content="0;URL=?page=error.403">';
} else {
	$data = file_get_contents("https://api.dommioss.fr/domcord/download/last_update.json");
	$obj = json_decode($data);

	$datacontentupdate = file_get_contents("https://api.dommioss.fr/domcord/latest_update_content.php");

	if (isset($_GET['action']) and $_GET['action'] == "update_latest_version") {
		if ($userrank["SUPERADMIN"] == "on") {
			$updating = true;



			// Database update
			$json = file_get_contents($obj[1]->updateurlsql);
			$tab = json_decode($json);
			if (!$json) {
				foreach ($tab as $item) {
					if (isset($item->command)) {
						$SQL = $bdd->query(str_replace('dc', $_Config_['Database']['table_prefix'], $item->command));
						unset($SQL);
					}
				}
			}

			// ZIP update
			$path2 = "../"; // There is where the ZIPPED FILE will be download on the SERVER
			$filename = $obj[1]->dl_filename;
			$error = "Downloading " . $filename . "...";

			file_put_contents($filename, fopen($obj[1]->dlurl, 'r'));
			$error = "Downloading " . $filename . "...<br><b><i class='fas fa-check text-success'></i></b>Downloaded " . $filename . " succefully";
			$error = "Downloading " . $filename . "...<br><b><i class='fas fa-check text-success'></i></b>Downloaded " . $filename . " succefully<br>Unzipping " . $filename . "...";

			$zip = new ZipArchive;
			$res = $zip->open($filename);

			if ($res === TRUE) {
				$error = "Downloading " . $filename . "...<br><b><i class='fas fa-check text-success'></i></b>Downloaded " . $filename . " succefully<br>Unzipping " . $filename . "...<br><b><i class='fas fa-check text-success'></i></b>Unzipped " . $filename . " succefully<br><b><i class='fas fa-check text-success'></i></b>Wait 5 seconds until redirection";
				$zip->extractTo($path2);
				$zip->close();
				unlink($filename);


				function delete_files($dir)
				{
					if (is_dir($dir)) {
						$objects = scandir($dir);
						foreach ($objects as $object) {
							if ($object != "." && $object != "..") {
								if (filetype($dir . "/" . $object) == "dir")
									delete_files($dir . "/" . $object);
								else unlink($dir . "/" . $object);
							}
						}
						reset($objects);
						rmdir($dir);
					}
				}
				delete_files("../installation");

				$editionconfig['General']['name'] = $_Config_['General']['name'];
				$editionconfig['General']['language'] = $_Config_['General']['language'];
				$editionconfig['General']['theme'] = $_Config_['General']['theme'];
				$editionconfig['General']['description'] = $_Config_['General']['description'];
				$editionconfig['General']['staff_permission_level'] = $_Config_['General']['staff_permission_level'];
				$editionconfig['version'] = $obj[0]->version;
				$editionconfig['developper_mod'] = $_Config_['developper_mod'];
				$editionconfig['Metadata']['keywords'] = $_Config_['Metadata']['keywords'];
				$editionconfig['Metadata']['robots'] = $_Config_['Metadata']['robots'];
				$editionconfig['Security']['max_account_per_ip'] = $_Config_['Security']['max_account_per_ip'];
				$editionconfig['Database']['table_prefix'] = $_Config_['Database']['table_prefix'];

				$editionconfig['Additional']['nametag_change'] = $_Config_['Additional']['nametag_change'];
				$editionconfig['Additional']['birthday_display'] = $_Config_['Additional']['birthday_display'];
				$editionconfig['Additional']['email_display'] = $_Config_['Additional']['email_display'];
				$editionconfig['Additional']['avatar_upload'] = $_Config_['Additional']['avatar_upload'];

				$editionconfig = new Write('../config/config.yml', $editionconfig);


				echo "<meta http-equiv='refresh' content='0;URL=?page=update'>";
			} else {
				$error = "FILES EXTRACTION FAILED, CONTACT SUPPORT";
			}
		} else {
			echo '<meta http-equiv="refresh" content="0;URL=?page=error.403">';
			die();
		}
	}


	if (isset($updating)) {
		if ($updating == true) {
			$updating = false;
		}
	} else {
		$updating = false;
	}
}

?>

<!-- Main Content -->
<div class="section-body">
	<h2 class="section-title">Check for update</h2>
	<?php if ($updating !== true) { ?>
		<div class="row">
			<div class="col-6">
				<div class="card card-hero">
					<div class="card-header">
						<div class="card-icon">
							<i class="far fa-question-circle"></i>
						</div>
						<h4><?php echo $obj[0]->version; ?></h4>
						<div class="card-description">Last update published</div>
					</div>
					<div class="card-body p-0">
						<div class="tickets-list">
							<?php echo $datacontentupdate; ?>
							<a href="https://domcord.dommioss.fr/?page=changelogs" class="ticket-item ticket-more">
								View All <i class="fas fa-chevron-right"></i>
							</a>
						</div>
					</div>
				</div>
			</div>
			<div class="col-6">
				<div class="card">
					<div class="card-header">
						<h4>Update</h4>
					</div>
					<div class="card-body">

						<?php if ($obj[0]->version == $_Config_['version']) { ?>
							<div class="alert alert-success">
								<p><strong><i class="fas fa-check-circle"></i></strong> No new updates found. Your website is up to date. (<?php echo $_Config_['version']; ?>)</p>
							</div>
						<?php } else { ?>
							Version <code><?php echo $obj[0]->version; ?></code> of DomCord is available but you are on the <code><?php echo $_Config_['version']; ?></code> version. You should backup your website before updating DomCord.<br><b class="text-danger"><i class="fas fa-question-circle"></i> You always should update your website because of security reasons.</b>
						<?php } ?>
					</div>
					<div class="card-footer">
						<form method="POST">
							<div class="d-grid gap-2">
								<?php if ($obj[0]->version == $_Config_['version']) { ?>
									<button class="btn btn-success" disabled><i class="fas fa-check"></i> You are on the latest version</button>
								<?php } else { ?>
									<?php if ($userrank["SUPERADMIN"] == "on") { ?>
										<a class="btn btn-primary" href="?page=update&action=update_latest_version"><i class="fas fa-cloud-download-alt"></i> Update DomCord CMS</a>
									<?php } else { ?>
										<button class="btn btn-danger" disabled><i class="fas fa-ban"></i> Update DomCord CMS</button>
									<?php } ?>
								<?php } ?>
							</div>
						</form>
						<!-- Button trigger modal -->
					</div>
				</div>
			</div>
		</div>
	<?php } else { ?>
		<div class="row">
			<div class="col-12">
				<div class="card card-hero">
					<div class="card-header">
						<div class="card-icon">
							<i class="far fa-question-circle"></i>
						</div>
						<h4>Setting up the latest version</h4>
						<div class="card-description"><?php echo $obj[0]->version; ?> is going to be setup</div>
					</div>
					<div class="card-body p-0">
						<div class="tickets-list">
							<?php echo $error; ?>

						</div>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>
</div>
</section>
</div>