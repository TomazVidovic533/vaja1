<?php
include_once('header.php');
include_once('messages.php');
// Funkcija vstavi nov oglas v bazo. Preveri tudi, ali so podatki pravilno izpolnjeni.
// Vrne false, če je prišlo do napake oz. true, če je oglas bil uspešno vstavljen.

function get_my_ads()
{

    global $conn;
    $user_id = $_SESSION["USER_ID"];
    $select_my_ads = "SELECT `id_ad`, `title` FROM `ads` WHERE id_user=$user_id";
    $res = $conn->query($select_my_ads);
    $ads = array();
    while ($ad = $res->fetch_object()) {
        array_push($ads, $ad);
    }
    return $ads;
}

function insert_image($image, $ad_id)
{
    global $conn;
    $img = file_get_contents($image["tmp_name"]);
    $img_file = mysqli_real_escape_string($conn, $img);
    $id_ad = mysqli_real_escape_string($conn, $ad_id);
    $insert_image = "INSERT INTO images(image, main) VALUES ('$img_file',false) ";
    if ($conn->query($insert_image)) {
        $image_id = $conn->insert_id;
        $insert_ads_images = "INSERT INTO ads_images(id_image, id_ad) VALUES ($image_id,$id_ad) ";
        if ($conn->query($insert_ads_images)) {
            echo display_success("Image has been succefully added.");
            return true;
        } else {
            echo display_error("Uploading photo2 has failed.");
            return false;
        }
        return $conn->insert_id;
    } else {
        echo display_error("Error while publishing ad.");
        return false;
    }
}


$error = "";
if (isset($_POST["poslji"])) {
    if (insert_image($_FILES["image"], $_POST["select_ad_id"])) {
        header("Location: my_ads.php");
        die();
    } else {
        echo display_error("There has been error while publishing ad. Try again.");
    }
}
?>

    <div class="container">
        <div class="notification is-primary">
            <div>
                <h1 class="title is-1" style="margin:20px">Add another image to ad</h1>
            </div>
            <form action="add_image_to_ad.php" method="POST" enctype="multipart/form-data">

                <div class="field file">
                    <label class="file-label">
                        <input class="file-input" type="file" name="image">
                        <span class="file-cta">
                      <span class="file-icon">
                        <i class="fas fa-upload"></i>
                      </span>
                      <span class="file-label">
                        Choose a file…
                      </span>
                    </span>
                    </label>
                </div>
                <div class="select">
                    <select name="select_ad_id">
                        <?php
                        $ads = get_my_ads();
                        foreach ($ads as $ad) {
                            echo "<option value='$ad->id_ad'>$ad->title</option>";
                        } ?>
                    </select>
                </div>

                <div class="field">
                    <p class="control">
                    <div class="block"></div>
                    <input type="submit" class="button is-info is-light" name="poslji" value="Pošlji"/>
                    </p>
                    <p>
                        <label><?php echo $error; ?></label>
                    </p>
                </div>
        </div>
        </form>
    </div>
    </div>


<?php
include_once('footer.php');
?>