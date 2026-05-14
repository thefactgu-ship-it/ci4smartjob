<?php

function thai_date($date)
{
    $monthNames = [
        1 => 'มกราคม',
        2 => 'กุมภาพันธ์',
        3 => 'มีนาคม',
        4 => 'เมษายน',
        5 => 'พฤษภาคม',
        6 => 'มิถุนายน',
        7 => 'กรกฎาคม',
        8 => 'สิงหาคม',
        9 => 'กันยายน',
        10 => 'ตุลาคม',
        11 => 'พฤศจิกายน',
        12 => 'ธันวาคม',
    ];

    $dateTime = new DateTime($date);
    $day = $dateTime->format('j');
    $month = $monthNames[(int)$dateTime->format('n')];
    $year = $dateTime->format('Y') + 543;

    return "{$day} {$month} {$year}";
}

function calculate_age($birthDate)
{
    $birthDate = new DateTime($birthDate);
    $currentDate = new DateTime();
    $age = $currentDate->diff($birthDate);

    return $age->y; // Return age in years
}

