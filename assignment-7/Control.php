<?php 
require_once 'Model.php';
include 'view.php';
    class ShortenController {
        private $Model;

        public function __construct() {
            $this->Model = new Model();
        }

        public function shortenUrl() {
            if (isset($_POST['url'])) {
                $originalUrl = $_POST['url'];

                $shortCode = $this->Model->generateShortCode();
                $domain = parse_url($originalUrl, PHP_URL_HOST);
                $shortenedUrl = "http://$domain/$shortCode";

                $this->Model->saveShortURL($originalUrl, $shortenedUrl);

                header("Location: index.php?shortened_url=$shortenedUrl");
                exit;
            }
        }
    }

    $shortenController = new ShortenController();
    $shortenController->shortenUrl();
?>
