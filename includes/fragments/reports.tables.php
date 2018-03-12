<table width="100%" class="table table-bordered table-hover" id="table-tool-list">
    <thead>
        <tr>
            <th align="left"><b>Tool Name</b></th>
            <th align="left"><b>Action</b></th>
        </tr>
    </thead>
</table>

<script>
    $(document).ready(function() {
        var dataTable = $('#table-tool-list').DataTable( {
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "order":[],
            "ajax":{
                url :"/includes/actions/forms.generate.list.php",
                method: "POST",
            },
            "columnDefs":[
                {
                    "targets": [1],
                    "orderable":false
                },
            ]
        } );
    } );
</script>