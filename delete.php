<?php
require 'config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    $sql = "DELETE FROM users WHERE id = :id";

    if ($stmt = $pdo->prepare($sql)) {
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            header('Location: index.php');
            exit();
        } else {
            exit('Error Deleting User!');
        }
    }

    unset($stmt);
    unset($pdo);
}