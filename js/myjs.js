function showNotification(status, icon, text, desc) {
    let notificationDiv = document.getElementById("notificationDiv");
    let logoElement = document.getElementById("notificationLogo");
    let textElement = document.getElementById("notificationText");
    let descriptionElement = document.getElementById("notificationDescription");

    if (status === "sukses") {
        logoElement.innerHTML = "✅";
        textElement.textContent = "Sukses";
        descriptionElement.textContent = "Proses berhasil dilakukan.";
    } else if (status === "gagal") {
        logoElement.innerHTML = "❌";
        textElement.textContent = "Gagal";
        descriptionElement.textContent = "Terjadi kesalahan dalam proses.";
    } else if (status === "loading") {
        logoElement.innerHTML = "🔃";
        textElement.textContent = "Loading..";
        descriptionElement.textContent = "Sedang memproses..";
    } else {
        logoElement.innerHTML = icon;
        textElement.textContent = text;
        descriptionElement.textContent = desc;
    }

    document.getElementById("notificationCard").style.display = "block";
    notificationDiv.style.display = "flex";
}

function redirectToHome() {
    window.location.href = "index.php";
}

function submitAndUpload() {
    showNotification("loading");
    $("#uploadForm").submit();
}

function dismissNotification() {
    document.getElementById("notificationCard").style.display = "none";
    document.getElementById("notificationDiv").style.display = "none";
}
