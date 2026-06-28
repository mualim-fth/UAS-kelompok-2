<?php
// Lokasi: public/api/delete.php

require_once '../../app/config/koneksi.php';
require_once '../../app/models/CarModel.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: DELETE');

// Memastikan metode yang digunakan adalah DELETE (atau bisa POST sesuai settingan klien)
if ($_SERVER['REQUEST_METHOD'] === 'DELETE' || $_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Skrip memindai muatan JSON untuk mencari id_mobil
    $input = json_decode(file_get_contents('php://input'), true);

    // Jika klien mengakses tanpa melampirkan ID
    if (empty($input['id_mobil'])) {
        // Eksekusi dicegat dan server merespons dengan Status Code 400 (Bad Request)
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'Parameter id_mobil wajib disertakan untuk menghapus data']);
        exit;
    }

    try {
        $carModel = new CarModel();
        $id = $input['id_mobil'];
        
        // Model mengeksekusi perintah penghapusan
        $carModel->delete($id);
        
        // Apabila data terhapus, server mengembalikan Status Code 200 (OK)
        http_response_code(200);
        echo json_encode(['status' => 'success', 'message' => 'Data mobil berhasil dihapus secara permanen']);
        
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
} else {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Method Not Allowed. Gunakan DELETE.']);
}