// Call the dataTables jQuery plugin
$(document).ready(function() {
    $('#dataTable').DataTable({
        layout: {
            topStart: {
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
            }
        }
    });
});