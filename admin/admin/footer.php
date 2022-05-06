<footer class="py-4 bg-light mt-auto">
<div class="container-fluid">
<div class="d-flex align-items-center justify-content-between small">
    <div class="text-muted">&copy; By<a href="https://t.me/mazangizo"> 💀 MAZANGIZO</a></div>
    
</div>
</div>
</footer>
</div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="js/scripts.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
<script src="assets/demo/datatables-demo.js"></script>
<script type='text/javascript'>
//this code is for alert auto close
$(".alert").fadeTo(3000, 500).slideUp(500, function(){
    $(".alert").slideUp(500);
});


</script>
<script>
  $("#dataTable").on('click','#status_change',function(){
      
    var currentRow=$(this).closest("tr"); 
         
         var id=currentRow.find("td:eq(0)").text(); // get current row 1st TD value
         var walletid=currentRow.find("td:eq(1)").text(); // get current row 2nd TD
         var amount=currentRow.find("td:eq(2)").text(); // get current row 3rd TD
         
    $.post("ajax.php",
    {
      id:id ,
      walletid:walletid,
      amount:amount,
      action:"confirm" 
    },
    function(data,status){
        location.reload();
    });

  });
</script>
</body>
</html>
