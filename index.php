<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Algebra lineare</title>
    <style>
        table {
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
        }
        </style>
</head>
<script>
    function creaTabella() {
        var numero = document.getElementById("numero").value;
        var tabella = document.getElementById("tabella");
        let cose =    "<table><tr><th>dati</th><th>X(A)</th><th>X(B)</th></tr>";
        if (numero > 0) {
            for (let i = 0; i < numero; i++) {
                cose += "<tr><td>dato " + (i+1) + "</td><td><input type='number'></td><td><input type='number'></td></tr>";
            }
            cose += "</table>";
        tabella.innerHTML = cose;

        }
    }
</script>
<body>
    <div>
    <label for="numero">inserisci il numero di righe</label>
        <input type="number" id="numero" value=2>
        <button onclick="creaTabella()">crea tabella</button>
    </div>
    <div id="tabella">

    </div>


</body>
</html>
