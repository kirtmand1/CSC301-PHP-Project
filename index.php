<?php

// Create and include a configuration file with the database connection
include('config.php');

// Include functions for application
include('functions.php');

// Get search term from URL using the get function
$term = get('search-term');

// Get a list of plants using the searchPlants function
// Print the results of search results
// Add a link printed for each plant to plant.php with an passing the sku
// Add a link printed for each plant to form.php with an action of edit and passing the sku
$plants = searchPlants($term, $database);
?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
  	<title>Plants</title>
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
      
         <article>
            <h1>Online Ordering</h1>
            <p>Thank you for using our <em>online ordering</em>
               for quick and easy orders, delivered free, fast, and 
               to your door. If you need to talk to us directly,
               call the farm at (859) 555 - 7499.
            </p>
         </article>
      </header>
    <section>
	<div class="page1">
		<h1>Plants</h1>
		<form method="GET">
			<input type="text" name="search-term" placeholder="Search..." />
			<input type="submit" /><br />
		</form>
		<br/>
		<ul>
		<?php foreach($plants as $plant) : ?>
			<p>
				<?php echo $plant['name']; ?><br />
				<?php $image=$plant['image'];
					print"<img src=\"$image\" width=\"100px\" height=\"100px\"\/>"; ?><br />
				<?php echo "$".$plant['price']; ?> <br />
				<a href="form.php?action=edit&sku=<?php echo $plant['sku'] ?>">Edit Plant</a><br />
				<a href="plant.php?sku=<?php echo $plant['sku'] ?>">View Plant</a>
			</p>
		<?php endforeach; ?>
		</ul>
		<!-- print currently accessed by the current username -->
		<p>Currently logged in as: <?php echo $customer->getName(); ?></p>
		<p><a href="cart.php">View Cart</a></p>
		
		<!-- A link to the logout.php file -->
		<p>
			<a href="logout.php">Log Out</a>
		</p>
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