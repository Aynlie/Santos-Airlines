<?php
// Include flight data from separate file
require_once 'includes/flights_data.php';

// Convert and merge flight data to unified format
$flights = [];

// Process domestic flights
foreach ($domesticFlights as $flight) {
    $flights[] = [
        'flightNo' => $flight['flightNo'],
        'airline' => $flight['airline'],
        'origin' => $flight['origin'],
        'destination' => $flight['destination'],
        'originTZ' => $flight['originTZ'],
        'destTZ' => $flight['destTZ'],
        'dep' => $flight['departure'] . ':00', // Add seconds
        'duration' => $flight['durationMinutes'],
        'type' => 'domestic',
        'image' => isset($flight['image']) ? $flight['image'] : 'https://via.placeholder.com/500x300/fff2f7/b41e74?text=✈️+Flight',
        'status' => isset($flight['status']) ? $flight['status'] : 'On Time'
    ];
}

// Process international flights
foreach ($intlFlights as $flight) {
    $flights[] = [
        'flightNo' => $flight['flightNo'],
        'airline' => $flight['airline'],
        'origin' => $flight['origin'],
        'destination' => $flight['destination'],
        'originTZ' => $flight['originTZ'],
        'destTZ' => $flight['destTZ'],
        'dep' => $flight['departure'] . ':00', // Add seconds
        'duration' => $flight['durationMinutes'],
        'type' => 'international',
        'image' => isset($flight['image']) ? $flight['image'] : 'https://via.placeholder.com/500x300/fff2f7/b41e74?text=✈️+Flight',
        'status' => isset($flight['status']) ? $flight['status'] : 'On Time'
    ];
}

// Function to process flight data and calculate times
function processFlight($flight) {
    // Create DateTimeZone objects
    $originTZ = new DateTimeZone($flight['originTZ']);
    $destTZ = new DateTimeZone($flight['destTZ']);
    
    // Create DateTime object for departure
    $departure = new DateTime($flight['dep'], $originTZ);
    
    // Use modify() to add duration (using DateInterval)
    $arrival = clone $departure;
    $interval = new DateInterval('PT' . $flight['duration'] . 'M');
    $arrival->add($interval);
    
    // Convert arrival to destination timezone
    $arrival->setTimezone($destTZ);
    
    // Calculate duration using diff()
    $durationDiff = $departure->diff($arrival);
    $durationHours = $durationDiff->h;
    $durationMinutes = $durationDiff->i;
    
    // Format times
    $depFormatted = $departure->format('M d, Y h:i A');
    $arrFormatted = $arrival->format('M d, Y h:i A');
    
    // Get current time for countdown and status
    $now = new DateTime('now', $originTZ);
    
    // Calculate minutes until departure
    $countdown = null;
    if ($departure > $now) {
        $diff = $now->diff($departure);
        $countdown = ($diff->days * 24 * 60) + ($diff->h * 60) + $diff->i;
    }
    
    // Determine status - use provided status if available, otherwise calculate
    $status = isset($flight['status']) ? $flight['status'] : 'On Time';
    $statusClass = 'status-on-time';
    
    // Map status to CSS class
    if (isset($flight['status'])) {
        $statusLower = strtolower($flight['status']);
        if ($statusLower === 'arrived') {
            $statusClass = 'status-arrived';
        } elseif ($statusLower === 'departed') {
            $statusClass = 'status-departed';
        } elseif ($statusLower === 'boarding') {
            $statusClass = 'status-boarding';
        } elseif ($statusLower === 'on time') {
            $statusClass = 'status-on-time';
        }
    } else {
        // Calculate status if not provided
        if ($countdown !== null) {
            if ($countdown <= 0) {
                $status = 'Departed';
                $statusClass = 'status-departed';
            } elseif ($countdown <= 30) {
                $status = 'Boarding';
                $statusClass = 'status-boarding';
            }
        }
    }
    
    return [
        'flightNo' => $flight['flightNo'],
        'airline' => $flight['airline'],
        'origin' => $flight['origin'],
        'destination' => $flight['destination'],
        'departure' => $depFormatted,
        'arrival' => $arrFormatted,
        'duration' => $durationHours . 'h ' . $durationMinutes . 'm',
        'originTZ' => $flight['originTZ'],
        'destTZ' => $flight['destTZ'],
        'countdown' => $countdown,
        'status' => $status,
        'statusClass' => $statusClass,
        'type' => $flight['type'],
        'image' => isset($flight['image']) ? $flight['image'] : 'https://via.placeholder.com/500x300/fff2f7/b41e74?text=✈️+Flight'
    ];
}

