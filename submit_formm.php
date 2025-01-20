<?php
require 'vendor/autoload.php'; // Pastikan path library-nya sesuai

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $data = [
        'Email' => $_POST['email'],
        'Area Sales' => $_POST['area_sales'],
        'Nama Sales' => $_POST['sales_code'],
        'Nama Toko' => $_POST['store_name'],
        'Nama SPV' => $_POST['spv_name'],
        'Lokasi' => $_POST['location'],
        'Jenis Permintaan' => $_POST['request_type'],
        'Tools Branding' => $_POST['branding_tools'],
        'Tools Lainnya' => $_POST['other_tools'] ?? '',
        'Ukuran Tools' => $_POST['tools_size'],
        'Qty' => $_POST['quantity'],
        'Pengiriman' => $_POST['delivery'],
        'Keterangan Tambahan' => $_POST['additional_notes'] ?? '',
        'Brand' => $_POST['brand'],
        'Foto Area Pemasangan' => '',
        'Foto Desain' => ''
    ];

    // Folder penyimpanan gambar
    $uploadDir = "uploads/";

    // Proses upload Foto Area Pemasangan
    if (isset($_FILES['installation_photo']) && $_FILES['installation_photo']['error'] === UPLOAD_ERR_OK) {
        $installationPhotoName = basename($_FILES['installation_photo']['name']);
        $installationPhotoPath = $uploadDir . $installationPhotoName;

        if (move_uploaded_file($_FILES['installation_photo']['tmp_name'], $installationPhotoPath)) {
            $data['Foto Area Pemasangan'] = $installationPhotoPath;
        } else {
            echo "<script>alert('Gagal upload Foto Area Pemasangan!');</script>";
        }
    }

    // Proses upload Foto Desain
    if (isset($_FILES['design_photo']) && $_FILES['design_photo']['error'] === UPLOAD_ERR_OK) {
        $designPhotoName = basename($_FILES['design_photo']['name']);
        $designPhotoPath = $uploadDir . $designPhotoName;

        if (move_uploaded_file($_FILES['design_photo']['tmp_name'], $designPhotoPath)) {
            $data['Foto Desain'] = $designPhotoPath;
        } else {
            echo "<script>alert('Gagal upload Foto Desain!');</script>";
        }
    }

    $fileName = "request_branding.xlsx";

    // Cek apakah file Excel sudah ada
    if (file_exists($fileName)) {
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($fileName);
        $sheet = $spreadsheet->getActiveSheet();
    } else {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        // Header untuk file baru
        $sheet->fromArray(array_keys($data), NULL, 'A1');
    }

    // Tambahkan data ke baris baru
    $sheet->fromArray(array_values($data), NULL, 'A' . ($sheet->getHighestRow() + 1));

    // Simpan file Excel
    $writer = new Xlsx($spreadsheet);
    $writer->save($fileName);

    // Tampilkan alert dan redirect
    echo "<script>
        alert('Data berhasil disimpan ke $fileName!');
        window.location.href = 'user.html'; // Ganti dengan URL menu user
    </script>";
}
?>
