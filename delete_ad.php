<?php
include_once('header.php');
include_once('messages.php');
// Funkcija vstavi nov oglas v bazo. Preveri tudi, ali so podatki pravilno izpolnjeni.
// Vrne false, če je prišlo do napake oz. true, če je oglas bil uspešno vstavljen.

$id = isset($_GET['id']);
global $conn;
$id_ad = mysqli_real_escape_string($conn, $_GET['id']);
echo "sadsad".$id_ad;
$delete_ad = "DELETE FROM ads WHERE id_ad=$id_ad";
$conn->query($delete_ad);
header("Location: my_ads.php");

