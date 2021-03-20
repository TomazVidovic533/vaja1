<?php
include_once('header.php');
include_once('messages.php');
// Funkcija vstavi nov oglas v bazo. Preveri tudi, ali so podatki pravilno izpolnjeni. 
// Vrne false, če je prišlo do napake oz. true, če je oglas bil uspešno vstavljen.

function generate_new_expiration_date($new_date)
{

    global $conn;
    $date = mysqli_real_escape_string($conn, $new_date);
    $get_new_date_timestamp = " SELECT TIMESTAMP('$date');";
    $new_timestamp = $conn->query($get_new_date_timestamp);
    return $new_timestamp->fetch_array()[0];
}

function insert_category_for_ad($id_category, $id_ad)
{
    global $conn;
    $id_category = mysqli_real_escape_string($conn, $id_category);
    $insert_ads_categories = "INSERT INTO ads_categories(id_ad, id_category) VALUES ($id_ad, $id_category)";
    if ($conn->query($insert_ads_categories)) {
        return true;
    } else {
        return false;
    }
}

function publish($title, $desc, $img, $given_date, $id_category)
{
    global $conn;
    $title = mysqli_real_escape_string($conn, $title);
    $desc = mysqli_real_escape_string($conn, $desc);
    $date = mysqli_real_escape_string($conn, $given_date);
    $id_category = mysqli_real_escape_string($conn, $id_category);
    $user_id = $_SESSION["USER_ID"];

    $img_file = file_get_contents($img["tmp_name"]);
    $img_file = mysqli_real_escape_string($conn, $img_file);
    $exp_date = generate_new_expiration_date($date);
    $insert_ad = "INSERT INTO ads (title, description, id_user,expiration_date)
				VALUES('$title', '$desc', '$user_id','$exp_date');";

    if ($conn->query($insert_ad)) {
        $ad_id = $conn->insert_id;
        if (!insert_category_for_ad($id_category, $ad_id)) {
            echo display_error("Error occured during inserting ad.");
            die();
        }
        $insert_image = "INSERT INTO images(image, main) VALUES ('$img_file',true) ";
        if ($conn->query($insert_image)) {
            $image_id = $conn->insert_id;
            $insert_ads_images = "INSERT INTO ads_images(id_image, id_ad) VALUES ($image_id,$ad_id) ";
            if ($conn->query($insert_ads_images)) {
                echo display_success("Ad has been succesfully published.");
            } else {
                echo display_error("Uploading photo2 has failed.");
                return false;
            }
        } else {
            echo display_error("Uploading photo has failed.");
            return false;
        }
        return true;
    } else {
        //Izpis MYSQL napake z: echo mysqli_error($conn);
        echo display_error("Error while publishing ad.");
        return false;
    }

    /*
    //Pravilneje bi bilo, da sliko shranimo na disk. Poskrbeti moramo, da so imena slik enolična. V bazo shranimo pot do slike.
    //Paziti moramo tudi na varnost: v mapi slik se ne smejo izvajati nobene scripte (če bi uporabnik naložil PHP kodo). Potrebno je urediti ustrezna dovoljenja (permissions).

        $imeSlike=$photo["name"]; //Pazimo, da je enolično!
        //sliko premaknemo iz začasne poti, v neko našo mapo, zaradi preglednosti
        move_uploaded_file($photo["tmp_name"], "slika/".$imeSlike);
        $pot="slika/".$imeSlike;
        //V bazo shranimo $pot
    */
}

function get_categories()
{
    global $conn;
    $get_categories = "SELECT * FROM categories WHERE id_parent=-1";
    $res = $conn->query($get_categories);
    $categories = array();
    while ($category = $res->fetch_object()) {
        array_push($categories, $category);
    }
    return $categories;
}

$error = "";
if (isset($_POST["poslji"])) {
    if (publish($_POST["title"], $_POST["description"], $_FILES["image"], $_POST["date"], $_POST["category"])) {
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
                <h1 class="title is-1" style="margin:20px">Publish new ad</h1>
            </div>
            <form action="publish.php" method="POST" enctype="multipart/form-data">
                <div class="field">
                    <p class="control has-icons-left has-icons-right">
                        <input class="input" type="text" name="title" placeholder="Title">
                        <span class="icon is-small is-left"><i class="fas fa-envelope"></i></span>
                    </p>
                </div>

                <div class="field">
                    <p class="control has-icons-left">
                        <input class="textarea" type="textarea" name="description" placeholder="Description">
                        <span class="icon is-small is-left"><i class="fas fa-lock"></i></span>
                    </p>
                </div>

                <div class="field">
                    <p class="control has-icons-left">
                        <input class="date" type="date" name="date" placeholder="Choose expiration date">
                        <span class="icon is-small is-left"><i class="fas fa-lock"></i></span>
                    </p>
                </div>

                <div class="select block">
                    <select name="category">
                        <?php
                        $categories = get_categories();
                        foreach ($categories as $category) {
                            echo "<option value='$category->id_category'>$category->category</option>";
                        } ?>
                    </select>
                </div>


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

                <div class="field">
                    <p class="control">
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