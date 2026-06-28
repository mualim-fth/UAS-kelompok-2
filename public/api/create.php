<?php
// Lokasi: public/api/create.php

require_once '../../app/config/koneksi.php';
require_once '../../app/models/CarModel.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Menangkap Payload JSON mentah dari Postman
    $input = json_decode(file_get_contents('php://input'), true);

    // Validasi kolom wajib agar sistem tidak error
    if (empty($input['merk']) || empty($input['tipe']) || empty($input['harga_per_hari'])) {
        // Menolak operasi jika data kosong (Status 400 Bad Request)
        http_response_code(400); 
        echo json_encode(['status' => 'error', 'message' => 'Kolom wajib tidak terpenuhi!']); // [cite: 27]
        exit;
    }

    try {
        $carModel = new CarModel();
        $carModel->create($input);
        
        // Mengembalikan HTTP 201 Created beserta pesan konfirmasi
        http_response_code(201);
        echo json_encode(['status' => 'success', 'message' => 'Data mobil berhasil ditambahkan']); // [cite: 26]
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}