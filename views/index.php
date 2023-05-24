<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- CSS file for login page -->
	<link rel="stylesheet" type="text/css" href="/company.com/views/styles/index.css">

	<title>Company</title>
</head>

<body>

	<div class="main">

		<div class="login-logo">
			<h1>Login</h1>
		</div>

		<div class="login-form">
			<form action="dashboard" method="POST">

				<div>
					<label class="input-label">Email</label>
					<input name="login[mail]" class="input-box" type="text" id="mail" style="<?= $border ?>" required>
				</div>

				<div>
					<label class="input-label">Password</label>
					<input name="login[passwd]" class="input-box" type="password" id="passwd" style="<?= $border ?>" required>
				</div>

				<div>
					<input name="login[keep]" class="input-check" type="checkbox">
					<label class="check-label">Keep me logged in</label>
				</div>
				<br>
				<div>
					<button name="submit" type="submit">Access</button>
				</div>

			</form>
		</div>

		<?= $msg ?>

	</div>

</body>

</html>