<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Algebra lineare</title>
        <style>
            table {
                border-collapse: collapse;
            }

            table,
            th,
            td {
                border: 1px solid black;
            }
        </style>
    </head>
    <script src="nerdamer.core.js"></script>
    <!-- assuming you've saved the file in the root of course -->
    <!-- LOAD MODULES -->
    <script src="Algebra.js"></script>
    <script src="Calculus.js"></script>
    <script src="Solve.js"></script>
    <script src="Extra.js"></script>
    <script>
        function creaTabella() {
            var numero = document.getElementById("numero").value;
            var tabella = document.getElementById("tabella");
            let cose =
                "<table><tr><th>dati</th><th><input type='text' value= 'X'></th><th><input type='text' value= 'Y'></th><th>" +
                "<input type='radio' name='tot' value='min' checked='checked'>min</input><input type='radio' name='tot' value='max'>max</input></th>" +
                "<th></tr>";
            if (numero > 0) {
                for (let i = 0; i < numero; i++) {
                    cose +=
                        "<tr id='" +
                        i +
                        "''><td><input type='text' value='dato " +
                        (i + 1) +
                        "'</td><td><input type='number' value=0></td><td><input type='number' value=0></td><td><input type='number' value=0></td></tr>";
                }
                cose +=
                    "<tr id='prezzi'><td>Prezzo</td><td><input type='number' value=0></td><td><input type='number' value=0></td></td></tr>";
                cose += "</table>";
                tabella.innerHTML = cose;
            }
        }
        function calcola() {
            var numero = document.getElementById("numero").value;
            var tabella = document.getElementById("tabella");
            var dati = [];
            var prezzi = {
                x: document.getElementById("prezzi").children[1].children[0].value,
                y: document.getElementById("prezzi").children[2].children[0].value
            };
            for (let i = 0; i < numero; i++) {
                var x = document.getElementById(i).children[1].children[0].value;
                var y = document.getElementById(i).children[2].children[0].value;
                var totale = document.getElementById(i).children[3].children[0].value;
                dati[i] = { x: x, y: y, totale: totale };
            }
            var rette = [];
            for (let i = 0; i < numero; i++) {
                var x = dati[i].x;
                var y = dati[i].y;
                var totale = dati[i].totale;
                var a = nerdamer(-x + "/" + y + "*x+" + totale + "/" + y);
                console.log(a.text());
                rette[i] = a.text();
            }
            //trovo tutte le intersezioni
            console.log("intersezioni")
            var intersezioni = [];
            for (let i = 0; i < numero; i++) {
                for (let j = i + 1; j < numero; j++) {
                    try{
                    var x = nerdamer.solveEquations(rette[i] + "=" + rette[j], "x");
                    //trovo il valore della y
                    var y = nerdamer(rette[i].replace("x", x.toString()));
                    intersezioni.push({
                        x: eval(x.toString()),
                        y: eval(y.toString()),
                        i: i,
                        j: j
                    });
                    console.log(eval(x.toString()), eval(y.toString()), i, j);
                }catch (e) {
                    console.log(e);
                }
                }
            }
            //trovo le intersezioni con l'asse x
            console.log("intersezioni con l'asse x")
            for (let i = 0; i < numero; i++) {
                var x = nerdamer.solveEquations(rette[i] + "=0", "x");
                var y = 0;
                intersezioni.push({
                    x: eval(x.toString()),
                    y: eval(y.toString()),
                    i: i,
                    j: i
                });
                console.log(eval(x.toString()), eval(y.toString()), i, i);
            }
            //trovo le intersezioni con l'asse y
            console.log("intersezioni con l'asse y")
            for (let i = 0; i < numero; i++) {
                var x = 0;
                var y = dati[i].totale / dati[i].y;
                intersezioni.push({
                    x: eval(x.toString()),
                    y: eval(y.toString()),
                    i: i,
                    j: i
                });
                console.log(eval(x.toString()), eval(y.toString()), i, i);
            }

            var tipo = document.querySelector('input[name="tot"]:checked').value;
            var risultati = [];
            //trovo il valore della x e della y di ogni intersezione
            console.log("prezzi")
            for (let i = 0; i < intersezioni.length; i++) {
                console.log(intersezioni[i].x, intersezioni[i].y, intersezioni[i].i, intersezioni[i].j);
                var x = eval(intersezioni[i].x);
                if (x < 0) {
                    continue;
                }
                var y = eval(intersezioni[i].y);
                if (y < 0) {
                    continue;
                }
                var prezzo = x*prezzi.x + y*prezzi.y;
                switch(tipo){
                    case "min":
                        if(prezzo<0){
                            continue;
                        }
                        //controllo se il è maggiore o appartiene a tutte le rette
                        for(let j=0;j<numero;j++){
                            if(Math.round(x*dati[j].x + y*dati[j].y)<dati[j].totale){
                                console.log("morto a",  x,prezzi.x, y, prezzi.y, dati[j].x, dati[j].y, dati[j].totale, intersezioni[i].i, intersezioni[i].j);
                                break;
                            }else{
                                if(j==numero-1){
                                    risultati.push({x: x, y: y, prezzo: prezzo});
                                    console.log(x,prezzi.x, y, prezzi.y);
                                    console.log(prezzo);
                                }
                            }
                        }
                        break;
                    case "max":
                        if(prezzo<0){
                            continue;
                        }
                        //controllo se il è minore o appartiene a tutte le rette
                        for(let j=0;j<numero;j++){
                            if(Math.round(x*dati[j].x + y*dati[j].y)>dati[j].totale){
                                console.log("morto a",  x,prezzi.x, y, prezzi.y, dati[j].x, dati[j].y, dati[j].totale, intersezioni[i].i, intersezioni[i].j);
                                break;
                            }else{
                                if(j==numero-1){
                                    risultati.push({x: x,y: y,prezzo: prezzo});
                                    console.log(x,prezzi.x, y, prezzi.y);
                                    console.log(prezzo);
                                }
                            }
                        }
                        break;
                }
                
            }
            console.log(risultati);
            var risultato = "";
            switch (tipo) {
                case "min":
                    //trovo il prezzo minore
                    risultato = Math.min.apply(Math, risultati.map(function(o) { return o.prezzo; }))
                    break;
                case "max":
                    //trovo il prezzo maggiore
                    risultato = Math.max.apply(Math, risultati.map(function(o) { return o.prezzo; }))
                    break;
            }
            console.log(risultato);
            rissultato=document.getElementById("risultato");
            switch(tipo){
                case "min":
                    tipo="minimo";
                    break;
                case "max":
                    tipo="massimo";
                    break;
            }
            rissultato.innerHTML="per ottenere il prezzo "+tipo+" bisogna comprare "+risultati.filter(function(o) { return o.prezzo==risultato; })[0].x+" di X e "+risultati.filter(function(o) { return o.prezzo==risultato; })[0].y+" di Y";
            //disegna il grafico
            var canvas = document.getElementById("grafico");
            var ctx = canvas.getContext("2d");
            ctx.beginPath();
            ctx.moveTo(0, 0);
            ctx.lineTo(0, 400);
            ctx.lineTo(400, 400);
            ctx.lineTo(400, 0);
            ctx.lineTo(0, 0);
            ctx.stroke();
            for (let i = 0; i < numero; i++) {
                ctx.beginPath();
                ctx.moveTo(0, 400-(dati[i].totale / dati[i].y )* 40);
                console.log(0,dati[i].totale / dati[i].y * 40);
                ctx.lineTo(dati[i].totale / dati[i].x * 40, 400);
                console.log(dati[i].totale / dati[i].x * 40,0);
                ctx.stroke();
            }
            document.body.appendChild(canvas);
        }
    </script>
    <body>
        <div>
            <label for="numero">inserisci il numero di righe</label>
            <input type="number" id="numero" value="4" />
            <button onclick="creaTabella()">crea tabella</button>
            <button onclick="calcola()">calcola</button>
        </div>
        <div id="tabella"></div>
        <div id="risultato"></div>
        <div>
            <canvas id="grafico" width="400" height="400"></canvas>
        </div>
    </body>
</html>
