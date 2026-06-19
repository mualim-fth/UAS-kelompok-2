<?php

if (!session_id()) {
    session_start();
}

require_once __DIR__ . '/../app/config/config.php';


require_once __DIR__ . '/../app/core/Database.php';   
require_once __DIR__ . '/../app/core/Controller.php'; 
require_once __DIR__ . '/../app/core/App.php';       


$app = new App();