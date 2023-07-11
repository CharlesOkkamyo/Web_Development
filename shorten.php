<?php
function generateShortCode($length = 6) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $shortCode = '';
    for ($i = 0; $i < $length; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $shortCode .= $characters[$index];
    }
    return $shortCode;
}

function saveShortURL($originalUrl, $shortenedUrl) {
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'url_shortener';

    try {
        $conn = new mysqli($host, $username, $password, $database);

        if ($conn->connect_error) {
            throw new Exception('Database connection failed: ' . $conn->connect_error);
        }

        $sql = "INSERT INTO short_urls (original_url, shortened_url) VALUES ('$originalUrl', '$shortenedUrl')";
        if ($conn->query($sql) === FALSE) {
            throw new Exception('Error executing SQL query: ' . $conn->error);
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
    $shortenedUrl = "http://$domain/$shortCode"

    saveShortURL($originalUrl, $shortenedUrl);

    header("Location: index.php?shortened_url=$shortenedUrl");
    exit;
}
?>
