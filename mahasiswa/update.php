<?php
include '../db.php';

header('Content-Type: application/json');

$id = (int) $_POST['id_user'];
$nama    = $_POST['nama_lengkap'];
$email  = $_POST['email'];
$poin  = (int)$_POST['total_point'];
$level = $_POST['level'];


$stmt = $conn->prepare("
    UPDATE users 
    SET nama_lengkap = ?, email = ?, total_point = ?, level = ?
    WHERE id_user = ?
");
$stmt->bind_param("ssisi", $nama, $email, $poin, $level, $id);

if ($stmt->execute()) {

    echo json_encode([
        "status"  => "success",
        "message" => "Data berhasil diperbarui",
        "data"    => [
            "id_user"      => $id,
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
