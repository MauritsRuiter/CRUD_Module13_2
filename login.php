<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Portfolio Website - Login</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>

<body class="d-flex align-items-center py-4 bg-body-tertiary">
	<main class="form-signin w-25 m-auto mt-5 border p-2 rounded shadow-sm">
		<form action="login.php" method="post">
			<h1 class="h3 mb-3 fw-normal">Please log in</h1>

			<div class="form-floating">
				<input type="text" name="username" class="form-control" id="floatingInput" placeholder="" />
				<label for="floatingInput">Username</label>
			</div>
			<div class="form-floating mt-2">
				<input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password" />
				<label for="floatingPassword">Password</label>
			</div>
			<button class="btn btn-primary w-100 py-2 mt-2" name="submit" type="submit">
				Log in
			</button>
			<hr>
			<a class="btn btn-secondary w-100 py-2 mt-2" href="signup.php">Back to sign in page</a>
		</form>
		<?php include_once('connect.php');
		if (isset($_POST["submit"])) {
			$username = $_POST["username"];
		
			try {
				// Assuming $conn is your PDO connection object
				include_once('connect.php');
		
				$stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
				$stmt->bindParam(':username', $username);
				$stmt->execute();
				$user = $stmt->fetch();
		
				if ($user) {
					$password = $_POST["password"];
		
					if (password_verify($password, $user["password"])) {
						session_start();
						$_SESSION["logged_in"] = true;
						$_SESSION["username"] = $user["username"];
						header("Location: index.php?page=0");
						exit();
					} else {
						echo "Wrong password";
					}
				} else {
					echo "User not found";
				}
			} catch (PDOException $e) {
				echo "Error: " . $e->getMessage();
			}
		}		
		?>
	</main>
	<script src="/docs/5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>