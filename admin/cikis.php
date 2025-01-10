<?php 

require '../db/baglanti.php';

session_start();

if (isset($_SESSION['admin'])) {
    session_destroy();
    header('Location: admin-login.php');
} else {
    header('Location: ../index.php');
}

?>