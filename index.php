<?php include_once('connect.php'); ?>
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
		<?php include_once "connect.php";
		if (isset($_POST["search"])) {
			$stmt = $conn->prepare("SELECT * FROM projects WHERE title LIKE '%" .
				$_POST["search"] . "%'" . " 
				OR subtext_small LIKE '%" . $_POST["search"] . "%'" . " 
				OR subtext_large LIKE '%" . $_POST["search"] . "%'" . " 
				OR what_used LIKE '%" . $_POST["search"] . "%'" . " 
				OR year_made LIKE '%" . $_POST["search"] . "%'" . " 
				ORDER BY year_made DESC ");
			$stmt->execute();
			$result = $stmt->fetchAll();
		} else {
			// Assuming 2 projects per page
			$projectsPerPage = 2;

			// Calculate total number of projects
			$totalProjectsStmt = $conn->prepare("SELECT COUNT(*) FROM projects");
			$totalProjectsStmt->execute();
			$totalProjects = $totalProjectsStmt->fetchColumn();

			// Calculate total number of pages
			$totalPages = ceil($totalProjects / $projectsPerPage);

			// Get current page from the URL parameter
			$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;

			// Calculate offset for the SQL query
			$offset = ($page - 1) * $projectsPerPage;

			// Fetch projects based on the current page
			$stmt = $conn->prepare("SELECT * FROM projects LIMIT $projectsPerPage OFFSET $offset");
			$stmt->execute();
			$result = $stmt->fetchAll();
		}

		session_start();
		if (isset($_SESSION["logged_in"])) {
			echo "<br>";
			echo "<div style='float:right; position:sticky; right:1.5rem'>";
			echo "Ingelogd als: " . "<b>" . $_SESSION["username"] . "</b>" . "<br><br>" . " <a href='logout.php' class='btn btn-sm btn-outline-danger' style='float:right;' >Log out</a>";
			echo "</div>";
		} else {
			header('Location: login.php');
		}
		?>
		<div class="container">
			<div class="d-flex justify-content-center align-items-center m-4">
				<nav aria-label="search and filter">
					<form action="index.php" method="post">
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
			<div class="d-flex justify-content-center align-items-center m-4 fixed-bottom">
				<nav aria-label="Page navigation example">
					<ul class="pagination">
						<li class="page-item">
							<a class="page-link" href="?page=<?php echo max($page - 1, 1); ?>" aria-label="Previous">
								<span aria-hidden="true">&laquo;</span>
							</a>
						</li>

						<?php for ($i = 0; $i < $totalPages; $i++) { ?>
							<li class="page-item <?php echo $i + 1 == $page ? 'active' : ''; ?>">
								<a class="page-link" href="?page=<?php echo $i + 1; ?>"><?php echo $i + 1; ?></a>
							</li>
						<?php } ?>

						<li class="page-item">
							<a class="page-link" href="?page=<?php echo min($page + 1, $totalPages); ?>" aria-label="Next">
								<span aria-hidden="true">&raquo;</span>
							</a>
						</li>
					</ul>
				</nav>
			</div>
		</div>
	</main>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>