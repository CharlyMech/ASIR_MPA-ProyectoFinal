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
		.alert {
			/* display: flex;
			justify-content: center;
			align-items: center; */
			margin: -10px auto;
			padding: 2% 4%;
			background-color: #12ad07;
			border-radius: 10px;
			width: 53%;
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
		<div class="w-50 container-fluid">
			<form action="products-create" method="POST">
				<div class="row mb-2">
					<div class="col-6">
						<label>Name:</label>
						<input type="text" name="name" class="form-text w-100" required>
					</div>
					<div class="col-2">
						<label>Category:</label>
						<select class="w-100" name="cat">
							<option></option>
							<?= $cat_opt ?>
						</select>
					</div>
					<div class="col-2">
						<label>IVA:</label>
						<select class="w-100" name="iva">
							<option></option>
							<option value="4">4</option>
							<option value="10">10</option>
							<option value="21">21</option>
						</select>
					</div>
					<div class="col-2">
						<label>FEE:</label>
						<select class="w-100" name="fee">
							<option></option>
							<?= $f_opt ?>
						</select>
					</div>
				</div>

				<div class="row mb-2">
					<div class="col-12">
						<label>Description:</label>
						<!-- <input type="text" class="form-text w-100" style="height:15vh"> -->
						<textarea name="descr" cols="40" rows="5" class="w-100"></textarea>
					</div>
				</div>

				<div class="row mt-5">
					<div class="col-4"></div>
					<div class="col-4">
						<button class="w-100" type="submit" name="create-prd">Create Product</button>
					</div>
					<div class="col-4"></div>
				</div>
			</form>
			<div class="row mt-5">
				<div class="col-1"></div>
				<div class="col-10">
					<?= $feedback ?>
				</div>
				<div class="col-1"></div>
			</div>
		</div>
	</div>

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