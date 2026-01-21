<?php
include '../db.php';

header('Content-Type: application/json');

$data = [];

if (isset($_GET['id_user']) || isset($_GET['id'])) {

    if (isset($_GET['id_user'])) {
        $nim = $_GET['id_user'];
        $stmt = $conn->prepare("SELECT * FROM users WHERE id_user = ?");
        $stmt->bind_param("s", $nim);
    } else {
        $id = $_GET['id'];
        $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    $stmt->close();

} else {

    // Ambil semua data
    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);

    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

echo json_encode([
    "status"  => "success",
    "message" => count($data) > 0 ? "Data ditemukan" : "Data kosong",
    "data"    => $data
]);

$conn->close();
?>
