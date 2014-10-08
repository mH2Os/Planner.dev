<?php 

define('FILENAME', './address_book.csv');

require_once('address_data_store.php');

$ads = new AddressDataStore(FILENAME);
$address_book = $ads->open_address_book();

if (!empty($_POST)) {
	try {
	    if(strlen($_POST['name']) > 125){
	        throw new Exception('Your item cant be longer then 125 characters!');
	    }
	    if(strlen($_POST['address']) > 125){
	        throw new Exception('Your item cant be longer then 125 characters!');
	    }
	    if(strlen($_POST['city']) > 125){
	        throw new Exception('Your item cant be longer then 125 characters!');
	    }
	    if(strlen($_POST['state']) > 125){
	        throw new Exception('Your item cant be longer then 125 characters!');
	    }
	    if(strlen($_POST['zip']) > 125){
	        throw new Exception('Your item cant be longer then 125 characters!');
	    }
	    if(strlen($_POST['phone']) > 125){
	        throw new Exception('Your item cant be longer then 125 characters!');
	    }

		$newAddress = [
			$_POST['name'],
			$_POST['address'],
			$_POST['city'],
			$_POST['state'],
			$_POST['zip'],
			$_POST['phone']
		];

	    $address_book[] = $newAddress;

	    $ads->save_address_book($address_book);
	} catch (Exception $e) {
        $getMessage = $e->getMessage();
	}
}

if (isset($_GET['remove'])) {
    unset($address_book[$_GET['remove']]);
    $ads->save_address_book($address_book);
    $address_book = array_values($address_book);
}

if (count($_FILES) > 0 && $_FILES['file1']['error'] == 0) {
  
    $upload_dir = '/vagrant/sites/planner.dev/public/uploads/';

    $filename = basename($_FILES['file1']['name']);

    $saved_filename = $upload_dir . $filename;

    move_uploaded_file($_FILES['file1']['tmp_name'], $saved_filename);

    // new instance of AddressDataStore for $saved_filename
    $new_ads = new AddressDataStore($saved_filename);

    $newAddressBook = $new_ads->open_address_book();
    $address_book = array_merge($newAddressBook, $address_book);
   	$ads->save_address_book($address_book);
}

?>

<html>
<head>
	<title>Address Book</title>
</head>
<body>
	<style type="text/css">
		body {
			background-color: #9966FF
		}
		h1 {
			text-align: center;
			color: white;
			font-family: sans-serif;
		}
		tr {
			text-align: center;
			color: white;
			font-family: sans-serif;

		}
		h2 {
			text-align: center;
			color: white;
			font-family: sans-serif;
		}
		p {
			text-align: center;
			color: white;
		}
		#sbmt_btn {
			text-align: center;
			border-width: 5px; 
			border-style: groove;
			border-color: white;
			margin: auto;
			width: 55px;
			height: 20px;
		}
		#upload_file {
			text-align: center;
			color: white;
			margin: auto;
			text-align: center;

		}
		table {
			 border-width: 5px; 
			 border-style: groove;
			 border-color: white;
			 text-align: center;
			 margin: auto;
		}
		a {
			color: #33CCFF;
		}
		#user_input {
			color: white;
			 border-style: groove;
			 border-color: white;
			 margin: auto;
			 text-align: center;
			 width: 140px;
			 height: 200px;
		}
	</style>
	<table border= "5">
		<h1>Address Book</h1>
			<tr>
				<th>Name</th>
				<th>Address</th>
				<th>City</th>
				<th>State</th>
				<th>Zip</th>
				<th>Phone</th>
				<th>Remove</th>

			</tr>

			<?php foreach ($address_book as $key => $address): ?>
				<tr> 
				<?php foreach ($address as $value): ?>
					<td>
					<?=$value?>
					</td>
				<?php endforeach ?>
					<td>
						<a href='?remove=<?= $key; ?>'>Remove</a>
					</td>
				</tr>
			<?php endforeach ?>
	</table>

	<form method="POST"  action="address_book.php">
		<h2>Add New Address</h2>
		<div id="user_input">
		<?php
		if (!empty($_POST)) {
			echo $getMessage;
		}
		?>
			<input type="text" name="name" id="name" placeholder="Name" /><br/>

			<input type="text" name="address" id="address" placeholder="address" /><br/>

			<input type="text" name="city" id="city" placeholder="city" /><br/>

			<input type="text" name="state" id="state" placeholder="state" /><br/>

			<input type="text" name="zip" id="zip" placeholder="zip" /><br/>

			<input type="text" name="phone" id="phone" placeholder="phone" /><br/>
			
			<br>
			
			<br>
		</div>

		<div id="sbmt_btn">
			<input type="submit"/> 
		</div>

	</form>

		<div>
			<h1>Upload File</h1>

			<form method="POST" enctype="multipart/form-data" action="/address_book.php">
			    <p>
			        <label for="file1">File to upload: </label>
			        <input type="file" id="file1" name="file1">
			        <input type="submit" value="Upload">
			    </p>

			</form>
		</div>

<? //save_address_book($address_book); ?>
</body>
</html>