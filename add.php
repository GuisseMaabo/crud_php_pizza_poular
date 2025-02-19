<?php
include ('config/db_connect.php');

 $errors = array('email' => '', 'title' => '','ingredients' => '' );
 $email=$title=$ingredients= '';
if (isset($_POST['submit'])){
	// checking if the he puts something in the email inputs
	if (empty( $_POST['email'])) {
		$errors ['email'] = "Require an email </br>";
	} else {
		$email = htmlspecialchars( $_POST['email']);
		if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
			$errors ['email'] =  " email must be a valid email adress";
		}
	}
	// checking if the he puts something in the title inputs
	if (empty( $_POST['title'])) {
		$errors ['title'] = "Require a title";
	} else {
		$title = htmlspecialchars( $_POST['title']);
		if (!preg_match('/^[a-zA-Z\s]+$/',$title)) {
			$errors ['title'] = "Title must be letters and spaces only ";
		}
	}
	// checking if the he puts something in the ingredients inputs
	if (empty( $_POST['Ingredients'])) {
		$errors ['ingredients'] = "Require ingredients";
	} else {
	$ingredients = htmlspecialchars( $_POST['Ingredients']);
	// Verifiy  if we have normal alphabetics entered
		if (!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/',$ingredients)) {
			$errors ['ingredients'] = "ingredients must be letters and spaces only ";
		}
	
	}
	if (array_filter($errors)) {
		// echo "the form is not valid"
	} else {

		// Will protect against sql injections 
		$email= mysqli_real_escape_string($conn, $_POST['email']);
		$title= mysqli_real_escape_string($conn, $_POST['title']);
		$ingredients = mysqli_real_escape_string($conn, $_POST['Ingredients']);

		// create sql 
		$sql = "INSERT INTO pizzas(title,email,ingredients) VALUES ('$title','$email','$ingredients')"; 

		//save to db and check
		if (mysqli_query($conn,$sql)) {
			# success
			 header('Location: index.php');
		} else{
			# error
			echo "Query error" . mysqli_error($conn);
		}
	

	}

}// end of POST

   ?>
   <!DOCTYPE html>
   <html>
    <?php include 'template/header.php'?>
    
    <section class="container grey-text">
    	<h4 class="center">Add a Pizza</h4>
    	<form class="white" action="add.php" method="POST">
    		<label>Your Email:</label>
    		<input type="text" name="email" value="<?php  echo htmlspecialchars($email)?>">
    		<div class="red-text"><?php echo $errors['email']; ?></div>
    		<label>Pizza title:</label>
    		<input type="text" name="title" value="<?php  echo htmlspecialchars($title)?>">
    		<div class="red-text"><?php echo $errors['title']; ?></div>
    		<label>Ingredients (comma separated):</label>
    		<input type="text" name="Ingredients" value="<?php echo htmlspecialchars($ingredients)?>">
    		<div class="red-text"><?php echo $errors['ingredients']; ?></div>
    		<div class="center">
    			<input type="submit" name="submit" value="submit" class="btn brand z-depth-0">
    		</div>
    	</form>
    	
    </section>
   
   <?php include 'template/footer.php'?>
   </html>