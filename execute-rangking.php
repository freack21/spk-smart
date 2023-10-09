<?php
include "header.php";
$page = isset($_GET['page'])?$_GET['page']:"";
$sangatlayak = 0;
$layak = 0;
$ditimbang = 0;
$tidaklayak = 0;
?>
<div class="row cells4">
    <div class="cell colspan2">
        <h3>Eksekusi Perangkingan</h3>
    </div>
    <div class="cell colspan2 align-right">
        <a href="perangkingan.php" class="button info">Kembali</a>
    </div>
</div>
<table class="table striped hovered cell-hovered border bordered dataTable" data-role="datatable" data-searching="true">
    <thead>
        <tr>
            <th width="50">No</th>
            <th>Alternatif</th>
            <?php
            $stmt2x = $db->prepare("SELECT nama_kriteria FROM smart_kriteria");
            $stmt2x->execute();
            while($row2x = $stmt2x->fetch(PDO::FETCH_NUM)){
            ?>
            <th><?php echo $row2x[0] ?></th>
            <?php
            }
            ?>
            <th>Hasil</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        <?php
		$stmtx = $db->prepare("SELECT * FROM smart_alternatif");
		$noxx = 1;
		$stmtx->execute();
		while($rowx = $stmtx->fetch()){
		?>
        <tr>
            <td><?php echo $noxx++ ?></td>
            <td><?php echo $rowx['nama_alternatif'] ?></td>
            <?php
            $stmt3x = $db->prepare("SELECT * FROM smart_kriteria");
            $stmt3x->execute();
            while($row3x = $stmt3x->fetch()){
            ?>
            <td>
                <?php
                $stmt4x = $db->prepare("SELECT * FROM smart_alternatif_kriteria WHERE id_kriteria='".$row3x['id_kriteria']."' and id_alternatif='".$rowx['id_alternatif']."'");
                $stmt4x->execute();
                while($row4x = $stmt4x->fetch()){
                	$ida = $row4x['id_alternatif'];
                	$idk = $row4x['id_kriteria'];
                    echo $kal = ($row4x['nilai_utility']*$row3x['bobot_kriteria']) * 100;
                    $stmt2x3 = $db->prepare("UPDATE smart_alternatif_kriteria set bobot_alternatif_kriteria=? WHERE id_alternatif=? and id_kriteria=?");
					$stmt2x3->bindParam(1,$kal);
					$stmt2x3->bindParam(2,$ida);
					$stmt2x3->bindParam(3,$idk);
					$stmt2x3->execute();
                }
                ?>
            </td>
            <?php
            }
            ?>
            <td>
                <?php
            	$stmt3x2 = $db->prepare("select sum(bobot_alternatif_kriteria) as bak from smart_alternatif_kriteria WHERE id_alternatif='".$rowx['id_alternatif']."'");
	            $stmt3x2->execute();
	            $row3x2 = $stmt3x2->fetch();
	            $ideas = $rowx['id_alternatif'];
	            echo $hsl = $row3x2['bak'];
	            if($hsl>=80){
	            	$ket = "Sangat Layak";
	            } else if($hsl>=55){
	            	$ket = "Layak";
	            } else if($hsl>=25){
	            	$ket = "Dipertimbangkan";
	            } else{
	            	$ket = "Tidak Layak";
	            }
	            $stmt2x3y = $db->prepare("update smart_alternatif set hasil_alternatif=?, ket_alternatif=? WHERE id_alternatif=?");
				$stmt2x3y->bindParam(1,$hsl);
				$stmt2x3y->bindParam(2,$ket);
				$stmt2x3y->bindParam(3,$ideas);
				$stmt2x3y->execute();
            	?>
            </td>
            <td>
                <?php
            	if($hsl>=80){
	            	$ket2 = "Sangat Layak";
                    $sangatlayak++;
	            } else if($hsl>=55){
	            	$ket2 = "Layak";
                    $layak++;
	            } else if($hsl>=25){
	            	$ket2 = "Dipertimbangkan";
                    $ditimbang++;
	            } else{
	            	$ket2 = "Tidak Layak";
                    $tidaklayak++;
	            }
	            echo $ket2;
            	?>
            </td>
        </tr>
        <?php
		}
		?>
    </tbody>
</table>
<p><br /></p>
<div style="display:flex; justify-content: center; align-items:center; flex-direction:column;">
    <div style="max-height: 500;">
        <canvas id="myPieChart" width="400px" height="400px"></canvas>
    </div>
</div>
<script src="js/Chart.js"></script>
<script>
// Data mahasiswa
var dataMahasiswa = {
    labels: ['Sangat Layak', 'Layak', 'Dipertimbangkan', 'Tidak Layak'],
    datasets: [{
        data: [<?= $sangatlayak ?>, <?= $layak ?>, <?= $ditimbang ?>, <?= $tidaklayak ?>],
        backgroundColor: ['#36A2EB', '#2ecc71', '#e67e22', '#e74c3c'],
    }],
};

// Options untuk pie chart
var options = {
    responsive: true,
};

// Mengambil elemen canvas
var ctx = document.getElementById('myPieChart').getContext('2d');

// Membuat pie chart
var myPieChart = new Chart(ctx, {
    type: 'pie',
    data: dataMahasiswa,
    options: options,
});
</script>
<?php
include "footer.php";
?>