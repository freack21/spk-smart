<?php
include "header.php";
?>
<h1 style="text-align:center">SISTEM PENDUKUNG KEPUTUSAN PENERIMA BEASISWA BIDIKMISI UNIVERSITAS RIAU</h1>
<div style="display:flex; justify-content: center; align-items: center; flex-direction: column;">
    <form action="prosesdata.php" method="post" enctype="multipart/form-data">
        <div style="display:flex; justify-content: center; align-items: center; flex-direction: column; border: 1px solid blue; padding: .8rem 2rem; margin-top:2rem;">
            <h3 style="margin-bottom:1.2rem;">Upload File Data SPK (xlsx)</h3>
            <input type="file" name="data">
            <button style="margin:1rem; display:block; padding: .2rem 1rem;" name="submit" type="submit">Proses</button>
        </div>
    </form>
</div>
<?php
include "footer.php";
?>
					
					