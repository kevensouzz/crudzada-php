<?php
require 'config/database.php';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $email = $_POST['email'];

    $sql = "UPDATE users SET username = :username, email = :email WHERE id = :id";

    if($stmt = $pdo->prepare($sql)) {
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);

        if($stmt->execute()) {
            header('Location: index.php');
            exit();
        } else {
            exit('Error Updating User!');
        }
    }

    unset($stmt);
    unset($pdo);
}