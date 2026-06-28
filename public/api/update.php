<?php

require_once '../../app/config/koneksi.php';
require_once '../../app/models/CarModel.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: PUT');

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $input = json_decode(file_get_contents('php://input'), true);

    if (empty($input['id_mobil'])) {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'ID Mobil (id_mobil) wajib disertakan untuk update']);
        exit;
    }

    try {
        $carModel = new CarModel();
        
        $id = $input['id_mobil'];
        
        $carModel->update($id, $input);
        
        http_response_code(200);
        echo json_encode(['status' => 'success', 'message' => 'Data mobil berhasil diperbarui']);
        
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
} else {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Method Not Allowed. Gunakan PUT.']);
}