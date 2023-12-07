<?php
require 'phpoffice/autoload.php'; // Ubah path sesuai dengan struktur direktori Anda
include "header.php";

use PhpOffice\PhpSpreadsheet\IOFactory;

set_time_limit(0);

?>

<div style="background-color: #f0f0f0; width: 100%; height: 100%; position: absolute; top: 0; left: 0; z-index: 999; display:flex; justify-content:center; align-items:center; display: none;"
    id="notificationDiv">
    <div style="background-color: #fff; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); border-radius: 8px; overflow: hidden; text-align: center; padding: 1rem 3rem; max-width: 400px; display: none;"
        id="notificationCard">
        <div style="margin: 0.5rem 0; font-size: 4rem;" id="notificationLogo"></div>
        <div style="font-size: 1.1rem; font-weight: bold; margin: 0rem 1rem;" id="notificationText"></div>
        <div style="margin: 0.5rem 1rem;" id="notificationDescription"></div>
        <a href="#"
            style="display: block; margin: 1rem auto; padding: 0.7rem 1.2rem; background-color: #3498db; color: #fff; text-decoration: none; border-radius: 4px; transition: background-color 0.3s ease;"
            onclick="redirectToHome()">Kembali ke Beranda</a>
    </div>
</div>

<?php

// Check if data file is a actual data or fake data
if(isset($_POST["submit"])) {
    $xlsxFilePath = (upload());

    //echo json_encode(['progress' => 1]);

    if($xlsxFilePath) {
        try {
            // Load file XLSX
            $spreadsheet = IOFactory::load($xlsxFilePath);
        
            // Pilih sheet yang ingin Anda baca (misalnya, sheet pertama)
            $worksheet = $spreadsheet->getSheetByName("bobot");

            $bobotKriteriaPos = [];
            foreach ($worksheet->getRowIterator() as $row) {
                foreach ($row->getCellIterator() as $cell) {
                    $cellValue = $cell->getValue();
                    if ($cellValue === 'bobot kriteria') {
                        array_push($bobotKriteriaPos, (object)["row" => $row->getRowIndex(), "col" => $cell->getColumn()]);
                    }
                }
            }

            //echo json_encode(['progress' => 10]);

            $stmt = $db->prepare("DELETE FROM smart_kriteria");
            $stmt->execute();
            $stmt = $db->prepare("ALTER TABLE smart_kriteria AUTO_INCREMENT = 1;");
            $stmt->execute();

            //echo json_encode(['progress' => 15]);

            $isKriteria = true;
            $curRow = 1;
            try {
                $db->beginTransaction();

                $stmt = $db->prepare("INSERT INTO smart_kriteria VALUES ('', ?, ?)");

                while ($isKriteria) {
                    $kriteriaValue = $worksheet->getCell(chr(ord($bobotKriteriaPos[0]->col) - 1) . ($bobotKriteriaPos[0]->row + $curRow))->getValue();
                    $bobotValue = $worksheet->getCell($bobotKriteriaPos[0]->col . ($bobotKriteriaPos[0]->row + $curRow))->getValue();

                    $stmt->bindParam(1, $kriteriaValue);
                    $stmt->bindParam(2, $bobotValue);

                    if ($stmt->execute()) {
                        $curRow++;
                        $isKriteria = ($worksheet->getCell(chr(ord($bobotKriteriaPos[0]->col) - 1) . ($bobotKriteriaPos[0]->row + $curRow))->getValue() != "");
                    } else {
                        throw new Exception("Failed to execute SQL statement in KRITERIA.");
                    }
                }

                $db->commit();
            } catch (Exception $e) {
                $db->rollBack();
                // Handle exception if needed
                $errText = "Error: " . $e->getMessage();
                ?>
<script>
showNotification("eror", "⚠️", "GAGAL", <?= $errText ?>);
</script>
<?php
            }

            //echo json_encode(['progress' => 25]);

            $stmt = $db->prepare("DELETE FROM smart_sub_kriteria");
            $stmt->execute();
            $stmt = $db->prepare("ALTER TABLE smart_sub_kriteria AUTO_INCREMENT = 1;");
            $stmt->execute();

            //echo json_encode(['progress' => 30]);

            $stmt = $db->prepare("SELECT * FROM smart_kriteria");
            $stmt->execute();
            try {
                $db->beginTransaction();

                $stmt2 = $db->prepare("INSERT INTO smart_sub_kriteria VALUES ('', ?, ?, ?)");

                while ($rowKriteria = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $isSubKriteria = true;
                    $curRow = 1;
                    $colRow = getColRow($worksheet, $rowKriteria["nama_kriteria"]);

                    while ($isSubKriteria) {
                        $subKriteriaValue = $worksheet->getCell($colRow->col . ($colRow->row + $curRow))->getValue();
                        $subBobotValue = $worksheet->getCell(chr(ord($colRow->col) + 1) . ($colRow->row + $curRow))->getValue();
                        $subBobotValue = floatval($subBobotValue) * 100;

                        $stmt2->bindParam(1, $subKriteriaValue);
                        $stmt2->bindParam(2, $subBobotValue);
                        $stmt2->bindParam(3, $rowKriteria["id_kriteria"]);

                        if($stmt2->execute()) {
                            $curRow++;
                            $isSubKriteria = ($worksheet->getCell($colRow->col . ($colRow->row + $curRow))->getValue() != "");
                        } else {
                            throw new Exception("Failed to execute SQL statement in SUB_KRITERIA.");
                        }

                    }
                }

                $db->commit();
            } catch (Exception $e) {
                $db->rollBack();
                // Handle exception if needed
                $errText = "Error: " . $e->getMessage();
                ?>
<script>
showNotification("eror", "⚠️", "GAGAL", <?= $errText ?>);
</script>
<?php
            }

            //echo json_encode(['progress' => 50]);

            $stmt = $db->prepare("DELETE FROM smart_alternatif");
            $stmt->execute();
            $stmt = $db->prepare("ALTER TABLE smart_alternatif AUTO_INCREMENT = 1;");
            $stmt->execute();

            //echo json_encode(['progress' => 55]);

            $worksheet = $spreadsheet->getSheetByName("calon");
            $namaCell = getColRow($worksheet, "Nama Siswa");
            if ($namaCell) {
                $curRow = $namaCell->row + 1;
                $isNamaSiswa = 1;

                try {
                    $db->beginTransaction();

                    $stmt2 = $db->prepare("INSERT INTO smart_alternatif (id_alternatif, nama_alternatif) VALUES ('', ?)");

                    while ($isNamaSiswa == 1) {
                        $namaSiswa = $worksheet->getCell($namaCell->col . $curRow)->getValue();
                        $stmt2->bindParam(1, $namaSiswa);

                        if ($stmt2->execute()) {
                            $curRow++;
                            if ($worksheet->getCell($namaCell->col . $curRow)->getValue() == "") $isNamaSiswa = 0;
                        } else {
                            throw new Exception("Failed to execute SQL statement in ALTERNATIF.");
                        }

                    }

                    $db->commit();
                } catch (Exception $e) {
                    $db->rollBack();
                    // Handle exception if needed
                    $errText = "Error: " . $e->getMessage();
                    ?>
<script>
showNotification("eror", "⚠️", "GAGAL", <?= $errText ?>);
</script>
<?php
                }
            }

            //echo json_encode(['progress' => 75]);

            $stmt = $db->prepare("DELETE FROM smart_alternatif_kriteria");
            $stmt->execute();
            $stmt = $db->prepare("ALTER TABLE smart_alternatif_kriteria AUTO_INCREMENT = 1;");
            $stmt->execute();

            //echo json_encode(['progress' => 80]);

            $worksheet = $spreadsheet->getSheetByName("calon");
            $stmt = $db->prepare("SELECT * FROM smart_alternatif");
            $stmt->execute();

            try {
                $db->beginTransaction();

                $stmt2 = $db->prepare("SELECT * FROM smart_kriteria");
                $stmt2->execute();

                $stmt3 = $db->prepare("SELECT nilai_sub_kriteria FROM smart_sub_kriteria WHERE nama_sub_kriteria = ?");

                $stmt4 = $db->prepare("INSERT INTO smart_alternatif_kriteria(id_alternatif, id_kriteria, nilai_alternatif_kriteria, nilai_utility) VALUES (?, ?, ?, ?)");

                $stmt5 = $db->prepare("SELECT MAX(nilai_sub_kriteria) AS max_sub, MIN(nilai_sub_kriteria) AS min_sub FROM smart_sub_kriteria WHERE id_kriteria = ? GROUP BY id_kriteria");

                while ($rowAlternatif = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $alternatifCell = getColRow($worksheet, $rowAlternatif["nama_alternatif"]);
                    if (!$alternatifCell) continue;

                    while ($rowKriteria = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                        $kriteriaCell = getColRow($worksheet, $rowKriteria["nama_kriteria"]);
                        if (!$kriteriaCell) continue;

                        $curRow = $alternatifCell->row;
                        $subKriteriaValue = $worksheet->getCell($kriteriaCell->col . $curRow)->getValue();

                        $stmt3->bindParam(1, $subKriteriaValue);
                        $stmt3->execute();

                        if ($rowSubKriteria = $stmt3->fetch(PDO::FETCH_NUM)) {
                            $stmt4->bindParam(1, $rowAlternatif["id_alternatif"]);
                            $stmt4->bindParam(2, $rowKriteria["id_kriteria"]);
                            $stmt4->bindParam(3, $rowSubKriteria[0]);

                            $stmt5->bindParam(1, $rowKriteria["id_kriteria"]);
                            $stmt5->execute();

                            if ($rowMaxMinSub = $stmt5->fetch(2)) {
                                $utilityValue = ($rowSubKriteria[0] - $rowMaxMinSub["min_sub"]) /
                                    ($rowMaxMinSub["max_sub"] - $rowMaxMinSub["min_sub"]);

                                $stmt4->bindParam(4, $utilityValue);
                                $stmt4->execute();
                            } else {
                                throw new Exception("Failed to execute SQL statement in ALTERNATIF_KRITERIA.");
                            }

                        }
                    }

                    // Reset statement2 pointer to the beginning for the next iteration
                    $stmt2->execute();
                }

                $db->commit();
            } catch (Exception $e) {
                $db->rollBack();
                // Handle exception if needed
                $errText = "Error: " . $e->getMessage();
                ?>
<script>
showNotification("eror", "⚠️", "GAGAL", <?= $errText ?>);
</script>
<?php
            }

            //echo json_encode(['progress' => 100]);
        ?>
<script>
showNotification("sukses");
</script>
<?php

        } catch (Exception $e) {
            $errText = "Error: " . $e->getMessage();
            ?>
<script>
showNotification("eror", "⚠️", "GAGAL", <?= $errText ?>);
</script>
<?php
        }
    }
}

function upload() {
	$namaFile = $_FILES['data']['name'];
	$error = $_FILES['data']['error'];
	$tmpName = $_FILES['data']['tmp_name'];

	if( $error === 4 ) {
		return false;
	}

	// cek apakah yang diupload adalah excel
	$ekstensiDataValid = ['xlsx', 'xls'];
	$ekstensiData = explode('.', $namaFile);
	$ekstensiData = strtolower(end($ekstensiData));
	if( !in_array($ekstensiData, $ekstensiDataValid) ) {
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

function getColRow($worksheet, $query) {
    foreach ($worksheet->getRowIterator() as $row) {
        foreach ($row->getCellIterator() as $cell) {
            $cellValue = $cell->getValue();
            if ($cellValue === $query) {
                // Kata "bobot" ditemukan dalam sel, lakukan tindakan yang sesuai
                return (object)["row" => $row->getRowIndex(), "col" => $cell->getColumn()];
            }
        }
    }
    return false;
}

include "footer.php";
?>