<?php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Producto</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
                <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>/view/css/main.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Agregar Nuevo Producto</h2>
        <?php if (isset($error)) { echo '<div class="alert alert-danger">' . $error . '</div>'; } ?>
        <form action="c-producto-save.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripcion:</label>
                <textarea class="form-control" id="descripcion" name="descripcion" required></textarea>
            </div>
            <div class="form-group">
                <label for="precio">Precio:</label>
                <input type="number" step="0.01" class="form-control" id="precio" name="precio" required>
            </div>
            <div class="form-group">
                <label for="estado">Estado:</label>
                <select class="form-control form-control-lg" id="estado" name="estado" required>
                    <option value="disponible">Disponible</option>
                    <option value="agotado">Agotado</option>
                    <option value="descontinuado">Descontinuado</option>
                </select>
            </div>
            <div class="form-group">
                <label for="codMarca">Marca:</label>
                <select class="form-control form-control-lg" id="codMarca" name="codMarca" required>
                    <option value="">Seleccione</option>
                    <?php foreach ($marcas as $marca) {
                        $codMarca = $marca["COD"] ?? $marca["cod"] ?? "";
                        $nombreMarca = $marca["NOMBRE"] ?? $marca["nombre"] ?? "";
                    ?>
                        <option value="<?php echo $codMarca; ?>"><?php echo $nombreMarca; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="codIndustria">Industria:</label>
                <select class="form-control form-control-lg" id="codIndustria" name="codIndustria" required>
                    <option value="">Seleccione</option>
                    <?php foreach ($industrias as $industria) {
                        $codIndustria = $industria["COD"] ?? $industria["cod"] ?? "";
                        $nombreIndustria = $industria["NOMBRE"] ?? $industria["nombre"] ?? "";
                    ?>
                        <option value="<?php echo $codIndustria; ?>"><?php echo $nombreIndustria; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="codCategoria">Categoria:</label>
                <select class="form-control form-control-lg" id="codCategoria" name="codCategoria" onchange="autoFillCarpeta()" required>
                    <option value="" data-carpeta="">Seleccione</option>
                    <?php foreach ($categorias as $categoria) {
                        $codCategoria = $categoria["COD"] ?? $categoria["cod"] ?? "";
                        $nombreCategoria = $categoria["NOMBRE"] ?? $categoria["nombre"] ?? "";
                        $carpetaNombre = preg_replace('/[^a-zA-Z0-9_-]/', '', strtolower($nombreCategoria));
                    ?>
                        <option value="<?php echo $codCategoria; ?>" data-carpeta="<?php echo $carpetaNombre; ?>"><?php echo $nombreCategoria; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group" style="display:none;">
                <input type="hidden" class="form-control" id="carpeta" name="carpeta" value="productos">
            </div>
            <div class="form-group">
                <label for="imagen">Imagen:</label>
                <input type="file" class="form-control-file" id="imagen" name="imagen" accept="image/*" onchange="previewImage(event)" required>
            </div>
            <div id="image-preview" class="image-preview-box">
                <img id="preview-img" src="" alt="Vista previa" style="display:none;">
            </div>
            <button type="submit" class="btn btn-success">Agregar Producto</button>
            <a href="c-producto-list.php" class="btn btn-secondary">Volver</a>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
    function autoFillCarpeta() {
        var select = document.getElementById('codCategoria');
        var carpetaInput = document.getElementById('carpeta');
        var selectedOption = select.options[select.selectedIndex];
        var carpeta = selectedOption.getAttribute('data-carpeta');
        if (carpeta) {
            carpetaInput.value = carpeta;
        }
    }
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var img = document.getElementById('preview-img');
            img.src = reader.result;
            img.style.display = 'block';
        }
        if (event.target.files[0]) {
            reader.readAsDataURL(event.target.files[0]);
        }
    }
    </script>
</body>
</html>




