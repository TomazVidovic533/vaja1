<?php
include_once('header.php');
include_once('messages.php');
// Funkcija preveri, ali v bazi obstaja uporabnik z določenim imenom in vrne true, če obstaja.
function username_exists($username)
{
    global $conn;
    $username = mysqli_real_escape_string($conn, $username);
    $query = "SELECT * FROM users WHERE username='$username'";
    $res = $conn->query($query);
    return mysqli_num_rows($res) > 0;
}

// Funkcija ustvari uporabnika v tabeli users. Poskrbi tudi za ustrezno šifriranje uporabniškega gesla.
function register_user($username, $password, $name, $surname, $address, $postal_code, $gender, $age, $mobile, $email)
{
    global $conn;
    $username = mysqli_real_escape_string($conn, $username);
    $name = mysqli_real_escape_string($conn, $name);
    $surname = mysqli_real_escape_string($conn, $surname);
    $address = mysqli_real_escape_string($conn, $address);
    $postal_code = mysqli_real_escape_string($conn, $postal_code);
    $gender = mysqli_real_escape_string($conn, $gender);
    $age = mysqli_real_escape_string($conn, $age);
    $mobile = mysqli_real_escape_string($conn, $mobile);
    $email= mysqli_real_escape_string($conn, $email);
    $pass = sha1($password);
    /*
        Tukaj za hashiranje gesla uporabljamo sha1 funkcijo. V praksi se priporočajo naprednejše metode, ki k geslu dodajo naključne znake (salt).
        Več informacij:
        http://php.net/manual/en/faq.passwords.php#faq.passwords
        https://crackstation.net/hashing-security.htm
    */

    $query = "INSERT INTO users (username, password, name, surname, address, mobile_number, age, gender, postal_code,email)
        VALUES ('$username', '$pass', '$name', '$surname', '$address', $mobile, $age, '$gender', '$postal_code', '$email');";
    if ($conn->query($query)) {
        return true;
    } else {
        echo mysqli_error($conn);
        return false;
    }
}

$error = "";
if (isset($_POST["poslji"])) {
    /*
        VALIDACIJA: preveriti moramo, ali je uporabnik pravilno vnesel podatke (unikatno uporabniško ime, dolžina gesla,...)
        Validacijo vnesenih podatkov VEDNO izvajamo na strežniški strani. Validacija, ki se izvede na strani odjemalca (recimo Javascript),
        služi za bolj prijazne uporabniške vmesnike, saj uporabnika sproti obvešča o napakah. Validacija na strani odjemalca ne zagotavlja
        nobene varnosti, saj jo lahko uporabnik enostavno zaobide (developer tools,...).
    */
    //Preveri če se gesli ujemata
    checkData($_POST["username"], $_POST["password"], $_POST["repeat_password"], $_POST["name"], $_POST["surname"]
        , $_POST["address"], $_POST["postal_code"], $_POST["gender"], $_POST["age"], $_POST["mobile_number"], $_POST["email"]);

    if ($_POST["password"] != $_POST["repeat_password"]) {
        $error = "Gesli se ne ujemata.";
        echo display_error("Passwords do not match.");
    } //Preveri ali uporabniško ime obstaja
    else if (username_exists($_POST["username"])) {
        $error = "Uporabniško ime je že zasedeno.";
        echo display_error("Username is already taken.");
    } //Podatki so pravilno izpolnjeni, registriraj uporabnika
    else if (register_user($_POST["username"], $_POST["password"], $_POST["name"], $_POST["surname"]
        , $_POST["address"], $_POST["postalcode"], $_POST["gender"],$_POST["age"], $_POST["mobile_number"],  $_POST["email"])) {
        header("Location: login.php");
        die();
    } //Prišlo je do napake pri registraciji
    else {
        echo display_error("Error during registration.");
    }
}

function checkData($username, $password, $rpassword, $name, $surname, $address, $pc, $gender, $age, $mobile)
{
    echo "Podano je bilo $username, $password, $rpassword, $name, $name, $surname, $address, $pc, $gender, $age, $mobile";
}

?>
    <div class="container">
        <div class="notification is-primary">
            <div>
                <h1 class="title is-1" style="margin:20px">Register</h1>
            </div>
            <form action="registration.php" method="POST">
                <div class="field">
                    <p class="control has-icons-left has-icons-right">
                        <input class="input" type="text" name="username" placeholder="Username">
                        <span class="icon is-small is-left"><i class="fas fa-envelope"></i></span>
                    </p>
                </div>

                <div class="field">
                    <p class="control has-icons-left">
                        <input class="input" type="password" name="password" placeholder="Password">
                        <span class="icon is-small is-left"><i class="fas fa-lock"></i></span>
                    </p>
                </div>

                <div class="field">
                    <p class="control has-icons-left">
                        <input class="input" type="password" name="repeat_password" placeholder="Repeat password">
                        <span class="icon is-small is-left"><i class="fas fa-lock"></i></span>
                    </p>
                </div>

                <div class="field">
                    <p class="control has-icons-left has-icons-right">
                        <input class="input" type="text" name="name" placeholder="Your name">
                        <span class="icon is-small is-left"><i class="fas fa-envelope"></i></span>
                    </p>
                </div>

                <div class="field">
                    <p class="control has-icons-left has-icons-right">
                        <input class="input" type="text" name="surname" placeholder="Your surname">
                        <span class="icon is-small is-left"><i class="fas fa-envelope"></i></span>
                    </p>
                </div>

                <div class="field">
                    <p class="control has-icons-left has-icons-right">
                        <input class="input" type="email" name="email" placeholder="Your email">
                        <span class="icon is-small is-left"><i class="fas fa-envelope"></i></span>
                    </p>
                </div>

                <div class="field">
                    <p class="control has-icons-left has-icons-right">
                        <input class="input" type="text" name="address" placeholder="Your address">
                        <span class="icon is-small is-left"><i class="fas fa-envelope"></i></span>
                    </p>
                </div>

                <div class="field">
                    <p class="control has-icons-left has-icons-right">
                        <input class="input" type="text" name="postalcode" placeholder="Postal code">
                        <span class="icon is-small is-left"><i class="fas fa-envelope"></i></span>
                    </p>
                </div>

                <div class="control">
                    <label class="radio">
                        <input type="radio" value="m" name="gender">
                        Male
                    </label>
                    <label class="radio">
                        <input type="radio" value="f" name="gender">
                        Female
                    </label>
                </div>

                <div class="field">
                    <p class="control has-icons-left has-icons-right">
                        <input class="input" type="number" name="age" placeholder="Your age">
                        <span class="icon is-small is-left"><i class="fas fa-envelope"></i></span>
                    </p>
                </div>

                <div class="field">
                    <p class="control has-icons-left has-icons-right">
                        <input class="input" type="number" name="mobile_number" placeholder="Your mobile number">
                        <span class="icon is-small is-left"><i class="fas fa-envelope"></i></span>
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