// Process all flights
$processedFlights = array_map('processFlight', $flights);

// Separate domestic and international
$domesticFlights = array_filter($processedFlights, function($f) {
    return $f['type'] === 'domestic';
});

$internationalFlights = array_filter($processedFlights, function($f) {
    return $f['type'] === 'international';
});

// Get current time in different timezones (Bonus feature)
$otherTimezones = [
    ['name' => 'Asia/Manila', 'label' => 'Manila, Philippines'],
    ['name' => 'Asia/Tokyo', 'label' => 'Tokyo, Japan'],
    ['name' => 'Asia/Singapore', 'label' => 'Singapore']
];

$timezoneTimes = [];
foreach ($otherTimezones as $tz) {
    $dt = new DateTime('now', new DateTimeZone($tz['name']));
    $timezoneTimes[] = [
        'label' => $tz['label'],
        'time' => $dt->format('h:i A'),
        'date' => $dt->format('M d, Y'),
        'timezone' => $tz['name']
    ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flight Schedule - Domestic & International</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header class="main-header">
        <h1> Jaynielilies Flight Schedule</h1>
        <p>Domestic & International Flights</p>
    </header>

    <main>
        <!-- Domestic Flights Section -->
        <div class="section-header">
            <h2>🇵🇭 Domestic Flights (Philippines)</h2>
        </div>
        <div class="flights-grid">
            <?php foreach ($domesticFlights as $flight): ?>
            <div class="flight-card">
                <div class="card-image">
                    <img src="<?php echo htmlspecialchars($flight['image']); ?>" alt="<?php echo htmlspecialchars($flight['airline'] . ' - ' . $flight['flightNo']); ?>" onerror="this.onerror=null; this.src='https://via.placeholder.com/500x300/fff2f7/b41e74?text=✈️+Flight';">
                    <div class="card-image-overlay">
                        <div class="card-image-text">
                            <h3 class="card-image-title"><?php echo htmlspecialchars($flight['flightNo']); ?></h3>
                            <p class="card-image-subtitle"><?php echo htmlspecialchars($flight['airline']); ?></p>
                        </div>
                        <a href="#" class="card-image-button">View Details</a>
                    </div>
                </div>
                <div class="card-content">
                    <h4 class="flight-route-title"><?php echo htmlspecialchars($flight['origin'] . ' → ' . $flight['destination']); ?></h4>
                    <p class="flight-route-subtitle"><?php echo htmlspecialchars($flight['airline']); ?></p>
                    
                    <div class="route">
                        <div class="route-city"><?php echo htmlspecialchars($flight['origin']); ?></div>
                        <div class="route-arrow">→</div>
                        <div class="route-city"><?php echo htmlspecialchars($flight['destination']); ?></div>
                    </div>
                    
                    <div class="flight-times">
                        <div class="time-row">
                            <span class="time-label">Departure</span>
                            <div class="time-value"><?php echo htmlspecialchars($flight['departure']); ?></div>
                            <div class="timezone"><?php echo htmlspecialchars($flight['originTZ']); ?></div>
                        </div>
                        <div class="time-row">
                            <span class="time-label">Arrival</span>
                            <div class="time-value"><?php echo htmlspecialchars($flight['arrival']); ?></div>
                            <div class="timezone"><?php echo htmlspecialchars($flight['destTZ']); ?></div>
                        </div>
                    </div>
                    
                    <div class="duration">
                        Duration: <?php echo htmlspecialchars($flight['duration']); ?>
                    </div>
                    
                    <?php if ($flight['countdown'] !== null && $flight['countdown'] > 0): ?>
                    <div class="countdown">
                        Departs in <?php echo $flight['countdown']; ?> minutes
                    </div>
                    <?php endif; ?>
                    
                    <div class="status-badge <?php echo $flight['statusClass']; ?>">
                        <?php echo htmlspecialchars($flight['status']); ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- International Flights Section -->
        <div class="section-header">
            <h2> International Flights</h2>
        </div>
        <div class="flights-grid">
            <?php foreach ($internationalFlights as $flight): ?>
            <div class="flight-card">
                <div class="card-image">
                    <img src="<?php echo htmlspecialchars($flight['image']); ?>" alt="<?php echo htmlspecialchars($flight['airline'] . ' - ' . $flight['flightNo']); ?>" onerror="this.onerror=null; this.src='https://via.placeholder.com/500x300/fff2f7/b41e74?text=✈️+Flight';">
                    <div class="card-image-overlay">
                        <div class="card-image-text">
                            <h3 class="card-image-title"><?php echo htmlspecialchars($flight['flightNo']); ?></h3>
                            <p class="card-image-subtitle"><?php echo htmlspecialchars($flight['airline']); ?></p>
                        </div>
                        <a href="#" class="card-image-button">View Details</a>
                    </div>
                </div>
                <div class="card-content">
                    <h4 class="flight-route-title"><?php echo htmlspecialchars($flight['origin'] . ' → ' . $flight['destination']); ?></h4>
                    <p class="flight-route-subtitle"><?php echo htmlspecialchars($flight['airline']); ?></p>
                    
                    <div class="route">
                        <div class="route-city"><?php echo htmlspecialchars($flight['origin']); ?></div>
                        <div class="route-arrow">→</div>
                        <div class="route-city"><?php echo htmlspecialchars($flight['destination']); ?></div>
                    </div>
                    
                    <div class="flight-times">
                        <div class="time-row">
                            <span class="time-label">Departure</span>
                            <div class="time-value"><?php echo htmlspecialchars($flight['departure']); ?></div>
                            <div class="timezone"><?php echo htmlspecialchars($flight['originTZ']); ?></div>
                        </div>
                        <div class="time-row">
                            <span class="time-label">Arrival</span>
                            <div class="time-value"><?php echo htmlspecialchars($flight['arrival']); ?></div>
                            <div class="timezone"><?php echo htmlspecialchars($flight['destTZ']); ?></div>
                        </div>
                    </div>
                    
                    <div class="duration">
                        Duration: <?php echo htmlspecialchars($flight['duration']); ?>
                    </div>
                    
                    <?php if ($flight['countdown'] !== null && $flight['countdown'] > 0): ?>
                    <div class="countdown">
                        Departs in <?php echo $flight['countdown']; ?> minutes
                    </div>
                    <?php endif; ?>
                    
                    <div class="status-badge <?php echo $flight['statusClass']; ?>">
                        <?php echo htmlspecialchars($flight['status']); ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Other Timezones Section (Bonus) -->
        <div class="timezones-section">
            <h3> Other Timezones</h3>
            <div class="timezones-grid">
                <?php foreach ($timezoneTimes as $tz): ?>
                <div class="timezone-card">
                    <h4><?php echo htmlspecialchars($tz['label']); ?></h4>
                    <div class="time"><?php echo htmlspecialchars($tz['time']); ?></div>
                    <div class="date"><?php echo htmlspecialchars($tz['date']); ?></div>
                    <div class="timezone" style="margin-top: 10px; font-size: 0.85em;">
                        <?php echo htmlspecialchars($tz['timezone']); ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>

    <footer>
        <p>&copy; <?php echo date('Y'); ?> Made by love: Jaymee Santos | CYB-201 | Powered by PHP DateTime</p>
        <p>All times are displayed in their respective timezones</p>
    </footer>
</body>
</html>

