<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- CSS file for login page -->
	<!-- <link rel="stylesheet" type="text/css" href="/company.com/views/styles/created_pannel.css"> -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

	<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<style type="text/css">
		body {
			background-color: darkgray;
			/* padding: 3% 15%; */
			font-family: Verdana, Geneva, Tahoma, sans-serif;
		}

		main {
			display: block;
			justify-content: center;
			position: absolute;
			top: 15vh;
			left: 0;
			width: 100%;
			margin-top: 5%;
			font-size: 20px;

			text-align: center;
		}

		.form button {
			position: relative;

			background-color: lightgreen;
			border: 2px solid darkgreen;
			border-radius: 10px;
			font-size: medium;

			width: 80%;
			height: 5vh;

			cursor: pointer;
			outline: none;
		}

		.form button:hover {
			background-color: #3e8e41
		}

		.form button:active {
			background-color: #3e8e41;
			box-shadow: 0 5px #666;
			transform: translateY(4px);
		}

		.main {
			width: 210mm;
			height: 297mm;
			padding: 5mm;
			margin-left: auto;
			margin-right: auto;
			/* border: 1px solid #000; */
			background-color: white;
		}

		.h-cols {
			padding: 1mm;
			/* height: 15vh; */

		}

		.h-col {
			border: 1px solid black;
			height: 100%;

		}

		.h-col h2 {
			font-weight: bolder;
		}

		.h-col div {
			font-size: 3.5mm;
		}

		.references {
			font-size: 14px;
			width: 100%;
			height: 200mm;
			margin: 2.5mm 0;

		}

		footer {
			display: block;
			position: relative;
			bottom: 0px;
			left: 0px;
			width: 100%;
			height: 43mm;
		}
	</style>
	<title>Company</title>
</head>

<body>
	<div>
		<a href="dashboard">Dashboard</a>

		<button onClick="pdfGenerate()" type="submit">PDF</button>
	</div>

	<div class="main my-5" id="receipt-print">

		<div class="container">
			<div class="row">
				<div class="col-5 text-center h-cols">
					<div class="h-col">
						<h2>COMPANY</h2>
						<div>company legal info</div>
						<div>direction</div>
						<div>telephone</div>
						<div>mail</div>
					</div>
				</div>
				<div class="col-2 h-cols">
					<div class="h-col">
						<strong>
							<div>DATE</div>
						</strong>
						<div><?= date('d-m-Y') ?></div>
						<strong>
							<div>Receipt No</div>
						</strong>
						<div>FA - <?= $_SESSION['receipt_id'] ?></div>
					</div>
				</div>
				<div class="col-5 h-cols">
					<div class="h-col">
						<h6><?= $client_info['cli_id'] ?> - <strong><?= $client_info['complete_name'] ?></strong></h6>
						<div><?= $client_info['direction'] ?></div>
						<div><?= $client_info['cp'] ?>,<?= $client_info['locality'] ?></div>
						<div><?= $client_info['telephone'] ?></div>
						<div><?= $client_info['mail'] ?></div>
					</div>
				</div>
			</div>
		</div>

		<!-- MAIN -->
		<div class="container references">
			<div class="row text-center border border-dark" style="background-color:#636363">
				<div class="col-1"><strong>REF</strong></div>
				<div class="col-4"><strong>PRODUCT</strong></div>
				<div class="col-1"><strong>QTY</strong></div>
				<div class="col-2"><strong>PVP</strong></div>
				<div class="col-1"><strong>&#37;DSCT</strong></div>
				<div class="col-2"><strong>IMPORT</strong></div>
				<div class="col-1"><strong>IVA</strong></div>
			</div>
			<?= $rcp_content ?>
		</div>

		<!-- FOOTER -->
		<footer class="container">
			<div class="row text-center border border-dark" style="background-color:#636363">
				<div class="col-2"><strong>SUBTOTAL</strong></div>
				<div class="col-3"><strong>BASE</strong></div>
				<div class="col-1"><strong>&#37;IVA</strong></div>
				<div class="col-3"><strong>QUOTA IVA</strong></div>
				<div class="col-3"><strong>TOTAL RECEIPT</strong></div>
			</div>

			<div class="row">
				<div class="col-2"><?= $subtotal ?></div>
				<div class="col-3">
					<?= $rcp_bases ?>
				</div>
				<div class="col-1">
					<?= $rcp_ivas ?>
				</div>
				<div class="col-3">
					<?= $rcp_quota ?>
				</div>
				<div class="col-3">
					<?= $total ?>
				</div>
			</div>
		</footer>
	</div>



	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
	<script>
		function pdfGenerate() {
			html2pdf().from(document.getElementById('receipt-print')).save("FA" + <?php echo json_encode($_SESSION['receipt_id']); ?>);
		}
	</script>
</body>

</html>