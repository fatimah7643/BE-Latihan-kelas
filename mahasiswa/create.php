<?php
include_once '../db.php';

header('Content-Type: application/json');


$id = (int) $_POST['id_user'];
$nama    = $_POST['nama_lengkap'];
$email  = $_POST['email'];
$poin  = (int)$_POST['total_point'];
$level = $_POST['level'];


$stmt = $conn->prepare("
    INSERT INTO users (id_user, nama_lengkap, email, total_point, level)
    VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("issis", $id, $nama, $email, $poin, $level);

if ($stmt->execute()) {

    echo json_encode([
        "status"  => "success",
        "message" => "User berhasil ditambahkan",
        "data"    => [
            "id" => $id,
            "nama_lengkap" => $nama,
            "email"        => $email,
            "total_point"  => $poin,
            "level"        => $level
        ]
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
