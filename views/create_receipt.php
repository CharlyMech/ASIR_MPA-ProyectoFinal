<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- CSS file for login page -->
	<link rel="stylesheet" type="text/css" href="/company.com/views/styles/create_receipt.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<style type="text/css">
		body {
			background-color: darkgray;
			/* padding: 3% 15%; */
			font-family: Verdana, Geneva, Tahoma, sans-serif;
		}
	</style>
	<title>Company</title>
</head>

<body>

	<div class="header">
		<div class="home">
			<a href="dashboard" class="ahome">Dashboard</a>
		</div>
		<div class="usr">
			<button onclick="dropDown()" class="dropbtn">
				<i class="fa fa-caret-down"></i>
				<?= $_SESSION['user'] ?>
			</button>
			<div id="myDropdown" class="dropdown-content">
				<a href="./controllers/destroy.php">
					<i class="fa fa-sign-out"></i>
					Logout
				</a>
			</div>
		</div>
	</div>

	<div class="main">
		<div class="form">
			<form method="POST" action="receipts-create">
				<div class="row">
					<div class="mb-3 col-5">
						Client:
						<select name="client" class="ms-1 form-input">
							<?= $clients_opt ?>
						</select>
					</div>
					<div class="col-3 text-center fs-4">
						<strong>FA - <?= $_SESSION['receipt_id'] ?></strong>
					</div>
					<div class="col-4 text-end fs-4">
						<strong><?= date("d/m/Y") ?></strong>
					</div>
				</div>

				<div class="row">
					<div class="col-4">
						Product:
						<select name="prd" class="ms-1 form-input">
							<?= $products_opt ?>
						</select>
					</div>
					<div class="col-2">
						Provider:
						<select name='prv' class="ms-1 form-input">
							<?= $providers_opt ?>
						</select>
					</div>
					<div class="col-2">
						Qty:
						<input name="qty" type="text" class="form-input">
					</div>
					<div class="col-2">
						Dsct(%):
						<input name="dsct" type="text" class="form-input">
					</div>
					<div class="col-2">
						<button name="add-submit" type="submit">ADD</button>
					</div>
				</div>
			</form>

			<form action="receipts-create" method="POST">
				<div class="prd-table">
					<div class="row">
						<?= $err_msg ?>
					</div>
					<div class="row">
						<div class="col-1 fw-bold text-center t-head">REF</div>
						<div class="col-3 fw-bold text-center t-head">Product</div>
						<div class="col-1 fw-bold text-center t-head">Qty</div>
						<div class="col-2 fw-bold text-center t-head">PVP</div>
						<div class="col-1 fw-bold text-center t-head">&#37;DSCT</div>
						<div class="col-2 fw-bold text-center t-head">Import</div>
						<div class="col-1 fw-bold text-center t-head">IVA</div>
						<div class="col-1 fw-bold text-center t-head"></div>
					</div>

					<?php
					foreach ($_SESSION['receipt'] as $line) {
						echo $line['html'];
					}
					?>
			</form>

		</div>

		<form method="POST" action="receipts-create">
			<div class="btn-receipt">
				<button name="submit-receipt" type="submit">Generate Receipt</button>
			</div>
		</form>
	</div>

	<?php
	foreach ($_SESSION['receipt'] as $line) {
		echo $line['ref'] . "<br>";
	}
	?>


	<?= $empty_msg ?>
	<?= $no_coincidence ?>
	<script type="text/javascript">
		function dropDown() {
			document.getElementById("myDropdown").classList.toggle("show");
		}

		window.onclick = function(event) {
			if (!event.target.matches('.dropbtn')) {
				var dropdowns = document.getElementsByClassName("dropdown-content");
				var i;
				for (i = 0; i < dropdowns.length; i++) {
					var openDropdown = dropdowns[i];
					if (openDropdown.classList.contains('show')) {
						openDropdown.classList.remove('show');
					}
				}
			}
		}
	</script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>

</html>