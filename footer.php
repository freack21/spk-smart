</div>

</div>
</div>
</div>

</div>
<script src="js/jquery.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/metro.js"></script>
<script>
const page = (window.location.toString().split("/").pop())
$(document).ready(() => {
    if (page == "prosesdata.php") return;
    dismissNotification();
    document.getElementById("container").style.overflow = "auto";
    document.getElementById("container").style.maxHeight = "none";
    // if (page == "execute-rangking.php" || page == "alternatif.php" || page == "perangkingan.php") {}
})
</script>

</body>

</html>