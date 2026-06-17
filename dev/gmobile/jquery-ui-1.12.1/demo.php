<?php
$year=date('Y');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8" />
<title>jQuery UI Datepicker - Mostrar menús de meses y años</title>
<link rel="stylesheet" href="../jquery-ui-1.12.1/themes/base/jquery-ui.css">
      <script src="../jquery-ui-1.12.1/jquery-1.12.4.js"></script>
      <script src="../jquery-ui-1.12.1/jquery-ui.js"></script>

<script src="jquery.ui.datepicker-es.js"></script>

<script>
$(function () {
$.datepicker.setDefaults($.datepicker.regional["es"]);
$("#datepicker").datepicker({
changeMonth: true,
changeYear: true,
yearRange: "1900:<? echo $year;?>"
});
});
</script>
</head>

<body>
<p>
Fecha:
<input type="text" id="datepicker" />
</p>
</body>
</html>