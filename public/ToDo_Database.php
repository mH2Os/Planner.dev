<?php

define('FILENAME', './tasks.txt');

require 'ToDo_dbconnection.php';

require_once('../inc/filestore.php');

$file = new Filestore(FILENAME);

$items = $file->read();

$offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;


if (!empty($_POST)) {

	$stmt3 = $dbc->prepare('INSERT INTO todo_items (tasks, task_date) VALUES (:task, now())');

	$stmt3->bindValue(':task', $_POST['tasks'], PDO::PARAM_STR);

	$stmt3->execute(); 
}

if (isset($_GET['remove'])) {
    unset($items[$_GET['remove']]);
}

if (isset($_FILES['upload']) && $_FILES['upload']['error'] == UPLOAD_ERR_OK) {

    $upload = $_FILES['upload'];

    $uploadPath = '/vagrant/sites/planner.dev/public/uploads/';
    $uploadBasename = basename($upload['name']);

    $newFilename = $uploadPath . $uploadBasename;

    move_uploaded_file($upload['tmp_name'], $newFilename);
    
    $newItems = $file->read($newFilename);
    $items = array_merge($newItems, $items);
   $file->write($items);
}

$stmt = $dbc->query("SELECT tasks, task_date FROM todo_items LIMIT 5 OFFSET $offset");

$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt2 = $dbc->query("SELECT count(*) FROM todo_items");

$total = $stmt2->fetchColumn();


?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
   
    <title>Items To Complete</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">

	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

  </head>
  <body>

  	<style type="text/css">
	  	.jumbotron {
			padding: 30px;
			margin-bottom: 30px;
			color: inherit;
			background-color: #99FFCC;
			}
		.nav-pills>li.active>a:hover, 
		.nav-pills>li.active>a:focus {
			color: #fff;
			background-color: #eee;
			}
		.nav-pills>li.active>a, 
		.nav-pills>li.active>a:focus {
			color: #fff;
			background-color: #99FFCC;
			}
		.nav>li>a:hover, 
		.nav>li>a:focus {
			color: white;
			text-decoration: none;
			background-color: #99FFCC;
			}
  	</style>

    <div class="container">

      <div class="header">
        <ul class="nav nav-pills pull-right">
          <li class="active"><a href="#">Home</a></li>
          <li class="about"><a href="#">About</a></li>
        </ul>
        <h3 class="text-muted">Items to be Completed</h3>
      </div>

      <div class="jumbotron">
		<h1>Todo List</h1>
	        <table class="table table-hover">
				<tr>
					<th>Tasks</th>
					<th>Task Date</th>
					<th>Complete</th>
				</tr>
				<?php foreach ($tasks as $key => $tasksTODO): ?>
					<tr> 
					<?php foreach ($tasksTODO as $value): ?>
						<td>
						<?=$value?>
						</td>
					<?php endforeach ?>
						<td>
							<a href='?remove=<?= $key; ?>'>Completed</a>
						</td>
					</tr>
				<?php endforeach ?>
			</table>
      </div>

      <div class="footer">

		<ul class="pager">
			<?php if ($offset != 0): ?>
				  <li class="previous"><a href='?offset=<?= $offset-5; ?>'>&larr; Older</a></li>
			<?php endif; ?>
			<?php if ($offset + 5 < $total): ?>
				  <li class="next"><a href='?offset=<?= $offset+5; ?>'>Newer &rarr;</a></li>
			<?php endif; ?>
		</ul>


        <form class="form-inline" role="form" method="POST" action="/ToDo_Database.php">
         <h3>New Task</h3>
		  <div class="form-group">
		    <label class="sr-only" for="exampleInputtasks2">Tasks</label>
		    <input type="text" name="tasks" class="form-control" id="exampleInputtasks2" placeholder="New Task">
		  </div>
		 <button type="submit" class="btn btn-default">Submit</button>
	    </form>
			
			<br>
			<br>
        <p>&copy; Todo Items 2014</p>
      </div>


    </div>


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>