// Call the dataTables jQuery plugin
$(document).ready(function() {
  $('#dataTable').DataTable({
    "paging":   false,
    "ordering": false,
    "info":     false,
    "searching":false
  });
});
