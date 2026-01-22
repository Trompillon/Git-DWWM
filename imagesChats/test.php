<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<form action="test1.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="productName">Nom du produit</label>
            <input type="text" name="productName" class="form-control" placeholder="Entrez le nom du produit">
        </div>
        <div class="form-group">
            <label for="productPrice">Prix</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">€</span>
                    </div>
                    <input type="text" name="productPrice" class="form-control" placeholder="Entrez le prix du produit">
                </div>
        </div>
            <div class="form-group">
                <label for="productImg">Image</label>
                <input type="file" name="productImg" class="form-control-file">
            </div>
            <div class="form-group">
                <label for="productDescription">Description</label>
                <textarea name="productDescription" class="form-control" rows="3"></textarea>
            </div>
        <button type="submit" class="btn btn-primary">Envoyer</button>
    </form>

</body>
</html>



