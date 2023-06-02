<?php
include $_SERVER['DOCUMENT_ROOT'] . "/shared/db.php";
include $_SERVER['DOCUMENT_ROOT'] . "/shared/check-auth.php";
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    // Получение выбранного идентификатора бренда
    $brandId = $_POST['brandId'];
    $staffId = $_POST['staffId'];

    // Здесь вам нужно выполнить логику получения моделей для выбранного бренда из базы данных
    // Предположим, что у вас есть массив $computers, содержащий модели компьютеров для выбранного бренда
    $computers_query = pg_query($dbconn, "SELECT
        models.id AS computer_id,
        computer_brands.brand_name || ' ' || models.model_name AS computer_name,
        models.ram AS computer_ram,
        models.cpu_cores AS computer_cpu_cores
        FROM models
        INNER JOIN computer_brands on models.brand_id = computer_brands.id
        LEFT JOIN staff ON models.id = staff.computer_id
        WHERE (staff.computer_id IS NULL OR staff.id = " . pg_escape_string($staffId) . ") and models.brand_id = $brandId;
    ");
    $computers = pg_fetch_all($computers_query);

    // Генерация массива моделей в формате JSON
    $models = [];
    foreach ($computers as $computer) {
        $model = [
            'id' => $computer['computer_id'],
            'name' => $computer['computer_name'],
            'ram' => $computer['computer_ram'],
            'cpu_cores' => $computer['computer_cpu_cores']
        ];
        $models[] = $model;
    }

    // Возвращение данных в формате JSON
    $response = [
        'models' => $models
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // Если запрос не является AJAX-запросом, возвращаем ошибку
    http_response_code(403);
    echo "Forbidden";
}
?>
