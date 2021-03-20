<?php
include_once('header.php');
// Funkcija prebere oglase iz baze in vrne polje objektov
function get_oglasi()
{
    global $conn;
    $user_id=$_SESSION["USER_ID"];
    $query = "SELECT * FROM ads WHERE id_user = $user_id;";
    $res = $conn->query($query);
    $oglasi = array();
    while ($oglas = $res->fetch_object()) {
        array_push($oglasi, $oglas);
    }
    return $oglasi;
}

//Preberi oglase iz baze
$oglasi = get_oglasi();
?>

 <div class="container is-fluid">
    <div class="block">
        <div class="level-left">
            <p class="title level-item">All my ads</p>
        </div>
        <div class="level-right">
            <p class="level-item"><a href="add_category_to_ad.php" class="button is-success">Add add to category</a></p>
            <p class="level-item"><a href="add_image_to_ad.php" class="button is-success">Add image to ad</a></p>
            <p class="level-item"><a href="publish.php" class="button is-success">Publish new ad</a></p>
        </div>
    </div>

<?php
//Izpiši oglase
//Doda link z GET parametrom id na oglasi.php za gumb 'Preberi več'
foreach ($oglasi as $oglas) {
    ?>

    <div class="block">
        <div class="card" style="background-color: rgba(155, 212, 98, 0.68); color:rgba(40, 42, 39, 0.68);">
            <header class="card-header">

                <div class="columns is-vcentered">
                    <div class="column is-8">
                        <p class="card-header-title">
                            <?php echo $oglas->title; ?>
                        </p>
                    </div>
                    <div class="column" style="width: 400px">
                            <?php echo substr($oglas->expiration_date, 0, 10) ?>
                    </div>
                    <div class="column" style="width: 600px">
                        Number of views: <?php  echo substr($oglas->number_of_views, 0, 10) ?>
                    </div>
                </div>
            </header>
            <div class="card-content">
                <div class="content">
                    <?php echo $oglas->description; ?>
                    <br>
                </div>
            </div>
            <footer class="card-footer">
                <a href="ad.php?id=<?php echo $oglas->id_ad; ?>"
                   style="color:rgba(46, 48, 50, 0.92); font-weight: bold" class="card-footer-item">Read more</a>
                <a href="extend_expiration_date.php?id=<?php echo $oglas->id_ad; ?>"
                   style="color:rgba(25, 141, 214, 0.92); font-weight: bold" class="card-footer-item">Extend expiration date (30 days)</a>
                <a href="delete_ad.php?id=<?php echo $oglas->id_ad; ?>"
                   style="color:rgba(233,95,88,0.92); font-weight: bold" class="card-footer-item">Delete this ad <?php echo $oglas->id_ad; ?></a>
            </footer>
        </div>
    </div>
    <?php
}
?>

 </div>
