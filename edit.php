<?php include_once('connect.php');

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];

    try {
        $stmt = $conn->prepare("SELECT * FROM projects WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetchAll();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $subsmall = $_POST['subsmall'];
    $sublarge = $_POST['sublarge'];
    $whatused = $_POST['whatused'];
    $yearmade = $_POST['yearmade'];
    $github = $_POST['github'];

    try {
        $stmt = $conn->prepare("INSERT INTO projects (title, subtext_small, subtext_large, what_used, year_made, github, img) 
            VALUES (:title, :subsmall, :sublarge, :whatused, NOW(), :github, :img)");

        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':subsmall', $subsmall);
        $stmt->bindParam(':sublarge', $sublarge);
        $stmt->bindParam(':whatused', $whatused);
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
	<title>Portfolio Website - Overzichtspagina</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>

<body>
	<main>
		<div class="container">
			<?php foreach ($result as $row) { ?>
				<div class="row row-cols-1 row-cols-sm-1 row-cols-md-1 g-1 projects">
					<div id="project1" class="project card shadow-sm card-body mt-5">
						<form action="edit.php" method="post">
							<div class="card-text">
								<h1>id: <?php echo $row['id']; ?></h1>
								<hr>
								<h2>Title: <?php echo $row['title']; ?></h2>
								<input style="width:50rem; height:4rem;" type="text" name="title" placeholder="Title">
								<br>
								<hr>
								<div>Subtext small: <?php echo $row['subtext_small']; ?></div>
								<input style="width:50rem; height:4rem;" type="text" name="subsmall" placeholder="Subsmall">
								<br>
								<hr>
								<div>Subtext large: <?php echo $row['subtext_large']; ?></div>
								<input style="width:50rem; height:4rem;" type="text" name="sublarge" placeholder="Sublarge">
								<br>
								<hr>
								<div>What_used: <?php echo $row['what_used']; ?></div>
								<input style="width:50rem; height:4rem;" type="text" name="whatused" placeholder="html css java php">
								<br>
								<hr>
								<div>Year_made: <?php echo $row['year_made']; ?></div>
								<input style="width:50rem; height:4rem;" type="text" name="yearmade" placeholder="0000-00-00">
								<br>
								<hr><span>Link to github project: </span><a href="<?php echo $row['github']; ?>"><?php echo $row['github']; ?></a>
								<br>
								<input style="width:50rem; height:4rem;" type="text" name="github" placeholder="url">
								<br>
								<hr>
								<div><?php echo $row['img']; ?></div>
								<input style="width:50rem; height:4rem;" type="submit">
							</div>
						</form>
					</div>
				</div>
			<?php } ?>
		</div>
	</main>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>