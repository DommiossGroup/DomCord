<?php

if (isset($_POST['connexion'])) {


	$mailconnexion = htmlspecialchars($_POST['mailconnexion']);

	$passwordconnexion = sha1($_POST['passwordconnexion']);



	if (!empty($mailconnexion) and !empty($passwordconnexion)) {

		$SQL = $bdd->prepare('SELECT * FROM `' . $_Config_['Database']['table_prefix'] . '_members` WHERE MAIL = ? AND PASSWORD = ?');

		$SQL->execute(array($mailconnexion, $passwordconnexion));

		$user_exist = $SQL->rowCount();

		if ($user_exist == 1) {

			$userinfo = $SQL->fetch();

			if ($passwordconnexion == $userinfo['PASSWORD']) {

				if ($userinfo['STATUS'] < 2) {
					$_SESSION['MAIL'] = $userinfo['MAIL'];

					$_SESSION['id'] = $userinfo['id'];

					$error = '<div class="alert alert-success"><p><strong><i class="fa fa-check-circle"></i></strong> Successful connection ! You will be redirected</p></div><meta http-equiv="REFRESH" content="0;url=?page=home">';
				} else {

					$error = '<div class="alert alert-danger"><p><strong><i class="fa fa-exclamation-circle text-danger"></i></strong> Your account is currently banned from our website.</p></div>';
				}
			} else {
				$error = '<div class="alert alert-danger"><p><strong><i class="fa fa-exclamation-circle text-danger"></i></strong> Invalid email or password !</p></div>';
			}
		} else {

			$error = '<div class="alert alert-danger"><p><strong><i class="fa fa-exclamation-circle text-danger"></i></strong> Invalid email or password !</p></div>';
		}
	}
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>Maintenance | DomCord</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="maintenance/images/icons/favicon.ico" />
	<link rel="stylesheet" type="text/css" href="maintenance/vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="maintenance/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="maintenance/vendor/animate/animate.css">
	<link rel="stylesheet" type="text/css" href="maintenance/vendor/select2/select2.min.css">
	<link rel="stylesheet" type="text/css" href="maintenance/css/util.css">
	<link rel="stylesheet" type="text/css" href="maintenance/css/main.css">

</head>

<body>


	<div class="size1 bg0 where1-parent">
		<!-- Coutdown -->
		<div class="flex-c-m bg-img1 size2 where1 overlay1 where2 respon2" style="background-image: url('maintenance/images/background.png');">
		</div>

		<!-- Form -->
		<div class="size3 flex-col-sb flex-w p-l-75 p-r-75 p-t-45 p-b-45 respon1">
			<div class="wrap-pic1">
				<img src="maintenance/images/icons/favicon.ico" width="25%" alt="LOGO">
			</div>

			<div class="p-t-50 p-b-60">
				<p class="s2-txt3 p-t-18">
					<?php echo $_maintenance_['message']; ?><br>
				</p>
				<form class="contact100-form validate-form" method="POST">
					<br><b>Admin login.</b>
					<div class="wrap-input100 m-b-10 validate-input" data-validate="Email is required: ex@abc.xyz">
						<input class="s2-txt1 placeholder0 input100" type="text" name="mailconnexion" placeholder="Email Adress">
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 m-b-20 validate-input" data-validate="Password is required">
						<input class="s2-txt1 placeholder0 input100" type="password" name="passwordconnexion" placeholder="Password">
						<span class="focus-input100"></span>
					</div>

					<div class="w-full">
						<button class="flex-c-m s2-txt2 size4 bg1 bor1 hov1 trans-04" type="submit" name="connexion">
							Connexion
						</button>
					</div>
				</form>
			</div>

			<div class="flex-w">
				<?php if(isset($error)) echo $error; ?>
			</div>
		</div>
	</div>





	<!--===============================================================================================-->
	<script src="maintenance/vendor/jquery/jquery-3.2.1.min.js"></script>
	<!--===============================================================================================-->
	<script src="maintenance/vendor/bootstrap/js/popper.js"></script>
	<script src="maintenance/vendor/bootstrap/js/bootstrap.min.js"></script>
	<!--===============================================================================================-->
	<script src="maintenance/vendor/select2/select2.min.js"></script>
	<!--===============================================================================================-->
	<script src="maintenance/vendor/countdowntime/moment.min.js"></script>
	<script src="maintenance/vendor/countdowntime/moment-timezone.min.js"></script>
	<script src="maintenance/vendor/countdowntime/moment-timezone-with-data.min.js"></script>
	<script src="maintenance/vendor/countdowntime/countdowntime.js"></script>
	<script>
		$('.cd100').countdown100({
			/*Set Endtime here*/
			/*Endtime must be > current time*/
			endtimeYear: 0,
			endtimeMonth: 0,
			endtimeDate: 35,
			endtimeHours: 18,
			endtimeMinutes: 0,
			endtimeSeconds: 0,
			timeZone: ""
			// ex:  timeZone: "America/New_York"
			//go to " http://momentjs.com/timezone/ " to get timezone
		});
	</script>
	<!--===============================================================================================-->
	<script src="maintenance/vendor/tilt/tilt.jquery.min.js"></script>
	<script>
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
	<!--===============================================================================================-->
	<script src="maintenance/js/main.js"></script>

</body>

</html>