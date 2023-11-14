<?php
session_start();

include_once('connect.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Portfolio Website - Overzichtspagina</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>

<body>
	<main>
	<a href="login.php" style="float:right; position:sticky; top:1.5rem; right:1.5rem ">Login</a>
		<div class="container">
			<div class="d-flex justify-content-center align-items-center m-4">
				<nav aria-label="search and filter">
					<form action="" method="POST">
						<input type="search" class="form-control ds-input" id="search-input" name="search" placeholder="Search..." aria-label="Search for..." autocomplete="off" spellcheck="false" role="combobox" aria-autocomplete="list" aria-expanded="false" aria-owns="algolia-autocomplete-listbox-0" dir="auto" style="position: relative; vertical-align: top;">
					</form>
				</nav>
			</div>
			<?php foreach ($result as $row) { ?>
				<div class="row row-cols-1 row-cols	-sm-1 row-cols-md-1 g-1 projects">
					<div id="project1" class="project card shadow-sm card-body m-4">
						<div class="card-text">
							<h2><?php echo $row['title']; ?></h2>
							<div><?php echo $row['subtext_small']; ?></div>
							<div><?php echo $row['year_made']; ?></div>
						</div>
						<div class="d-flex justify-content-between align-items-center mt-3">
							<div class="btn-group ">
								<a href="view.php?view=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-primary" style="text-decoration: none !important;">Bekijken</a>
								<a href="edit.php?edit=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-success" style="text-decoration: none !important;">Bewerken</a>
								<a href="index.php?delete=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger" style="text-decoration: none !important;">Verwijderen</a>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
			<div class="d-flex justify-content-center align-items-center m-4">
				<nav aria-label="Page navigation example">
					<ul class="pagination">
						<li class="page-item">
							<a class="page-link" href="#">Previous</a>
						</li>
						<li class="page-item"><a class="page-link" href="?p=0">1</a></li>
						<li class="page-item"><a class="page-link" href="?p=1">2</a></li>
						<li class="page-item"><a class="page-link" href="?p=2">3</a></li>
						<li class="page-item"><a class="page-link" href="?p=">Next</a></li>
					</ul>
				</nav>
			</div>

		</div>
	</main>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>