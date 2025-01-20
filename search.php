<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $search = trim($_POST['search']); // Ambil input pencarian
    $search = strtolower($search);   // Ubah ke huruf kecil agar pencarian tidak case-sensitive

    $file = 'data.csv';
    // $file = 'branding_data.csv'; // Nama file data
    $results = [];

    if (file_exists($file)) {
        // Baca file CSV
        $handle = fopen($file, 'r');
        while (($data = fgetcsv($handle, 1000, ',')) !== false) {
            // Cek apakah input cocok dengan salah satu kolom
            if (strpos(strtolower(implode(' ', $data)), $search) !== false) {
                $results[] = $data;
            }
        }
        fclose($handle);
    }

    // Tampilkan hasil pencarian
    if (!empty($results)) {
        echo "<h1>Hasil Pencarian:</h1><table border='1'>";
        echo "<tr><th>TANGGAL</th><th>NAMA SALES</th><th>REQUEST CODE</th><th>NAMA TOKO</th><th>AREA</th><th>TIPE (B/P)</th><th>VIA</th><th>PERMINTAAN</th><th>QTY</th><th>PEMBUATAN DESIGN PIC: TEAM DESIGN</th>
        <th>APPROVE LADDER</th><th>APPROVAL TOKO PIC:TEAM SALES</th><th>KONFIRMASI DESIGN PIC: TEAM SALES</th><th>KIRIM PO PIC:TEAM DESIGN TANGGAL</th><th>VENDOR</th><th>SJ DI TERIMA TASYA</th>
        <th>PO SELESAI DI BUAT DAN DI KIRIM KE K</th><th>GUDANG K PACKING</th><th>KIRIM</th><th>DADAP TERIMA DARI GUDANG K</th><th>KIRIM</th><th>KONFIRMASI PENERIMAAN PIC:TEAM SALES</th></tr>";
        foreach ($results as $row) {
            echo "<tr><td>" . implode('</td><td>', $row) . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<h1>Tidak ada data yang cocok!</h1>";
    }
}
?>
