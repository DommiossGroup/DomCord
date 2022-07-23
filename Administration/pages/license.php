<?php


$pagetitle = "License";
include("assets/includes/header.php");
if ($userrank["SUPERADMIN"] !== "on") {
	echo '<meta http-equiv="refresh" content="0;URL=?page=error.403">';
}


?>

<!-- Main Content -->

<div class="section-body">
	<h2 class="section-title">License</h2>
	<?php if ($_Config_['developper_mod'] !== "true") { ?>
		<div class="alert alert-danger"><b><i class="fas fa-exclamation-circle"></i></b> Please enable the developer mode to access this page.</div>
	<?php } else { ?>

		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<h4>License informations</h4>
					</div>

					<div class="card-body">
						<label for="basic-url" class="form-label">License key</label>
						<input type="text" class="form-control" readonly value="<?php echo $_license_['license_key']; ?>"><br>
						<label for="basic-url" class="form-label">License type</label>
						<input type="text" class="form-control" readonly value="<?php echo $obj->type; ?>"><br>
						<label for="basic-url" class="form-label">License status: <?php if ($obj->status === 0) {
																						echo '<span class="badge bg-success text-white">VALID</span>';
																					} else {
																						echo '<span class="badge bg-danger text-white">INVALID</span>';
																					} ?></label><br><br>

						<i class="fas fa-question-circle text-primary"></i> A license is free, but is mandatory.
					</div>

				<?php } ?>
				</section>
				</div>