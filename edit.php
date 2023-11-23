<?php
session_start();
include_once('connect.php');

$result = [];

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];

    try {
        $stmt = $conn->prepare("SELECT * FROM projects WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch as an associative array
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $subsmall = $_POST['subsmall'];
    $sublarge = $_POST['sublarge'];
    $whatused = $_POST['whatused'];
    $yearmade = $_POST['yearmade'];
    $github = $_POST['github'];

    // Update the projects table
    try {
        $stmt = $conn->prepare("UPDATE projects SET 
            title = :title, 
            subtext_small = :subsmall, 
            subtext_large = :sublarge, 
            what_used = :whatused, 
            year_made = :yearmade, 
            github = :github 
            WHERE id = :id");

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':subsmall', $subsmall);
        $stmt->bindParam(':sublarge', $sublarge);
        $stmt->bindParam(':whatused', $whatused);
        $stmt->bindParam(':yearmade', $yearmade);
        $stmt->bindParam(':github', $github);

        $stmt->execute();

        // Delete existing images for the project
        $stmtDelete = $conn->prepare("DELETE FROM images WHERE project_id = :projectId");
        $stmtDelete->bindParam(':projectId', $id);
        $stmtDelete->execute();

        // Insert new images for the project
        if (!empty($_FILES['img']['name'][0])) {
            $imgPaths = [];
            foreach ($_FILES['img']['tmp_name'] as $key => $tmpName) {
                $imgName = $_FILES['img']['name'][$key];
                $imgDestination = 'uploads/' . $imgName;
                move_uploaded_file($tmpName, $imgDestination);
                $imgPaths[] = $imgDestination;
            }

            $stmtInsert = $conn->prepare("INSERT INTO images (project_id, img_path) VALUES (:projectId, :imgPath)");
            foreach ($imgPaths as $imgPath) {
                $stmtInsert->bindParam(':projectId', $id);
                $stmtInsert->bindParam(':imgPath', $imgPath);
                $stmtInsert->execute();
            }
        }

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
    <title>Edit Record</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>

<body class="bg-dark">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 mt-5">
                <div class="card shadow-sm p-5 bg-dark border-white">
                    <form action="edit.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo $result['id']; ?>">
                        <div class="mb-3">
                            <label for="title" class="form-label text-white">Title:</label>
                            <input type="text" class="form-control" id="title" name="title" value="<?php echo $result['title']; ?>" placeholder="Title">
                        </div>
                        <div class="mb-3">
                            <label for="subsmall" class="form-label text-white">Subtext small:</label>
                            <input type="text" class="form-control" id="subsmall" name="subsmall" value="<?php echo $result['subtext_small']; ?>" placeholder="Subsmall">
                        </div>
                        <div class="mb-3">
                            <label for="sublarge" class="form-label text-white">Subtext large:</label>
                            <input type="text" class="form-control" id="sublarge" name="sublarge" value="<?php echo $result['subtext_large']; ?>" placeholder="Sublarge">
                        </div>
                        <div class="mb-3">
                            <label for="whatused" class="form-label text-white">What used:</label>
                            <input type="text" class="form-control" id="whatused" name="whatused" value="<?php echo $result['what_used']; ?>" placeholder="html css java php">
                        </div>
                        <div class="mb-3">
                            <label for="yearmade" class="form-label text-white">Year made:</label>
                            <input type="text" class="form-control" id="yearmade" name="yearmade" value="<?php echo $result['year_made']; ?>" placeholder="0000-00-00">
                        </div>
                        <div class="mb-3">
                            <label for="github" class="form-label text-white">GitHub link:</label>
                            <input type="text" class="form-control" id="github" name="github" value="<?php echo $result['github']; ?>" placeholder="GitHub URL">
                        </div>
                        <div class="mb-3">
                            <label for="img" class="form-label text-white">Image Upload:</label>
                            <input type="file" class="form-control" id="img" name="img[]" multiple>
                        </div>

                        <button type="submit" class="btn btn-primary" name="submit">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>