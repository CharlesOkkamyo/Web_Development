<?php

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'url_shortener';
function generateShortCode($length = 6) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $shortCode='';
    for ($i = 0; $i < $length; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $shortCode .= $characters[$index];
    }
    return $shortCode;
}

function saveShortURL($originalUrl,$shortCode, $shortenedUrl,$created_at, $expires_at, $click_timestamp, $country, $browser_type) {
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'url_shortener';
    try {
        
        $conn = new mysqli($host, $username, $password, $database);

        if ($conn->connect_error) {
            throw new Exception('Database connection failed: ' . $conn->connect_error);
        }

        $url_id = $conn->insert_id; 

        $sql = "INSERT INTO short_urls (original_url,short_code,shortened_url) VALUES ('$originalUrl','$shortCode','$shortenedUrl')";
        if ($conn->query($sql) === FALSE) {
            throw new Exception('Error executing SQL query: ' . $conn->error);
        }

        $sql = "INSERT INTO metadata ( created_at, expires_at) VALUES ( '$created_at', '$expires_at')";
        if ($conn->query($sql) === FALSE) {
            throw new Exception('Error executing SQL query for Metadata: ' . $conn->error);
        }

        $sql = "INSERT INTO statistics ( click_timestamp, country, browser_type) VALUES ( '$click_timestamp', '$country', '$browser_type')";
        if ($conn->query($sql) === FALSE) {
            throw new Exception('Error executing SQL query for Statistics: ' . $conn->error);
        }

        $conn->close();
    } catch (Exception $e) {
        die('Error: ' . $e->getMessage());
    }
}

if (isset($_POST['url'])) {
    $originalUrl = $_POST['url'];

    $shortCode = generateShortCode();
    $domain = parse_url($originalUrl, PHP_URL_HOST);
    $shortenedUrl = "https://$domain/$shortCode";

    $created_at = date("Y-m-d H:i:s");
    $expires_at = date("Y-m-d H:i:s", strtotime("+1 year")); // Example: URL expires after 1 year
    $description = "This is a shortened URL";
    $click_timestamp = date("Y-m-d H:i:s");
    $country = "Unknown";
    $browser_type = "Unknown";

    saveShortURL($originalUrl,$shortCode, $shortenedUrl,$created_at, $expires_at, $click_timestamp, $country, $browser_type);

    header("Location: index.php?shortened_url=$shortenedUrl");
    exit;
}

if (isset($_GET['shortcode'])) {
    $shortcode = $_GET['shortcode'];

    try {
        $conn = new mysqli($host, $username, $password, $database);

        if ($conn->connect_error) {
            throw new Exception('Database connection failed: ' . $conn->connect_error);
        }

        $sql = "SELECT short_urls.original_url,metadata.created_at, metadata.expires_at, statistics.click_timestamp, statistics.country, statistics.browser_type
                FROM short_urls
                LEFT JOIN metadata ON short_urls.url_id = metadata.url_id
                LEFT JOIN statistics ON short_urls.url_id = statistics.url_id
                WHERE short_urls.shortcode = '$shortcode'";

        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $originalUrl = $row['original_url'];

            // Redirect the user to the original URL
            header("Location: $originalUrl");
            exit;
        } else {
            die('URL not found.');
        }

        $conn->close();
    } catch (Exception $e) {
        die('Error: ' . $e->getMessage());
    }
}
?>
