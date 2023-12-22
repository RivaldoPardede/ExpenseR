<?php

if (isset($_POST['id'])) {
    // Retrieve the item ID from the form
    include 'koneksi.php';
    $id = $_POST['id'];

    // Perform the deletion in the database
    // Example (using PDO):

    $deleteQuery = pg_query($connection, "DELETE FROM transaksi WHERE id = '$id'");

    // Redirect back to the transaction page after deletion
    header("Location: ../../public/php/transaction.php");
    exit();
}
?>