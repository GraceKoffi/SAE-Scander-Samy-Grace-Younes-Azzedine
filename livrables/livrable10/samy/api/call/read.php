<?php
/*
    Structure JSON avec parametre
    {
        "action" : "methode",
        "model": "type_model",
        "data": {
            --
            --
            --
        }
    }
    ou sans parametre
    {
        "action": "method",
        "model": "type_model" 
    }
*/
// Header
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


function loadModel($modelName) {
    $modelPath = "C:\\wamp64\\www\\api\\models\\$modelName.php";
    if (file_exists($modelPath)) {
        include_once $modelPath;
        $className = ucfirst($modelName);
        return new $className();
    } else {
        http_response_code(405);
        echo json_encode(["message" => "Modèle non trouvé"]);
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data_angular = json_decode(file_get_contents("php://input"));

    if (isset($data_angular->action) && isset($data_angular->model)) {
        $method = $data_angular->action;
        $model = $data_angular->model;

        $modele = loadModel($model);

        if (method_exists($modele, $method)) {
            $data = isset($data_angular->data) ? $data_angular->data : null;
            $resultat = $modele->$method($data);
            $response = ['empty' => empty($resultat), 'data' => $resultat];
            echo json_encode($response);
        } else {
            http_response_code(405);
            echo json_encode(["message" => "La méthode spécifiée n'existe pas dans le modèle"]);
        }
    } else {
        http_response_code(405);
        echo json_encode(["message" => "Champs manquants dans le JSON"]);
    }
} else {
    http_response_code(405);
    echo json_encode(["message" => "La méthode n'est pas autorisée"]);
}
?>

