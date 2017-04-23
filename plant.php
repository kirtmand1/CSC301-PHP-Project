<?php

// Create and include a configuration file with the database connection
include('config.php');

// Include functions
include('functions.php');


// Get the plant sku from the url
$sku = get('sku');
$quantity = get('quantity');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$sku = $_POST['sku'];
	$quantity = $_POST['quantity'];
	$cart = &$_SESSION['cart'];
	$cart->addToCart($sku, $quantity);
}
// Get a list of plants from the database with the sku passed in the URL
$sql = file_get_contents('sql/getplant.sql');
$params = array(
	'sku' => $sku
);
$statement = $database->prepare($sql);
$statement->execute($params);
$plants = $statement->fetchAll(PDO::FETCH_ASSOC);

// Set $plant equal to the first plant in $plants
$plant = $plants[0];

// Get categories of plant from the database
$sql = file_get_contents('sql/getPlantCategories.sql');
$params = array(
	'sku' => $sku
);
$statement = $database->prepare($sql);
$statement->execute($params);
$categories = $statement->fetchAll(PDO::FETCH_ASSOC);

/* In the HTML:
	- Print the plant name, image, price
	- List the categories associated with this plant
*/
?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
  	<title>Plant</title>
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
	<form action="" method="post">
		<div class="page">
			<h1><?php echo $plant['name'] ?></h1>
			<p>
			<?php $image=$plant['image'];
			    print"<img src=\"$image\" width=\"200px\" height=\"200px\"\/>"; ?><br />
			<h3><?php echo "Price" ?></h3>
			<p>
			<?php echo "$".$plant['price']; ?><br />
			</p>
			</p>
		    <h3><?php echo "Categories" ?></h3>
			<ul>
			    <?php foreach($categories as $category) : ?>
					<li><?php echo $category['name'] ?></li>
				<?php endforeach; ?><br>
			</ul>
	        <input type="hidden" name="sku" value="<?php echo get('sku');?>"/>
			<input type="text" name="quantity" value="0" size="2" />
			<input type="submit" value="Add To Cart" /><br><br>
			<a href="index.php">Return to Plant List</a><br><br>
			<?php 	if ($quantity == 1) { 
		                echo $quantity." plant has been added to your cart.";
	                }
	                elseif ($quantity > 1){
		                echo $quantity." plants have been added to your cart.";
	                }?>			
		</div>
	</form>
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