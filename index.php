<?php
include_once('header.php'); ?>

<head>
    <link rel="stylesheet" href="style.css" type="text/css">
</head>

<div class="container is-fluid">

    <div class="columns is-vcentered">
        <div class="column is-8">
            <div class="block">
                <div class="level-left">
                    <p class="title level-item">All ads</p>
                </div>
            </div>

            </nav>
            <?php

            // Funkcija prebere oglase iz baze in vrne polje objektov
            function get_oglasi()
            {
                global $conn;
                $query = "SELECT ads.* , image FROM ads JOIN ads_images ON ads.id_ad=ads_images.id_ad JOIN images ON images.id_image=ads_images.id_image WHERE images.main=true ORDER BY ads.expiration_date desc";
                $res = $conn->query($query);
                $oglasi = array();
                while ($oglas = $res->fetch_object()) {
                    array_push($oglasi, $oglas);
                }
                return $oglasi;
            }

            //Preberi oglase iz baze
            $ads = get_oglasi();

            //Izpiši oglase
            //Doda link z GET parametrom id na oglasi.php za gumb 'Preberi več'
            foreach ($ads as $oglas) {
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
                                   Exp. date: <?php echo substr($oglas->expiration_date, 0, 10) ?>
                                </div>
                                <div class="column" style="width: 600px">
                                    Number of views: <?php  echo substr($oglas->number_of_views, 0, 10) ?>
                                </div>
                            </div>
                        </header>
                        <div class="card-content" style="padding-left:22%; width: 900px; height: 380px">
                            <figure class="image is-16by9" >
                                <a href="ad.php?id=<?php echo $oglas->id_ad; ?>"
                                    >
                                <?php
                                echo '<img class="card-img-top" src="data:image/jpeg;base64,' . base64_encode($oglas->image) . '"/>';
                                ?>
                                </a>
                            </figure>
                        </div>
                        <footer class="card-footer">
                            <a href="ad.php?id=<?php echo $oglas->id_ad; ?>"
                               style="color:rgba(40, 42, 39, 0.68); font-weight: bold" class="card-footer-item">Read more</a>
                        </footer>
                    </div>
                </div>

                <?php
            }

            include_once('footer.php');
            ?>

        </div>
       <?php include_once('sidebar_categories.php'); ?>
</div>
</div>