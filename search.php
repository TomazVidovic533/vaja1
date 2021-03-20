<?php
include_once('header.php');
include_once ('messages.php');
function get_search_results($search_text)
{
    global $conn;
    $search_string = mysqli_real_escape_string($conn, $search_text);
    $select_matching_ads = "SELECT * FROM ads WHERE ads.title LIKE '%$search_string%'  OR ads.description LIKE '%$search_string%'";
    $res = $conn->query($select_matching_ads);
    $ads = array();
    while ($ad = $res->fetch_object()) {
        array_push($ads, $ad);
    }
    return $ads;
}

$search_string = $_GET["search_string"];
$searched_ads = get_search_results($search_string);


//Base64 koda za sliko (hexadecimalni zapis byte-ov iz datoteke)
?>
<div class="container" style=" padding: 1%;">
    <div class="block">
        <div class="level-left">
            <p class="title level-item">Search results for: <?php echo $search_string ?> </p>
        </div>
    </div>
    <?php
    if (count($searched_ads) == 0) {
    echo display_error("Sorry, could not find any results of your search. :(");
    } else {
        foreach ($searched_ads as $ad) {
            ?>

            <div class="block">
                <div class="card" style="background-color: rgba(155, 212, 98, 0.68); color:rgba(40, 42, 39, 0.68);">
                    <header class="card-header">

                        <div class="columns is-vcentered">
                            <div class="column is-8">
                                <p class="card-header-title">
                                    <?php echo $ad->title; ?>
                                </p>
                            </div>
                            <div class="column" style="width: 400px">
                                <?php echo substr($ad->expiration_date, 0, 10) ?>
                            </div>
                            <div class="column" style="width: 600px">
                                Number of views: <?php echo substr($ad->number_of_views, 0, 10) ?>
                            </div>
                        </div>
                    </header>
                    <div class="card-content">
                        <div class="content">
                            <?php echo $ad->description; ?>
                            <br>
                        </div>
                    </div>
                    <footer class="card-footer">
                        <a href="ad.php?id=<?php echo $ad->id_ad; ?>"
                           style="color:rgba(46, 48, 50, 0.92); font-weight: bold" class="card-footer-item">Read
                            more</a>
                    </footer>
                </div>
            </div>
            <?php
        }
    }
    ?>


</div>
<?php

include_once('footer.php');
?>


