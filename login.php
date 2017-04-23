<?php

// Create and include a configuration file with the database connection
include('config.php');

// Include functions for application
include('functions.php');

// If form submitted:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	// Get username and password from the form as variables
	$username = $_POST['username'];
	$password = $_POST['password'];
	
	// Query records that have usernames and passwords that match those in the customers table
	$sql = file_get_contents('sql/attemptLogin.sql');
	$params = array(
		'username' => $username,
		'password' => $password
	);
	$statement = $database->prepare($sql);
	$statement->execute($params);
	$users = $statement->fetchAll(PDO::FETCH_ASSOC);
	
	// If $users is not empty
	if(!empty($users)) {
		// Set $user equal to the first result of $users
		$user = $users[0];
		
		// Set a session variable with a key of customerID equal to the customerID returned
		$_SESSION['customerID'] = $user['customerid'];
		
		// Redirect to the index.php file
		header('location: index.php');
	}
}

?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
  	<title>Login</title>
	<meta name="description" content="The HTML5 Herald">
	<meta name="author" content="SitePoint">

	<link rel="stylesheet" href="css/style.css">

	<!--[if lt IE 9]>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
  	<![endif]-->
</head>
<body>
      <header>
		<?php $image='images/garden.jpg';
		    print"<img src=\"$image\" width=\"200px\" height=\"225px\"\/>"; ?><br />
         <nav>
            <ul>
               <li><a href="index.php">Home</a></li>
               <li><a href="form.php?action=edit">Edit Plants</a></li>
               <li><a href="form.php?action=add">Add Plants</a></li>
               <li><a href="cart.php">Shopping Cart</a></li>
               <li><a href="login.php">Login</a></li>
               <li><a href="logout.php">Logout</a></li>
			</ul>
         </nav>
      </header>
	  <section>
	<div class="page">
		<h1>Login</h1>
		<form method="POST">
			<input type="text" name="username" placeholder="Username" />
			<input type="password" name="password" placeholder="Password" />
			<input type="submit" value="Log In" />
		</form>
	</div>
	</section>

   <footer>
      <address>
         Daniel's Garden Nursery &bull;
         Somewhere Drive &bull;
         Erlanger, KY  41018 &bull;
         (859) 555 - 7499 
      </address>
   </footer>
</body>
</html>