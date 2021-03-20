<?php
include_once('header.php');

function increase_number_of_views($ad_id){

    global $conn;
    $id_ad = mysqli_real_escape_string($conn, $ad_id);
    $update_number_of_views= "UPDATE ads SET ads.number_of_views=ads.number_of_views+1 where id_ad=$id_ad;";
    if($conn->query($update_number_of_views)){
        return true;
    }
}

function get_all_photos($ad_id)
{
    global $conn;
    $id_ad = mysqli_real_escape_string($conn, $ad_id);
    $select_all_photos = "select image from images join ads_images on ads_images.id_image = images.id_image where ads_images.id_ad=$id_ad and images.main=false";
    $res = $conn->query($select_all_photos);
    $photos = array();
    while ($photo = $res->fetch_object()) {
        array_push($photos, $photo);
    }
    return $photos;
}


//Funkcija izbere oglas s podanim ID-jem. Doda tudi uporabnika, ki je objavil oglas.
function get_ad($id)
{
    global $conn;
    $id = mysqli_real_escape_string($conn, $id);
    $query = "SELECT ads.* , users.username, users.email, users.mobile_number FROM `ads` JOIN users on users.id_user=ads.id_user where ads.id_ad=$id;";
    $res = $conn->query($query);
    if ($obj = $res->fetch_object()) {
        return $obj;
    }
    return null;
}

function get_image($ad_id)
{
    global $conn;
    $id = mysqli_real_escape_string($conn, $ad_id);
    $select_image = "select image from images join ads_images on images.id_image = ads_images.id_image where ads_images.id_ad = $id and main=true";
    $res = $conn->query($select_image);
    $result = mysqli_fetch_array($res);
    return $result["image"];
}

function get_ads_categories($id_ad){
    global $conn;
    $id_ad=mysqli_escape_string($conn, $id_ad);
    $query = "SELECT categories.* FROM categories JOIN ads_categories ON categories.id_category= ads_categories.id_category WHERE id_ad = $id_ad;";
    $res = $conn->query($query);
    $categories = array();
    while ($category = $res->fetch_object()) {
        array_push($categories, $category);
    }
    return $categories;
}

if (!isset($_GET["id"])) {
    echo "Manjkajoči parametri.";
    die();
}
$id = $_GET["id"];
$ad = get_ad($id);

increase_number_of_views($id);

$ads_categories=get_ads_categories($id);

if ($ad == null) {
    echo display_error("Ad does not exist.");
    die();
}
//Base64 koda za sliko (hexadecimalni zapis byte-ov iz datoteke)
?>
    <div class="container" style="background-color: rgba(146, 176, 195, 0.37); padding: 1%;">
        <div>
            <div class="card" style="background-color: rgba(146, 176, 195, 0.37)">
                <div class="card-image" style=" padding:4% 15%;">
                    <figure class="image is-16by9">
                        <?php
                        echo '<img src="data:image/jpeg;base64,' . base64_encode(get_image($id)) . '"/>';
                        ?>
                    </figure>
                </div>
                <div class="card-content">
                    <div class="media">
                        <div class="media-content">
                            <p class="title is-4"><?php echo $ad->title; ?></p>
                        </div>
                    </div>
                    <div class="content">
                        <p><b>Posted by:</b> <?php echo $ad->username; ?></p>
                        <p><b>User's contact: Email </b><?php echo $ad->email; ?>,<b> Mobile number</b> <?php echo $ad->mobile_number; ?> </p>
                        <p><b>Expiration date:</b> <?php echo $ad->expiration_date; ?></p>
                        <p><b>Number of views:</b> <?php echo $ad->number_of_views; ?></p>
                        <p><b>Categories:</b> <?php foreach ($ads_categories as $ads_category) echo $ads_category->category; ?></p>
                        <b>Description:</b>
                        <div class="block" style="font-style: italic; font-size: 20px;">
                             <p><?php echo $ad->description; ?></p>
                        </div>
                        <a href="index.php">
                            <button class="button is-info">Back</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="block">
            <div class="block">
                <p class="title">Ads gallery</p>
            </div>
            <?php

            $photos = get_all_photos($id);
            $size = count($photos);

            for ($i = 0; $i < $size; $i=$i+2) {
            ?>
                <div class="tile is-ancestor">
                    <div class="tile is-parent">
                        <div class="tile is-child box">
                            <div class="card-image" style=" padding:4% 15%;">
                                <figure class="image is-4by3">
                                    <?php
                                    echo '<img src="data:image/jpeg;base64,' . base64_encode($photos[$i]->image) . '"/>';
                                    if($i+2> $size) break;
                                    ?>
                                </figure>
                            </div>
                        </div>
                    </div>
                    <div class="tile is-parent">
                        <div class="tile is-child box">
                            <div class="card-image" style=" padding:4% 15%;">
                                <figure class="image is-4by3">
                                    <?php
                                    echo '<img src="data:image/jpeg;base64,' . base64_encode($photos[$i+1]->image) . '"/>';
                                    ?>
                                </figure>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    </div>
    </div>
    </div>


<?php

include_once('footer.php');
?>