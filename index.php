<?php
include "header.php";
?>
<h1 style="text-align:center;">SISTEM PENDUKUNG KEPUTUSAN PENERIMA BEASISWA BIDIKMISI UNIVERSITAS RIAU
</h1>

<div style="display: flex; justify-content: center; align-items: center; flex-direction: column;">

    <form id="uploadForm" method="post" action="prosesdata.php" enctype="multipart/form-data"
        style="max-width: 400px; width: 100%; text-align: center;">

        <div style="padding: 1.2rem; margin: 2rem 0; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
            <h3 style="margin-bottom: 1.2rem; font-size: 1.5rem;">Upload File Data SPK (.xlsx)</h3>
            <input type="file" name="data"
                style="padding: 0.5rem; margin-bottom: 1rem; border: 1px solid #ccc; border-radius: 4px;">
            <button name="submit"
                style="padding: 0.5rem 1rem; background-color: #3498db; color: #fff; border: none; border-radius: 4px; cursor: pointer;"
                onclick="submitAndUpload()">
                Proses
            </button>
        </div>

    </form>
</div>
<div style="background-color: #f0f0f0; width: 100%; height: 100%; position: absolute; top: 0; left: 0; z-index: 999; display:flex; justify-content:center; align-items:center; display: none;"
    id="notificationDiv">
    <div style="background-color: #fff; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); border-radius: 8px; overflow: hidden; text-align: center; padding: 1rem 3rem; max-width: 400px; display: none;"
        id="notificationCard">
        <div style="margin: 0.5rem 0; font-size: 4rem;" id="notificationLogo"></div>
        <div style="font-size: 1.2rem; font-weight: bold; margin: .8rem 1rem;" id="notificationText"></div>
        <div style="margin: 0.5rem 1rem;" id="notificationDescription"></div>
    </div>
</div>

<?php
include "footer.php";
?>