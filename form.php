<?php

// Create and include a configuration file with the database connection
include('config.php');

// Include functions for application
include('functions.php');

// Get type of form either add or edit from the URL (ex. form.php?action=add) using the newly written get function
$action = $_GET['action'];

// Get the plant sku from the URL if it exists using the newly written get function
$sku = get('sku');

// Initially set $plant to null;
$plant = null;

// Initially set $plant_categories to an empty array;
$plant_categories = array();

// If plant sku is not empty, get plant record into $plant variable from the database
//     Set $plant equal to the first plant in $plants
// 	   Set $plant_categories equal to a list of categories associated to a plant from the database
if(!empty($sku)) {
	$sql = file_get_contents('sql/getPlant.sql');
	$params = array(
		'sku' => $sku
	);
	$statement = $database->prepare($sql);
	$statement->execute($params);
	$plants = $statement->fetchAll(PDO::FETCH_ASSOC);
	
	$plant = $plants[0];
	
	// Get plant categories
	$sql = file_get_contents('sql/getPlantCategories.sql');
	$params = array(
		'sku' => $sku
	);
	$statement = $database->prepare($sql);
	$statement->execute($params);
	$plant_categories_associative = $statement->fetchAll(PDO::FETCH_ASSOC);
	
	foreach($plant_categories_associative as $category) {
		$plant_categories[] = $category['categoryid'];
	}
}

// Get an associative array of categories
$sql = file_get_contents('sql/getCategories.sql');
$statement = $database->prepare($sql);
$statement->execute();
$categories = $statement->fetchAll(PDO::FETCH_ASSOC); 

// If form submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$sku = $_POST['sku'];
	$name = $_POST['plant-name'];
	$plant_categories = $_POST['plant-category'];
	$image = $_POST['plant-image'];
	$price = $_POST['plant-price'];
	
	if($action == 'add') {
		// Insert plant
		$sql = file_get_contents('sql/insertPlant.sql');
		$params = array(
			'sku' => $sku,
			'name' => $name,
			'image' => $image,
			'price' => $price
		);
	
		$statement = $database->prepare($sql);
		$statement->execute($params);
		
		// Set categories for plant
		$sql = file_get_contents('sql/insertPlantCategory.sql');
		$statement = $database->prepare($sql);
		
		foreach($plant_categories as $category) {
			$params = array(
				'sku' => $sku,
				'categoryid' => $category
			);
			$statement->execute($params);
		}
	}
	
	elseif ($action == 'edit') {
		$sql = file_get_contents('sql/updatePlant.sql');
        $params = array( 
            'sku' => $sku,
            'name' => $name,
            'image' => $image,
            'price' => $price
        );
        
        $statement = $database->prepare($sql);
        $statement->execute($params);
        
        //remove current category info 
        $sql = file_get_contents('sql/removeCategories.sql');
        $params = array(
            'sku' => $sku
        );
        
        $statement = $database->prepare($sql);
        $statement->execute($params);
        
        //set categories for plant
        $sql = file_get_contents('sql/insertPlantCategory.sql');
        $statement = $database->prepare($sql);
        
        foreach($plant_categories as $category) {
            $params = array(
                'sku' => $sku,
                'categoryid' => $category
            );
            $statement->execute($params);
        };	
		
	}
	
	// Redirect to plant listing page
	header('location: index.php');
}

// In the HTML, if an edit form:
	// Populate textboxes with current data of plant selected 
	// Print the checkbox with the plant's current categories already checked (selected)
?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
  	<title>Manage Plant</title>
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
		<h1>Manage Plant</h1>
		<form action="" method="POST">
			<div class="form-element">
				<label>SKU:</label>
				<?php if($action == 'add') : ?>
					<input type="text" name="sku" class="textbox" value="<?php echo $plant['sku'] ?>" />
				<?php else : ?>
					<input readonly type="text" name="sku" class="textbox" value="<?php echo $plant['sku'] ?>" />
				<?php endif; ?>
			</div>
			<div class="form-element">
				<label>Name:</label>
				<input type="text" name="plant-name" class="textbox" value="<?php echo $plant['name'] ?>" />
			</div>
			<div class="form-element">
				<label>Category:</label>
				<?php foreach($categories as $category) : ?>
					<?php if(in_array($category['categoryid'], $plant_categories)) : ?>
						<input checked class="radio" type="checkbox" name="plant-category[]" value="<?php echo $category['categoryid'] ?>" /><span class="radio-label"><?php echo $category['name'] ?></span><br />
					<?php else : ?>
						<input class="radio" type="checkbox" name="plant-category[]" value="<?php echo $category['categoryid'] ?>" /><span class="radio-label"><?php echo $category['name'] ?></span><br />
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
			<div class="form-element">
				<label>Image</label>
				<input type="text" name="plant-image" class="textbox" value="<?php echo $plant['image'] ?>" />
			</div>
			<div class="form-element">
				<label>Price:</label>
				<input type="number" step="any" name="plant-price" class="textbox" value="<?php echo $plant['price'] ?>" />
			</div>
			<div class="form-element">
				<input type="submit" class="button" />&nbsp;
				<input type="reset" class="button" />
			</div>
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