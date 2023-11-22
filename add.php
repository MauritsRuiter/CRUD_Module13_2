<?php session_start(); 

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
}?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Add Record</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>
<?php include_once('header.php'); ?>
<body class="bg-dark">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 mt-5">
                <div class="card shadow-sm p-5 bg-dark border-white">
                    <form action="add.php" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="title" class="form-label text-white">Title:</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Title">
                        </div>
                        <div class="mb-3">
                            <label for="subsmall" class="form-label text-white">Subtext small:</label>
                            <input type="text" class="form-control" id="subsmall" name="subsmall"
                                placeholder="Subsmall">
                        </div>
                        <div class="mb-3">
                            <label for="sublarge" class="form-label text-white">Subtext large:</label>
                            <input type="text" class="form-control" id="sublarge" name="sublarge"
                                placeholder="Sublarge">
                        </div>
                        <div class="mb-3">
                            <label for="whatused" class="form-label text-white">What used:</label>
                            <input type="text" class="form-control" id="whatused" name="whatused"
                                placeholder="html css java php">
                        </div>
                        <div class="mb-3">
                            <label for="yearmade" class="form-label text-white">Year made:</label>
                            <input type="text" class="form-control" id="yearmade" name="yearmade"
                                placeholder="0000-00-00">
                        </div>
                        <div class="mb-3">
                            <label for="github" class="form-label text-white">GitHub link:</label>
                            <input type="text" class="form-control" id="github" name="github"
                                placeholder="GitHub URL">
                        </div>
                        <!-- Add file input for image upload -->
                        <div class="mb-3">
                            <label for="img" class="form-label text-white">Upload Image:</label>
                            <input type="file" class="form-control" id="img" name="img">
                        </div>
                        <!-- Add other form fields here -->
                        <button type="submit" class="btn btn-primary" name="submit">Add Record</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>
