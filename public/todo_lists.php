<?php 

define('FILENAME', './lists.txt');

require_once('../inc/filestore.php');

$file = new Filestore(FILENAME);

$items = $file->read();

if (isset($_POST['new_item'])) {
    try {
        if(strlen($_POST['new_item']) == 0){
            throw new Exception('You didn\'t add any items!');
        } elseif(strlen($_POST['new_item']) > 240){
            throw new Exception('Your item cant be longer then 240 characters!');
        }
        $items[] = $_POST['new_item'];
        $file->write($items);

    } catch (Exception $e) {
        $getMessage = $e->getMessage();
    }

    
} 

if (isset($_GET['remove'])) {
    unset($items[$_GET['remove']]);
    $file->write($items);
    $items = array_values($items);
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

?>

<html>
<head>
    <title>Todo List</title>
</head>
<body>


<ul>
<? foreach ($items as $key => $chores): ?>
        <li> <a href='?remove=<?= $key; ?>'>Complete</a> <?= htmlspecialchars(strip_tags($chores)); ?> </li>
<? endforeach; ?>
</ul>


<h2>New Item</h2>
<form method="post" action="todo_lists.php">  
    <?php 
    if(isset($_POST['new_item'])){
        echo $getMessage;    
    }
    ?>
        <div class="form-group">
            <input type="text" placeholder="new item" name="new_item" id="new-item">
        </div>
        <div class="form-group">
            <button type="submit">Add Item</button>
        </div> 
</form>


<? if (isset($newfilename)): ?>
    <p>You can download your file <a href='/uploads/{$uploadBasename}'>here</a>:</p>
<? endif; ?>


<h2>Upload File</h2>

<form method="POST" enctype="multipart/form-data" action="/todo_lists.php">
    <p>
        <label for="upload">File to upload: </label>
        <input type="file" id="upload" name="upload">
    </p>
    <p>
        <input type="submit" value="Upload">
    </p>
</form>


</body>
</html>