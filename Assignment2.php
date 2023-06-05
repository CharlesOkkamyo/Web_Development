<?php
function calculateTravelTime($distance, $mode)
{
    $speed = 0;

    // Set the speed based on the mode of transportation
    switch ($mode) {
        case 'car':
            $speed =60; // miles per hour
            break;
        case 'walk':
            $speed = 3; // miles per hour
            break;
        case 'public_transport':
            $speed = 25; // miles per hour
            break;
        default:
            return "Invalid mode of transportation.";
    }

    // Calculate time = distance / speed
    $time = $distance / $speed;

    // Convert time to hours and minutes
    $hours = floor($time);
    $minutes = ($time - $hours) * 60;

    // Return the formatted time
    return sprintf("%02d:%02d", $hours, $minutes);
}

// Change your input below
$distance = 100; // miles
$mode = 'walk';

$travelTime = calculateTravelTime($distance, $mode);
echo "The time taken to travel $distance miles by $mode is: " . $travelTime;
?>