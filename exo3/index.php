<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>exoFetch3</title>
</head>
<body>

    <br>

    <h1>Intégration à une base de données</h1>

    <br>

    <div id = container>

        <form id= "form" action="insert.php" method="POST">

            <input type="number" id="number" name = "number" placeholder="Nombre d'éléments à créer">
            

            <input type="number" name = "firstname" min="1" max="5" step="1" id="firstname" placeholder="Nombre de syllables prénom">
            

            <input type="number" name = "lastname" min="1" max="5" step="1" id="lastname" placeholder="Nombre de syllables nom">


            <button id=button >Submit</button>

        </form>

    </div>
    
    </body>
</html>