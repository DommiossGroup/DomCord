<?php


$pagetitle = "Debug mode";
include("assets/includes/header.php");


$data = file_get_contents("https://api.dommioss.fr/domcord/download/last_update.json");
$obj = json_decode($data);


$data2 = file_get_contents("https://api.dommioss.fr/domcord/licence_verify.php?key=" . $_license_['license_key'] . "&domain=" . $_SERVER['HTTP_HOST'] . "");
$obj2 = json_decode($data2);

?>

<!-- Main Content -->

<div class="section-body">
	<h2 class="section-title">Informations regarding configuration</h2>
	<?php if ($_Config_['developper_mod'] !== "true") { ?>
		<div class="alert alert-danger"><b><i class="fas fa-exclamation-circle"></i></b> Please enable the developer mode to access this page.</div>
	<?php } else { ?>

		<div class="row">
			<div class="col-6">
				<div class="card card-hero">
					<div class="card-header">
						<div class="card-icon">
							<i class="far fa-question-circle"></i>
						</div>
						<div class="tickets-description">Something wrong ?</div>
					</div>
					<div class="card-body p-0">
						<div class="tickets-list">
							<a href="https://docs.domcord.dommioss.fr/" class="ticket-item ticket-more">
								View knowledgebase <i class="fas fa-chevron-right"></i>
							</a>
						</div>
					</div>
				</div>
			</div>
			<div class="col-6">
				<div class="card">
					<div class="card-header">
						<h4>Configuration</h4>
					</div>

					<div class="card-body">
						<?php

						if ($obj2->status === 0) {
							$licenceStatus = "Yes";
						} else {
							$licenceStatus = "No";
						}

						echo "<i class='fas fa-paint-roller text-danger'></i> Theme folder path: <b><code>theme/" . $_Config_['General']['theme'] . "/</code></b>";
						echo "<br><i class='fas fa-paint-roller text-danger'></i> Theme author: <b>" . $_ThemeOption_['author'] . "</b>";
						echo "<br><i class='fas fa-paint-roller text-danger'></i> Theme version: <b>" . $_ThemeOption_['version'] . "</b>";
						echo "<br><i class='fas fa-paint-roller text-danger'></i> Theme displayname: <b>" . $_ThemeOption_['name'] . "</b>";
						echo "<br><i class='fas fa-paint-roller text-danger'></i> Theme full name: <b>" . $_ThemeOption_['full_name'] . "</b>";
						echo "<br><i class='fas fa-paint-roller text-danger'></i> Theme description: <b>" . $_ThemeOption_['description'] . "</b>";
						echo "<br><i class='fas fa-paint-roller text-danger'></i> Theme uses his own header: <b><code>"	. $_ThemeOption_['ownheader'] . "</code></b>";
						echo "<br><i class='fas fa-paint-roller text-danger'></i> Theme uses his own footer: <b><code>"	. $_ThemeOption_['ownfooter'] . "</code></b>";
						echo "<br><i class='fas fa-cog text-warning'></i> Forum name: <b>" . $_Config_['General']['name'] . "</b>";
						echo "<br><i class='fas fa-cog text-warning'></i> Forum description: <b>"	. $_Config_['General']['description'] . "</b>";
						echo "<br><i class='fas fa-paint-roller text-danger'></i> Current theme: <b>" . $_Config_['General']['theme'] . "</b>";
						echo "<br><i class='fab fa-google text-success'></i> Keywords: <b>" . $_Config_['Metadata']['keywords'] . "</b>";
						echo "<br><i class='fab fa-google text-success'></i> Bots: <b>" . $_Config_['Metadata']['robots'] . "</b>";
						echo "<br><i class='fas fa-exclamation-circle text-info'></i> Max. accounts per ip adress: <b>" . $_Config_['Security']['max_account_per_ip'] . "</b>";
						echo "<br><i class='fas fa-money-bill-wave text-primary'></i> License type: <b>" . $obj2->type . "</b>";
						echo "<br><i class='fas fa-money-bill-wave text-primary'></i> Is my license valid ? : <b><code>" . $licenceStatus . "</b></code>";
						echo "<br><i class='fas fa-server text-info'></i> DomCord current version : <b><code>" . $_Config_['version'] . "</b></code>"; ?>

					</div>

				<?php } ?>
				</section>
				</div>