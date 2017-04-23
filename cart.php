<?php

// Create and include a configuration file with the database connection
include('config.php');

// Include functions for application
include('functions.php');
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
  	<title>Shopping Cart</title>
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

	<div class="page">
	<h1>Shopping Cart</h1>
		<ul>
			<?php foreach($cart as $product_identifier=>$line_details) { ?>
	           <li> <?php echo $product_identifier.":    Quantity:   ".$line_details; ?></li><br />
			<?php } ?><br><br>
		</ul>
		<a href="index.php">Return to Plant List</a><br><br>
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