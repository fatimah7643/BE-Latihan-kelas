<?php
include '../db.php';
header('Content-Type: application/json');

$data = [];

// Cek apakah ada parameter id_quiz di URL
if (isset($_GET['id_quiz'])) {
    $id_quiz = $_GET['id_quiz'];
    
    // Query dengan filter WHERE
    $stmt = $conn->prepare("
        SELECT quizzes.id_quiz, quizzes.pertanyaan, materials.judul AS judul_material, materials.tipe 
        FROM quizzes 
        INNER JOIN materials ON quizzes.id_material = materials.id_material 
        WHERE quizzes.id_quiz = ?
    ");
    $stmt->bind_param("i", $id_quiz);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    // Jika tidak ada parameter, ambil semua data seperti sebelumnya
    $sql = "SELECT quizzes.id_quiz, quizzes.pertanyaan, materials.judul AS judul_material, materials.tipe 
            FROM quizzes 
            INNER JOIN materials ON quizzes.id_material = materials.id_material";
    $result = $conn->query($sql);
}

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode([
    "status"  => "success",
    "message" => count($data) > 0 ? "Data ditemukan" : "Data tidak ditemukan",
    "data"    => $data
]);

$conn->close();
?>