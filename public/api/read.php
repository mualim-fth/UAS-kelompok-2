<?php

require_once '../../app/config/koneksi.php';
require_once '../../app/models/CarModel.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $carModel = new CarModel();
        
        $data = $carModel->getAll();
        
        http_response_code(200);
        echo json_encode([
            'status' => 'success',
            'data'   => $data
        ]);
        
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
} else {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Method Not Allowed']);
}