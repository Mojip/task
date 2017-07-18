<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>SODING TEST ONLINE</title>

	<link href="{url}assets/css/bootstrap/bootstrap.min.css" rel="stylesheet">
	<link href="{url}assets/css/style.css" rel="stylesheet">
	
    <link href="{url}assets/css/datatables/dataTables.bootstrap.min.css" rel="stylesheet">  
</head>
<body>

<div id="container">
	<h1>{title}</h1>
	<a href="{url}login/out" class="btn btn-danger" style="position:absolute; top:45px; right:60px;">Logout</a>
	<div id="body">
		{form_display}
	</div>

	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds.</p>
</div>


<script src="{url}assets/scripts/jQuery-2.1.4.min.js"></script>
<script src="{url}assets/scripts/jquery.min.js"></script>
<script src="{url}assets/scripts/jquery.dataTables.js" type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready(function(){
        $('#datatable-responsive').dataTable({
			"sPaginationType": "full_numbers",
			"bJQueryUI": false,
			"bScrollCollapse": false,
			"bInfo": true,
			"bAutoWidth": false,
		});
    });
</script>
</body>
</html>