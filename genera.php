<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<form action="reporte.php" method="POST">

<label for="">Placa</label>
<input type="text" name="Placa" id="Placa"></input>

<label for="">trabajo</label>

<select name="trabajo" id="trabajo">
<option value="1">Tecnicos</option>
<option value="2">Operador</option>
<option value="3">Reaccion</option>

</select>

<button type="submit">Generar Reporte</button>

</form>

</body>
</html>