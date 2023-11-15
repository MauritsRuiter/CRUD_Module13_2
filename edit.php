<?php
include_once('connect.php');

$result = [];

if (isset($_GET['edit'])) {
	$id = $_GET['edit'];

	try {
		$stmt = $conn->prepare("SELECT * FROM projects WHERE id = :id");
		$stmt->bindParam(':id', $id);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch as associative array
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
}

if (isset($_POST['submit'])) {
	$id = $_POST['id']; // Add hidden input field for id in your form
	$title = $_POST['title'];
	$subsmall = $_POST['subsmall'];
	$sublarge = $_POST['sublarge'];
	$whatused = $_POST['whatused'];
	$yearmade = $_POST['yearmade'];
	$github = $_POST['github'];

	try {
		$stmt = $conn->prepare("UPDATE projects SET 
            title = :title, 
            subtext_small = :subsmall, 
            subtext_large = :sublarge, 
            what_used = :whatused, 
            year_made = :yearmade, 
            github = :github, 
            img = :img 
            WHERE id = :id");

		$stmt->bindParam(':id', $id);
		$stmt->bindParam(':title', $title);
		$stmt->bindParam(':subsmall', $subsmall);
		$stmt->bindParam(':sublarge', $sublarge);
		$stmt->bindParam(':whatused', $whatused);
		$stmt->bindParam(':yearmade', $yearmade);
		$stmt->bindParam(':github', $github);
		$stmt->bindValue(':img', 'img'); // Replace 'img' with your actual image value

		$stmt->execute();
		header('location: index.php?page=1');
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
	<title>Bewerk</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>

<body>
	<main>
		<div class="container">
			<div class="row row-cols-1 row-cols-sm-1 row-cols-md-1 g-1 projects">
				<div id="project1" class="project card shadow-sm card-body mt-5">
					<form action="edit.php" method="post">
						<input type="hidden" name="id" value="<?php echo $result['id']; ?>">
						<div class="card-text">
							<h2>Title:</h2>
							<input style="width:50rem; height:4rem;" type="text" name="title" value="<?php echo $result['title']; ?>" placeholder="Title">
							<br>
							<h2>Subtext small:</h2>
							<input style="width:50rem; height:4rem;" type="text" name="subsmall" value="<?php echo $result['subtext_small']; ?>" placeholder="Subsmall">
							<br>
							<h2>Subtext large:</h2>
							<input style="width:50rem; height:4rem;" type="text" name="sublarge" value="<?php echo $result['subtext_large']; ?>" placeholder="Sublarge">
							<br>
							<h2>What used:</h2>
							<input style="width:50rem; height:4rem;" type="text" name="whatused" value="<?php echo $result['what_used']; ?>" placeholder="html css java php">
							<br>
							<h2>Year made:</h2>
							<input style="width:50rem; height:4rem;" type="text" name="yearmade" value="<?php echo $result['year_made']; ?>" placeholder="0000-00-00">
							<br>
							<h2>GitHub link:</h2>
							<input style="width:50rem; height:4rem;" type="text" name="github" value="<?php echo $result['github']; ?>" placeholder="GitHub URL">
							<br>
							<!-- Add other form fields here -->
							<input style="width:50rem; height:4rem;" type="submit" name="submit" value="Save Changes">
						</div>

					</form>
				</div>
			</div>
		</div>
	</main>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>