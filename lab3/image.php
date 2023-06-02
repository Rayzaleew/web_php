<?php
include $_SERVER['DOCUMENT_ROOT'] . "/shared/db.php";

$staff_query = pg_query($dbconn, "SELECT
    department.id AS department_id,
    department.name AS department_name,
    COUNT(staff.id) AS num_employees
    FROM staff
    INNER JOIN room ON staff.room_id = room.id
    INNER JOIN department ON room.department_id = department.id
    GROUP BY department.id, department.name
    ORDER BY department.id ASC");

$staff = pg_fetch_all($staff_query);

$size_x = 400;
$size_y = 200;
$im = @imagecreate($size_x, $size_y) or die("Can't initialize GD");

$bg_color = imagecolorallocate($im, 255, 255, 255);
$text_color = imagecolorallocate($im, 0, 0, 0);

$max_num_employees = max(array_column($staff, 'num_employees'));
$bar_gap = 10;
$bar_width = ($size_x - ($bar_gap * (count($staff) - 1))) / count($staff);
$x = 0;
foreach ($staff as $s) {
    $bar_height = $s['num_employees'] / $max_num_employees * ($size_y - 20);
    $y = $size_y - $bar_height;

    $bar_color = imagecolorallocate(
        $im,
        $s['department_id'] * 10,
        $s['department_id'] * 50,
        $s['department_id'] * 10
    );
    imagefilledrectangle($im, $x, $y, $x + $bar_width, 299, $bar_color);
    // $font_id = imageloadfont("arial.ttf");
    putenv('GDFONTPATH=' . realpath('.'));
    $font = "arial";
    imagettftext($im, 14, 0, $x + $bar_width / 2 - 25, $y - 5, $text_color, $font , $s['num_employees'] . ' сотр.');
    // imagestring($im, $font_id, $x + $bar_width / 2, $y - 15, $s['num_employees'] . 'людей', $text_color);
    $x += $bar_width + $bar_gap;
}

header('Content-type: image/png');
header('cache-control: no-cache, must-revalidate');
imagepng($im);
imagedestroy($im);
?>