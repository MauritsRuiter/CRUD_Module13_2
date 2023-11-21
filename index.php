<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Portfolio Website - Overzichtspagina</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>

<body>
	<!-- Header -->
	<?php include_once("connect.php");
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
			// if session logged in show username else show link to login.php
			echo "<span style='position:sticky; top:0px; z-index:999; border-radius:0 0 6px 6px !important; border-left:none; border-top:none; border-right:none;' class='card shadow-sm p-2' m-1>";
			echo "Ingelogd als: " . "<b>" . $_SESSION["username"] . "</b>";
			echo "<a href='add.php' class='btn btn-secondary' name='submit' type='submit' style='position:absolute; right:12px; top:12px; z-index:999 !important;'>Nieuwe record toevoegen</a>";
			echo "</span>";
			// Logout button
			echo "<a href='logout.php' class='btn btn-danger' style='position:sticky; top:94%; left:1rem; z-index:999 !important;'>Log uit</a>";
		} else {
			echo "<div style='float:right; position:sticky; right:1.5rem;'>";
			echo "<span>Je bezoekt de site momenteel als gast, klik </span><a href='login.php'>hier</a><span> om in the loggen</span>";
			echo "</div>";
		}
	?>
	<!-- Container -->
	<div class="container" style="min-height:810px;">
		<div class="d-flex justify-content-center align-items-center m-4">
			<nav aria-label="search and filter">
				<form action="index.php" method="post">
					<input type="search" class="form-control ds-input" id="search-input" name="search" placeholder="Zoeken..." aria-label="Search for..." autocomplete="off" spellcheck="false" role="combobox" aria-autocomplete="list" aria-expanded="false" aria-owns="algolia-autocomplete-listbox-0" dir="auto" style="position: relative; vertical-align: top;">
				</form>
			</nav>
		</div>
		<?php // Code to show the delete dialogue
		if (isset($_GET['delete'])) {
			$idToDelete = $_GET['delete'];
			try {
				$stmt = $conn->prepare("DELETE FROM projects WHERE id = :idToDelete");
				$stmt->bindParam(':idToDelete', $idToDelete);
				$stmt->execute();
				header('location: index.php?page=1');
			} catch (PDOException $e) {
				echo "Error: " . $e->getMessage();
			}
		}
		foreach ($result as $row) { ?>
			<!-- Card -->
			<div class="row row-cols-1 row-cols	-sm-1 row-cols-md-1 g-1 projects">
				<div class="project card shadow-sm card-body m-4">
					<div class="card-text">
						<h2><?php echo $row['title']; ?></h2>
						<div><?php echo $row['subtext_small']; ?></div>
						<div><?php echo $row['year_made']; ?></div>
						<!-- if else statement to show text if no image is found. -->
						<!-- Image -->
						<?php if(!empty($row['img']) && file_exists($row['img'])) { ?>
						<img src="<?php echo $row['img']?>" alt="image" class="rounded-3 mt-3">
							<?php } else {
								echo "<div class='mt-3'>";
								echo "Geen bijlage om te laten zien.";
								echo "</div>";
							}
						?>
					</div>
					<div class="d-flex justify-content-between align-items-center mt-3">
						<div class="btn-group">
							<a href="view.php?view=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-primary" style="text-decoration: none !important;">Bekijken</a>
							<!-- Session to show correct buttons on login status -->
							<?php if (isset($_SESSION["logged_in"])) { ?>
								<a href="edit.php?edit=<?php echo $row["id"]; ?>" class="btn btn-sm btn-outline-success" style="text-decoration: none !important; border-radius: 0 !important;">Bewerken</a>
								<a href="index.php?delete=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger" style="text-decoration: none !important; border-radius: 0 4px 4px 0 !important;" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal<?php echo $row['id']; ?>">Verwijderen</a>
								<!-- Delete conformation box bootstrap -->
								<div class="modal fade" id="confirmDeleteModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="confirmDeleteModalLabel">Verwijder box</h5>
												<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
											</div>
											<div class="modal-body">
												<span>Weet je zeker dat je deze record wilt verwijderen?</span>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Nee</button>
												<a href="index.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger">Ja</a>
											</div>
										</div>
									</div>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
		<!-- Pagination -->
		<div class="d-flex justify-content-center align-items-center">
			<nav aria-label="Page navigation example">
				<ul class="pagination">
					<li class="page-item">
						<a class="page-link" href="?page=<?php echo max($page - 1, 1); ?>" aria-label="Previous">
							<span aria-hidden="true">&laquo;</span>
						</a>
					</li>
					<?php
					// Initialize $totalPages for the case when a search is performed
					$totalPages = isset($totalPages) ? $totalPages : 1;
					for ($i = 0; $i < $totalPages; $i++) {
					?>
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
	<!-- Footer -->
	<footer class="card w-100" style="padding: 20px; text-align: center; border-radius: 6px 6px 0 0 !important; border-left:none; border-bottom:none; border-right:none;">
		<p style="margin: 0; color:#000;">&copy; <?php echo date('Y'); ?> Portfolio Website Maurits Ruiter. <br> All rights reserved. <br><br><a href="#" style="color:#000; text-decoration: none;">Privacy Policy</a> <a href="#" style="color:#000; text-decoration: none;">Terms of Service</a>
	</footer>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>