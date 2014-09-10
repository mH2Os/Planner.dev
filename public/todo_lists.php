<?php 

    define('FILENAME', './lists.txt');

    function open_list($filename = FILENAME)
    {
        $items = array();

        if(is_readable($filename) && filesize($filename) > 0) {
            $handle = fopen($filename, "r");
            $contents = trim(fread($handle, filesize($filename)));
            $items = explode("\n", $contents);

            fclose($handle);
        }

        return $items;
    }

    function save_list($array, $filename = FILENAME) 
    {
        $handle = fopen($filename, 'w');
        $save = implode("\n", $array);
        fwrite($handle, $save);
        fclose($handle);
    }

    $items = open_list();

    if (isset($_POST['new_item'])) {
        $items[] = $_POST['new_item'];
        save_list($items);
    }

    if (isset($_GET['remove'])) {
        unset($items[$_GET['remove']]);
        save_list($items);
        $items = array_values($items);
    }

    if (isset($_FILES['upload']) && $_FILES['upload']['error'] == UPLOAD_ERR_OK) {
        // var_dump($_FILES['upload']);

        $upload = $_FILES['upload'];

        $uploadPath = '/vagrant/sites/planner.dev/public/uploads/';
        $uploadBasename = basename($upload['name']);

        $newFilename = $uploadPath . $uploadBasename;

        move_uploaded_file($upload['tmp_name'], $newFilename);

        // open the new uploaded file & read it into an array
        $newItems = open_list($newFilename);

        // merge that array into our global $items variable
        $items = array_merge($newItems, $items);

        // save the newly merged items
        save_list($items);
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