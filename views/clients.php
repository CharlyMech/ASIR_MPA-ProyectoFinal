<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- CSS file for login page -->
	<link rel="stylesheet" type="text/css" href="/company.com/views/styles/receipts.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

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
		<div class="sections">
			<!-- Receipts CRUD -->
			<a class='section-btn' href='clients-create'>Create</a>
			<a class='section-btn' href='clients-read'>Read</a>
			<a class='section-btn' href='clients-update'>Update</a>
			<a class='section-btn' href='clients-delete'>Delete</a>
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

</body>

</html>