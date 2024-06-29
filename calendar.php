<?php
$month = isset($_GET['month']) ? (int)$_GET['month'] : date('m');
$year = isset($_GET['year']) ? (int)$_GET['year'] : date('Y');

$daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
$firstDayOfMonth = date('N', strtotime("$year-$month-01"));

echo "<div class='calendar-grid'>";
for ($i = 1; $i < $firstDayOfMonth; $i++) {
    echo "<button disabled></button>";
}

for ($day = 1; $day <= $daysInMonth; $day++) {
    $date = sprintf("%04d-%02d-%02d", $year, $month, $day);
    echo "<button class='calendar-day' data-day='$day' data-month='$month' data-year='$year'>$day</button>";
}

echo "</div>";
?>
