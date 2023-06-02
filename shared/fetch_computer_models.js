$(document).ready(function() {
    
    loadBrands();
    var params = new URLSearchParams(window.location.search);
    var id = "-1";
    if (params.has('id')) {
        id = params.get('id');
        console.log('Значение параметра id: ' + id);
    }
    // Обработчик события выбора бренда
    $('#brandSelect').on('change', function() {
        var brandId = $(this).val();
        
        // AJAX-запрос к серверу
        $.ajax({
            url: 'get_models.php',
            method: 'POST',
            data: { brandId: brandId , staffId: id},
            dataType: 'json',
            success: function(response) {
                // Вывод полученных данных в таблицу
                console.log(response.models);
                var modelsTable = generateModelsTable(response.models);
                $('#modelsTable').html(modelsTable);
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    });
});

function loadBrands() {
    // AJAX-запрос к серверу
    $.ajax({
        url: 'get_brands.php',
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            // Очистка существующих опций
            $('#brandSelect').empty();
            console.log(response);
            
            // Добавление новых опций на основе полученных данных
            for (var i = 0; i < response.brands.length; i++) {
                var brand = response.brands[i];
                $('#brandSelect').append('<option value="' + brand.id + '">' + brand.brand_name + '</option>');
            }
        },
        error: function(xhr, status, error) {
            console.log(error);
        }
    });
}

// Функция для генерации таблицы моделей
function generateModelsTable(models) {
    var tableHtml = '<table class="mb-2">';
    tableHtml += '<tr>';
    tableHtml += '<th></th>';
    tableHtml += '<th>Номер</th>';
    tableHtml += '<th>Имя</th>';
    tableHtml += '<th>ОЗУ</th>';
    tableHtml += '<th>Количество ядер</th>';
    tableHtml += '</tr>';

    for (var i = 0; i < models.length; i++) {
        var model = models[i];
        tableHtml += '<tr>';
        tableHtml += '<td><input type="radio" name="computer" value="' + model.id + '"></td>';
        tableHtml += '<td>' + model.id + '</td>';
        tableHtml += '<td>' + model.name + '</td>';
        tableHtml += '<td>' + model.ram + '</td>';
        tableHtml += '<td>' + model.cpu_cores + '</td>';
        tableHtml += '</tr>';
    }

    tableHtml += '</table>';

    return tableHtml;
}
