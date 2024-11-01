<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $output_path = '/storage/emulated/0/Download';
    if (!file_exists($output_path)) {
        mkdir($output_path, 0777, true);
    }
    $url = trim($_POST['url']);
    $command = "yt-dlp -f best -o \"" . $output_path . "/%(title)s.%(ext)s\" --no-playlist " . escapeshellarg($url);
    $info_command = "yt-dlp -e " . escapeshellarg($url);
    $title = shell_exec($info_command);
    $title = trim($title);
    echo "<h3>Informasi Video:</h3>";
    echo "<p>Judul: " . ($title ? $title : "Tidak tersedia") . "</p>";
    echo "<p>Memulai download...</p>";
    exec($command, $output, $return_var);
    if ($return_var === 0) {
        echo "<p>Download selesai!</p>";
        echo "<p>File tersimpan di folder: $output_path</p>";
    } else {
        echo "<p>Terjadi kesalahan saat mendownload video.</p>";
    }
} else {
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YouTube Video Downloader</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>=== YouTube Video Downloader (yt-dlp) ===</h1>
    <form method="post">
        <label for="url">Masukkan URL video YouTube:</label><br>
        <input type="text" id="url" name="url" required><br><br>
        <input type="submit" value="Download">
    </form>
</body>
</html>
<?php
}
?>
