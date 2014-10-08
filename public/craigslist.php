<?php
    require('classes/ad.php');
    
    if (isset($_GET)) {
        $adToView = $_GET['id'];
    }

    require('class/Ad.php');

    // if (isset($_GET)) {
    //     $advert = $printable_ads[$_GET['id']];
    // }

    include('header.php')

?>

    <div class="container">
        <div class="jumbotron"></div>


        <?php foreach ($printable_ads as $advert): ?>
        <div>
            <h1> header index variable</h1>
            
            <? endforeach; ?>
        
            <?php foreach(something as something as image handle)?>
            <div class="box" src=<?  $image[]  ?> >
                <div> 
                    <a href="adview.php/?id=<?=$adID ?>"><?= $ad_title ?></a>
                </div>
            </div>
            <?php endforeach ?>
        </div>
    </div>

<? include('footer.php'); ?>

<? include('header.php'); ?>

<!DOCTYPE html>
<html>
<head>
    <title>ChrisList</title>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" type="text/css" href="chris_list.css"> -->
</head>
<body>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
    <nav class="navbar navbar-default" role="navigation">
      <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">ChrisList</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">
            <li><a href="#">Home</a></li>
            <li><a href="#">Post Ad</a></li>
          </ul>
        </div>
      </div>
    </nav>
<div class="container">
    <div id="postTitle" class="row">
        <div class="col-md-10 col-md-offset-1">
            <h2 id="">POST TITLE</h2>
        </div>
    </div>
    <div id="postBody" class="row">
        <div class="col-md-10 col-md-offset-1">
            BODY
        </div>
    </div>
    <div id="postInfo">
        <div class="col-md-10 col-md-offset-1">
            <p><em id="postDate">POST DATE/TIME</em></p>
            <h4 id="contactName">Posted By: NAME</h4>
            <p id="contactEmail">Contact Email: EMAIL</p>
        </div>
    </div>
</div>

<? require('classes/ad.php'); ?>
<? include('header.php'); ?>

    <form method="POST" action="classes/Ad_Manager.php">
        <label></label>
        <input type="text" name="title" id="title" placeholder="Title">
        <textarea name="body" id="body" placeholder="Body"></textarea>
        <input type="text" name="date" id="date" placeholder="Date">
        <input type="text" name="contact" id="contact" placeholder="Userame">
        <input type="text" name="email" id="email" placeholder="Email">
        <!-- <input type="file" id="image" placeholder="Image"> -->
        <input type="submit">
    </form>

<? include('footer.php'); ?>

</body>
</html>

