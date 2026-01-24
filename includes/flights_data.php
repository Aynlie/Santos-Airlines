<?php
// ================================
//  FLIGHT DATA - Flight Schedule
// ================================
// Organized flight details for Domestic (Asia/Manila) and International flights
// Each flight entry includes airline, route, timezone info, departure time, and duration.
// Arrival will be computed in the main page using PHP DateTime & DateInterval.
// ================================

// ------------------------------
// Domestic Flights (Philippines)
// ------------------------------
$domesticFlights = [
    [
        "flightNo"        => "PR 2831",
        "airline"         => "Philippine Airlines",
        "origin"          => "Manila (MNL)",
        "destination"     => "Cebu (CEB)",
        "originTZ"        => "Asia/Manila",
        "destTZ"          => "Asia/Manila",
        "departure"       => date("Y-m-d") . " 07:30",
        "durationMinutes" => 85,
        "image"           => "img/cebu.png",
        "status"          => "Arrived"
    ],
    [
        "flightNo"        => "Z2 221",
        "airline"         => "AirAsia Philippines",
        "origin"          => "Manila (MNL)",
        "destination"     => "Davao (DVO)",
        "originTZ"        => "Asia/Manila",
        "destTZ"          => "Asia/Manila",
        "departure"       => date("Y-m-d") . " 09:00",
        "durationMinutes" => 110,
        "image"           => "img/davao.png",
        "status"          => "On Time"
    ],
    [
        "flightNo"        => "5J 633",
        "airline"         => "Cebu Pacific",
        "origin"          => "Clark (CRK)",
        "destination"     => "Puerto Princesa (PPS)",
        "originTZ"        => "Asia/Manila",
        "destTZ"          => "Asia/Manila",
        "departure"       => date("Y-m-d") . " 10:10",
        "durationMinutes" => 95,
        "image"           => "img/puertoprincesa.jpg",
        "status"          => "Boarding"
    ],
    [
        "flightNo"        => "DG 6415",
        "airline"         => "Cebgo",
        "origin"          => "Manila (MNL)",
        "destination"     => "Iloilo (ILO)",
        "originTZ"        => "Asia/Manila",
        "destTZ"          => "Asia/Manila",
        "departure"       => date("Y-m-d") . " 14:45",
        "durationMinutes" => 70,
        "image"           => "img/iloilo.png",
        "status"          => "On Time"
    ],
    [
        "flightNo"        => "PR 2545",
        "airline"         => "Philippine Airlines",
        "origin"          => "Manila (MNL)",
        "destination"     => "Tacloban (TAC)",
        "originTZ"        => "Asia/Manila",
        "destTZ"          => "Asia/Manila",
        "departure"       => date("Y-m-d") . " 17:20",
        "durationMinutes" => 65,
        "image"           => "img/tacloban.png",
        "status"          => "Departed"
    ]
];

// ------------------------------
// International Flights
// ------------------------------
$intlFlights = [
    [
        "flightNo"        => "PR 432",
        "airline"         => "Philippine Airlines",
        "origin"          => "Manila (MNL)",
        "destination"     => "Tokyo (HND)",
        "originTZ"        => "Asia/Manila",
        "destTZ"          => "Asia/Tokyo",
        "departure"       => date("Y-m-d") . " 06:30",
        "durationMinutes" => 240,
        "image"           => "img/tokyo.png",
        "status"          => "On Time"
    ],
    [
        "flightNo"        => "SQ 919",
        "airline"         => "Singapore Airlines",
        "origin"          => "Manila (MNL)",
        "destination"     => "Singapore (SIN)",
        "originTZ"        => "Asia/Manila",
        "destTZ"          => "Asia/Singapore",
        "departure"       => date("Y-m-d") . " 09:45",
        "durationMinutes" => 225,
        "image"           => "img/singapore.png",
        "status"          => "Boarding"
    ],
    [
        "flightNo"        => "BA 142",
        "airline"         => "British Airways",
        "origin"          => "Manila (MNL)",
        "destination"     => "London (LHR)",
        "originTZ"        => "Asia/Manila",
        "destTZ"          => "Europe/London",
        "departure"       => date("Y-m-d") . " 12:00",
        "durationMinutes" => 800,
        "image"           => "img/london.png",
        "status"          => "On Time"
    ],
    [
        "flightNo"        => "QF 20",
        "airline"         => "Qantas Airways",
        "origin"          => "Manila (MNL)",
        "destination"     => "Sydney (SYD)",
        "originTZ"        => "Asia/Manila",
        "destTZ"          => "Australia/Sydney",
        "departure"       => date("Y-m-d") . " 19:30",
        "durationMinutes" => 480,
        "image"           => "img/sydney.png",
        "status"          => "Arrived"
    ],
    [
        "flightNo"        => "KE 624",
        "airline"         => "Korean Air",
        "origin"          => "Manila (MNL)",
        "destination"     => "Seoul (ICN)",
        "originTZ"        => "Asia/Manila",
        "destTZ"          => "Asia/Seoul",
        "departure"       => date("Y-m-d") . " 23:10",
        "durationMinutes" => 230,
        "image"           => "img/seoul.png",
        "status"          => "Departed"
    ]
];