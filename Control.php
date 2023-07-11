<?php 
require_once 'Model.php';

    class ShortenController {
        private $urlModel;

        public function __construct() {
            $this->urlModel = new Model();
        }

        public function shortenUrl() {
            if (isset($_POST['url'])) {
                $originalUrl = $_POST['url'];

                $shortCode = $this->urlModel->generateShortCode();
                $shortenedUrl = "http://www.youtube.com/url_shortener/$shortCode";

                $this->urlModel->saveShortURL($originalUrl, $shortenedUrl);

                header("Location: index.php?shortened_url=$shortenedUrl");
                exit;
            }
        }
    }

    $shortenController = new ShortenController();
    $shortenController->shortenUrl();
?>
