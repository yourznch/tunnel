<?php
// Fungsi untuk mendapatkan jumlah baris dalam file
function getFileRowCount($filename) {
    $file = fopen($filename, "r");
    $rowCount = 0;

    while (!feof($file)) {
        fgets($file);
        $rowCount++;
    }

    fclose($file);

    return $rowCount;
}

// Mendapatkan URL letak script index.php
$scriptURL = $_SERVER['SCRIPT_URI'];

// Mendapatkan path direktori terakhir
$scriptPath = pathinfo($scriptURL, PATHINFO_DIRNAME);

// Mengambil jumlah baris dalam file judul.txt
$judulFile = "judul.txt";
$jumlahBaris = getFileRowCount($judulFile);

// Membuka file sitemap.xml untuk ditulis
$sitemapFile = fopen("sitemap.xml", "w");

// Menulis header XML
fwrite($sitemapFile, '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL);
fwrite($sitemapFile, '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL);

// Membaca isi dari judul.txt dan menghasilkan link sitemap berdasarkan setiap judul
$fileLines = file($judulFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
foreach ($fileLines as $index => $judul) {
    $sitemapLink = $scriptPath . '/?tunnel=' . urlencode($judul);
    fwrite($sitemapFile, '  <url>' . PHP_EOL);
    fwrite($sitemapFile, '    <loc>' . $sitemapLink . '</loc>' . PHP_EOL);
    fwrite($sitemapFile, '  </url>' . PHP_EOL);
}

// Menulis penutup XML
fwrite($sitemapFile, '</urlset>' . PHP_EOL);

// Menutup file sitemap.xml
fclose($sitemapFile);

echo "Kyahh oni-chan..File sitemap.xml berhasil dibuat.";
?>
