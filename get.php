<?php
header('Content-Type: application/json');
include 'koneksi.php';

// Query untuk mendapatkan suhu max, min, dan rata-rata
$sql1 = "
    SELECT 
        MAX(suhu) AS suhumax, MIN(suhu) AS suhummin, AVG(suhu) AS suhurata
    FROM tb_cuaca";
$hasil1 = $conn->query($sql1);

// Query untuk mendapatkan data detail nilai_suhu_max_humid_max
$sql2 = "
    SELECT 
        id AS idx, suhu, humid, lux AS kecerahan, ts 
    FROM tb_cuaca
    WHERE suhu = (SELECT MAX(suhu) FROM tb_cuaca)";
$hasil2 = $conn->query($sql2);

// Query untuk mendapatkan month_year_max
$sql3 = "
    SELECT 
        DATE_FORMAT(ts, '%c-%Y') AS month_year 
    FROM tb_cuaca
    WHERE suhu = (SELECT MAX(suhu) FROM tb_cuaca)
    LIMIT 2";
$hasil3 = $conn->query($sql3);

// Membuat array hasil
$response = array();

// Menyimpan suhu max, min, dan rata-rata
if ($hasil1 && $hasil1->num_rows > 0) {
    $row1 = $hasil1->fetch_assoc();
    $response['suhumax'] = (int)$row1['suhumax'];
    $response['suhumin'] = (int)$row1['suhummin'];
    $response['suhurata'] = round((float)$row1['suhurata'], 2);
}

// Mengambil data nilai_suhu_max_humid_max
$response['nilai_suhu_max_humid_max'] = array();
if ($hasil2 && $hasil2->num_rows > 0) {
    while ($row2 = $hasil2->fetch_assoc()) {
        $response['nilai_suhu_max_humid_max'][] = array(
            "idx" => (int)$row2['idx'],
            "suhu" => (int)$row2['suhu'],
            "humid" => (int)$row2['humid'],
            "kecerahan" => (int)$row2['kecerahan'],
            "timestamp" => $row2['ts']
        );
    }
}

// Mengambil data month_year_max
$response['month_year_max'] = array();
if ($hasil3 && $hasil3->num_rows > 0) {
    while ($row3 = $hasil3->fetch_assoc()) {
        $response['month_year_max'][] = array(
            "month_year" => $row3['month_year']
        );
    }
}

// Mengirimkan response dalam format JSON
echo json_encode($response);

// Menutup koneksi ke database
$conn->close();
?>
