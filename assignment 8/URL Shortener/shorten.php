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

       

        $sql = "INSERT INTO short_urls (original_url,short_code,shortened_url) VALUES ('$originalUrl','$shortCode','$shortenedUrl')";
        if ($conn->query($sql) === FALSE) {
            throw new Exception('Error executing SQL query: ' . $conn->error);
        }

        $url_id = $conn->insert_id; 
        $sql = "INSERT INTO metadata ( created_at, expires_at) VALUES ( '$created_at', '$expires_at')";
        if ($conn->query($sql) === FALSE) {
            throw new Exception('Error executing SQL query for Metadata: ' . $conn->error);
        }

        $sql = "INSERT INTO statistics ( click_timestamp, country, browser_type) VALUES ( '$click_timestamp', '$country', '$browser_type')";
        if ($conn->query($sql) === FALSE) {
            throw new Exception('Error executing SQL query for Statistics: ' . $conn->error);
        }

        $sql = "SELECT short_urls.id, short_urls.original_url, short_urls.short_code, short_urls.shortened_url, metadata.created_at, metadata.expires_at
        FROM short_urls
        INNER JOIN metadata ON short_urls.id = metadata.metadata_id";
        $result = $conn->query($sql);

        if (!$result) {
            die("Query failed: " . $conn->error);
        }

        $url_list = array();
        while ($row = $result->fetch_assoc()) {
            $url_list[] = $row;
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
    $click_timestamp = date("Y-m-d H:i:s");
    $country = "Unknown";
    $browser_type = "Unknown";

    saveShortURL($originalUrl,$shortCode, $shortenedUrl,$created_at, $expires_at, $click_timestamp, $country, $browser_type);

    header("Location: index.php?shortened_url=$shortenedUrl");
    exit;
}

?>
