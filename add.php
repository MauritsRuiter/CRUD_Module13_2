<?php 
include_once('connect.php');

if (isset($_POST['submit'])) {
    // Check if the 'title' is not empty
    if (!empty($_POST['title'])) {
        $title = $_POST['title'];
        $subsmall = $_POST['subsmall'];
        $sublarge = $_POST['sublarge'];
        $whatused = $_POST['whatused'];
        $yearmade = $_POST['yearmade'];
        $github = $_POST['github'];

        try {
            $stmt = $conn->prepare("INSERT INTO projects (title, subtext_small, subtext_large, what_used, year_made, github, img) 
                VALUES (:title, :subsmall, :sublarge, :whatused, :yearmade, :github, :img)");

            // Replace 'img' with your actual image value
            $stmt->bindValue(':img', 'img');

            // Bind parameters
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':subsmall', $subsmall);
            $stmt->bindParam(':sublarge', $sublarge);
            $stmt->bindParam(':whatused', $whatused);
            $stmt->bindParam(':yearmade', $yearmade);
            $stmt->bindParam(':github', $github);

            // Execute the statement
            $stmt->execute();

            // Redirect to the index page
            header('location: index.php?page=1');
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        // Handle the case when 'title' is empty
        echo "Title cannot be empty. Please provide a title.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>add record</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>

<body>
    <main>
        <div class="container">
            <div class="row row-cols-1 row-cols-sm-1 row-cols-md-1 g-1 projects">
                <div id="project1" class="project card shadow-sm card-body mt-5">
                    <form action="add.php" method="post">
                        <div class="card-text">
                            <h2>Title:</h2>
                            <input style="width:50rem; height:4rem;" type="text" name="title" placeholder="Title">
                            <br>
                            <h2>Subtext small:</h2>
                            <input style="width:50rem; height:4rem;" type="text" name="subsmall" placeholder="Subsmall">
                            <br>
                            <h2>Subtext large:</h2>
                            <input style="width:50rem; height:4rem;" type="text" name="sublarge" placeholder="Sublarge">
                            <br>
                            <h2>What used:</h2>
                            <input style="width:50rem; height:4rem;" type="text" name="whatused" placeholder="html css java php">
                            <br>
                            <h2>Year made:</h2>
                            <input style="width:50rem; height:4rem;" type="text" name="yearmade" placeholder="0000-00-00">
                            <br>
                            <h2>GitHub link:</h2>
                            <input style="width:50rem; height:4rem;" type="text" name="github" placeholder="GitHub URL">
                            <br>
                            <!-- Add other form fields here -->
                            <input style="width:50rem; height:4rem;" type="submit" name="submit" value="Add Record">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>
