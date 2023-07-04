<!DOCTYPE html>
<html>
<head>
    <title>URL Shortener</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">URL Shortener</h1>
        <form action="shorten.php" method="post" class="mb-4">
            <div class="input-group">
                <input type="url" name="url" class="form-control" placeholder="Enter your long URL" required>
                <button type="submit" class="btn btn-primary">Shorten</button>
            </div>
        </form>
        <?php if (isset($_GET['shortened_url'])): ?>
            <div class="alert alert-success">
                Your shortened URL: <a href="<?php echo $_GET['shortened_url']; ?>"><?php echo $_GET['shortened_url']; ?></a>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
