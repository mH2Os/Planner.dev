<?php 
    
    function open_list($filename = './lists.txt')
    {
        $handle = fopen($filename, "r");
        $contents = trim(fread($handle, filesize($filename)));
        $contents_array = explode("\n", $contents);
        fclose($handle);

        return $contents_array;
    }

    function save_list($array) 
    {
        $filename = get_input();
        $handle = fopen($filename, 'w');
        $save = implode("\n", $array);
        fwrite($handle, $save);
        fclose($handle);
    }

    $items = open_list();

?>

<html>
<head>
    <title>Todo List</title>
</head>
<body>
    <?php
    var_dump($_POST);
    var_dump($_GET);
    
    //$items = ["Walk the dog", "Bathe the dog", "Take the dog to the vet"]; 

    echo "<ol>";
    foreach ($items as $chores) {
        echo "<li> " . $chores . "</li>";
    }
    echo "</ol>";
    ?>
<h2>New Item</h2>
<form method="post">
    <div class="form-group">
        <input type="text" placeholder="new item" name="new_item" id="new-item">
    </div>
    <div class="form-group">
        <button type="submit">Add Item</button>
    </div> 
</form>

</body>
</html>