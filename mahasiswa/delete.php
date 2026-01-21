<?php
include '../db.php';

header('Content-Type: application/json');

$id = $_POST['id_user'];

$stmt = $conn->prepare("DELETE FROM users WHERE id_user = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {

    echo json_encode([
        "status"  => "success",
        "message" => "akun berhasil dihapus",
    ]);

} else {

    echo json_encode([
        "status"  => "error",
        "message" => $stmt->error
    ]);

}

$stmt->close();
$conn->close();
?>
