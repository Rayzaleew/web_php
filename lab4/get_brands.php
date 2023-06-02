<?php
include $_SERVER['DOCUMENT_ROOT'] . "/shared/db.php";
include $_SERVER['DOCUMENT_ROOT'] . "/shared/check-auth.php";
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    // Получение выбранного идентификатора бренда
    // Здесь вам нужно выполнить логику получения моделей для выбранного бренда из базы данных
    // Предположим, что у вас есть массив $computers, содержащий модели компьютеров для выбранного бренда
    $computers_query = pg_query($dbconn, "
        select * from computer_brands;
    ");
    $computers = pg_fetch_all($computers_query);

    // Генерация массива моделей в формате JSON
    $brands = [];
    foreach ($computers as $brand) {
        $brand = [
            'id' => $brand['id'],
            'brand_name' => $brand['brand_name'],
        ];
        $brands[] = $brand;
    }

    // Возвращение данных в формате JSON
    $response = [
        'brands' => $brands
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // Если запрос не является AJAX-запросом, возвращаем ошибку
    http_response_code(403);
    echo "Forbidden";
}
?>
