<?php session_start();

include_once('connect.php');

if (isset($_GET['view'])) {
	$id = $_GET['view'];

	try {
        $stmt = $conn->prepare("SELECT * FROM projects WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetchAll();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Bekijk project</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>
<?php include_once('header.php') ?>
<body class="bg-dark">
		<div class="container mt-5">
			<?php foreach ($result as $row) { ?>
				<div class="row row-cols-1 row-cols-sm-1 row-cols-md-1 g-1 projects">
					<div id="project1" class="project card border-white shadow-sm card-body mt-5 bg-dark text-white">
						<div class="card-text">
							<h2><?php echo $row['title']; ?></h2>
							<br>
							<div>Uitleg: <?php echo $row['subtext_large']; ?></div>
							<br>
							<div>Gebruikte technieken: <?php echo $row['what_used']; ?></div>
							<br>
							<div>Wanneer gemaakt: <?php echo $row['year_made']; ?></div>
							<br>
							<span>Link naar github project: </span><a href="<?php echo $row['github']; ?>"><?php echo $row['github']; ?></a>
							<br>
							<!-- if else statement to show text if no image is found. -->
						<?php if(!empty($row['img']) && file_exists($row['img'])) { ?>
						<img src="<?php echo $row['img']?>" alt="image" class="rounded-3 mt-3">
							<?php } else {
								echo "<div class='mt-3'>";
								echo "Geen bijlage om te laten zien.";
								echo "</div>";
							}
						?>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>