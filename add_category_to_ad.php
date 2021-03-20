<?php
include_once('header.php');
include_once('messages.php');

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

function insert_ads_categories($category_id, $ad_id)
{
    global $conn;
    $id_ad = mysqli_real_escape_string($conn, $ad_id);
    $category_id = mysqli_real_escape_string($conn, $category_id);
    $insert_ads_categories = "INSERT INTO ads_categories (id_category, id_ad) VALUES ($category_id,$id_ad)";
    if ($conn->query($insert_ads_categories)) {
        echo display_success("Image has been succefully added.");
        return true;
    } else {
        echo display_error("Uploading photo2 has failed.");
        return false;
    }
}


$error = "";
if (isset($_POST["poslji"])) {
    if (insert_ads_categories($_POST["category"], $_POST["ad_id"])) {
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
            <form action="add_category_to_ad.php" method="POST" enctype="multipart/form-data">

                <div class="select">
                    <select name="ad_id">
                        <?php
                        $ads = get_my_ads();
                        foreach ($ads as $ad) {
                            echo "<option value='$ad->id_ad'>$ad->title</option>";
                        } ?>
                    </select>
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

                <div class="field">
                    <p class="control">
                    <div class="block"></div>
                    <input type="submit" class="button is-info is-light" name="poslji" value="Pošlji"/>
                    </p>
                </div>
        </div>
        </form>
    </div>
    </div>


<?php
include_once('footer.php');
?>