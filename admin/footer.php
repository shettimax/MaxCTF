<footer class="py-4 bg-dark mt-auto">
    <div class="container-fluid">
        <div class="text-center text-green">CTFBACKBOX | MZGZ</div>
    </div>
</footer>
</div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function(){
    $('#dataTable').DataTable();
    setTimeout(function(){
        $(".alert-warning").fadeOut("slow");
    }, 3000);
});
</script>
</body>
</html>
