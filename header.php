<?php
session_start();
//Seja poteče po 30 minutah - avtomatsko odjavi neaktivnega uporabnika
if (isset($_SESSION['LAST_ACTIVITY']) && time() - $_SESSION['LAST_ACTIVITY'] < 1800) {

    session_regenerate_id(true);
}
$_SESSION['LAST_ACTIVITY'] = time();

//Poveži se z bazo
$conn = new mysqli('localhost', 'root', '', 'vaja1');
//Nastavi kodiranje znakov, ki se uporablja pri komunikaciji z bazo
$conn->set_charset("UTF8");

if(isset($_POST['search_ads'])){ //check if form was submitted
    $input = $_POST['search_string']; //get input text
    $message = "Success! You entered: ".$input;
    header("Location: search.php?search_string=$input");
}

?>
<html>
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.1/css/bulma.min.css">
    <title>Vaja 1</title>
</head>
<body>

<nav class="navbar" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <a class="navbar-item" href="index.php">
            <img src="https://bulma.io/images/bulma-logo.png" width="112" height="28">
        </a>

        <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
        </a>
    </div>
    <form action="" method="post" enctype="multipart/form-data">
    <div id="navbarBasicExample" class="navbar-menu">
        <div class="navbar-start">
            <a class="navbar-item" href="index.php">
                Home
            </a>
            <div class="level-left" style="padding-top:10px ">
                <div class="level-item">
                    <div class="field has-addons block">

                        <p class="control navbar-item">
                            <input class="block input" type="text" name="search_string" placeholder="Search for ads...">
                        </p>
                            <p class="control navbar-item ">
                                <input type="submit" name="search_ads" value="Search" class="button is-info">
                            </p>

                    </div>
                </div>
            </div>
    </form>
            <?php

            /*
             * <p class="control">
                            <a href="search.php?search_string=<?php echo $_GET["search_string"]; ?>"
                                class="button is-info">Search</a>
                        </p>
             * */
            if (isset($_SESSION["USER_ID"])) {
                ?>
                <a class="navbar-item" href="my_ads.php">My ads</a>
                <?php
                if (isset($_COOKIE["user"]))
                    echo "<a class='navbar-item'> Welcome ". $_COOKIE["user"] ."</a>";?>
                <a class="navbar-item" href="logout.php">Log out</a>
                <?php
            } else {
                ?>
                <div class="navbar-end">
                    <div class="navbar-item">
                        <div class="buttons">
                            <a class="button is-primary" href="registration.php">
                                <strong>Sign up</strong>
                            </a>
                            <a class="button is-light" href="login.php">
                                Login
                            </a>
                        </div>
                    </div>
                </div>

                <?php
            }
            ?>

        </div>
    </div>
    <div>
</nav>
<hr/>