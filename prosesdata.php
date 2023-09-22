
<?php
require 'phpoffice/autoload.php'; // Ubah path sesuai dengan struktur direktori Anda

use PhpOffice\PhpSpreadsheet\IOFactory;

// Check if data file is a actual data or fake data
if(isset($_POST["submit"])) {

    
    $xlsxFilePath = (upload());
    
    if($xlsxFilePath) {
        try {
            // Load file XLSX
            $spreadsheet = IOFactory::load($xlsxFilePath);
        
            // Pilih sheet yang ingin Anda baca (misalnya, sheet pertama)
            $worksheet = $spreadsheet->getSheetByName("bobot");
        
            // Dapatkan jumlah baris dan kolom
            $highestRow = $worksheet->getHighestRow();
            $highestColumn = $worksheet->getHighestColumn();
        
            // Loop melalui sel-sel dan cetak isi
            // for ($row = 1; $row <= $highestRow; $row++) {
            //     $rowData = $worksheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
            //     // $rowData adalah array yang berisi data dari baris saat ini
            //     echo "<pre>";
            //     print_r($rowData[0]); // Cetak data dari baris saat ini
            //     echo "</pre>";
            // }

            $bobotPos = [];

            // Loop melalui setiap sel pada lembar spreadsheet
            foreach ($worksheet->getRowIterator() as $row) {
                foreach ($row->getCellIterator() as $cell) {
                    $cellValue = $cell->getValue();
                    if (stripos($cellValue, 'bobot') !== false) {
                        // Kata "bobot" ditemukan dalam sel, lakukan tindakan yang sesuai
                        array_push($bobotPos, (object)["row" => $row->getRowIndex(), "col" => $cell->getColumn()]);
                    }
                }
            }
            // echo "<pre>";
            // print_r($bobotPos); // Cetak data dari baris saat ini
            // echo "</pre>";

            foreach ($bobotPos as $pos) {
            echo "<pre>";
            print_r($pos);
            echo "</pre>";
            }

        } catch (Exception $e) {
            echo 'Terjadi kesalahan: ' . $e->getMessage();
        }
    }

    // var_dump($_FILES["data"]);

    // $target_dir = "file/";
    // $target_file = $target_dir . basename($_FILES["data"]["name"]);
    // $uploadOk = 1;
    // $dataFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // // Check if file already exists
    // if (file_exists($target_file)) {
    //     echo "Sorry, file already exists.";
    //     $uploadOk = 0;
    // }

    // // Allow certain file formats
    // if($dataFileType != "xlsx" && $dataFileType != "xls") {
    //     echo "Sorry, only XLSX, XLS files are allowed.";
    //     $uploadOk = 0;
    // }

    // // Check if $uploadOk is set to 0 by an error
    // if ($uploadOk == 0) {
    //     echo "Sorry, your file was not uploaded.";
    // // if everything is ok, try to upload file
    // } else {
    //     if (move_uploaded_file($_FILES["data"]["tmp_name"], $target_file)) {
    //         echo "The file ". htmlspecialchars( basename( $_FILES["data"]["name"])). " has been uploaded.";
    //     } else {
    //         echo "Sorry, there was an error uploading your file.";
    //     }
    // }
}

function upload() {

	$namaFile = $_FILES['data']['name'];
	$ukuranFile = $_FILES['data']['size'];
	$error = $_FILES['data']['error'];
	$tmpName = $_FILES['data']['tmp_name'];

	if( $error === 4 ) {
		echo "ERROR 4";
		return false;
	}

	// cek apakah yang diupload adalah data
	$ekstensiDataValid = ['xlsx', 'xls'];
	$ekstensiData = explode('.', $namaFile);
	$ekstensiData = strtolower(end($ekstensiData));
	if( !in_array($ekstensiData, $ekstensiDataValid) ) {
		echo "Yang Anda Upload Bukan XLSX";
		return false;
	}

	// $namaFileBaru = time(). uniqid() . rand();
	$namaFileBaru = $namaFile;
	$namaFileBaru .= '.';
	$namaFileBaru .= $ekstensiData;
    $namaFileBaru = 'file/' . $namaFileBaru;
	if(move_uploaded_file($tmpName, $namaFileBaru))
    	return $namaFileBaru;
    else return false;
}

?>
