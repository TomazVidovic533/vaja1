<?php
include_once('header.php');
include_once('messages.php');
function validate_login($username, $password)
{
    global $conn;
    $username = mysqli_real_escape_string($conn, $username);
    $pass = sha1($password);
    $query = "SELECT * FROM users WHERE username='$username' AND password='$pass'";
    $res = $conn->query($query);
    if ($user_obj = $res->fetch_object()) {
        return $user_obj->id_user;
    }
    return -1;
}

function get_username($user_id)
{
    global $conn;
    $query = "SELECT username FROM users WHERE id_user=$user_id";
    $res = $conn->query($query);
    $res_obj = $res->fetch_object();
    return $res_obj->username;
}

$error = "";
if (isset($_POST["poslji"])) {
    //Preveri prijavne podatke
    if (($user_id = validate_login($_POST["username"], $_POST["password"])) >= 0) {
        //Zapomni si prijavljenega uporabnika v seji in preusmeri na index.php
        $_SESSION["USER_ID"] = $user_id;
        $username = get_username($user_id);
        setcookie("user", $username, time() + (86400), "/");
        header("Location: index.php");
        die();
    } else {
        echo display_error("Login has failed. Try again.");
    }
}
?>

    <div class="container">
        <div class="notification is-primary">
            <div>
                <h1 class="title is-1" style="margin:20px">Login</h1>
            </div>
            <form action="login.php" method="POST">
                <div class="field">
                    <p class="control has-icons-left has-icons-right">
                        <input class="input" type="text" name="username" placeholder="Username">
                        <span class="icon is-small is-left">
    </span>
                        <span class="icon is-small is-right">
    </span>
                    </p>
                </div>
                <div class="field">
                    <p class="control has-icons-left">
                        <input class="input" type="password" name="password" placeholder="Password">
                        <span class="icon is-small is-left">
    </span>
                    </p>
                </div>
                <div class="field">
                    <p class="control">
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