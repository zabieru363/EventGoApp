<?php
    session_start();
    $title = "Crear una nueva categoria";
    require_once("templates/open.php");
?>
    <body>
        <?php require_once("templates/admin_header.php") ?>

        <div class="container-fluid mt-3">
            <div class="row">
                <div class="col-md-6">
                    <h4>Haga clic en una categoría para eliminarla</h4>
                    <?php
                        foreach($categories as $category)
                        {
                            echo "<div class='category shadow mt-2 p-2' data-id='{$category->__get("id")}'>{$category->__get("name")}</div>";
                        }
                    ?>
                </div>

                <div class="col-md-1"></div>

                <div class="col-md-4">
                    <h2 class="display-6">Crear una nueva categoría</h2>
                    <form class="needs-validation" name="create-categories-form" method="POST" action="#" novalidate>
                        <div class="mb-3">
                            <label for="category" class="form-label">Nombre de la nueva categoría</label>
                            <input type="text" class="form-control" id="category" name="category" aria-describedby="categoryHelp">
                            <div class="invalid-feedback"></div>
                        </div>
                        
                        <button type="submit" class="btn btn-success">Crear categoría</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- JavaScript -->
        <script src="public/js/adminCategoriesControl.js"></script>

        <!-- Bootstrap y Font Awesome -->
        <?php require_once("templates/cdns.php"); ?>
    </body>
</html>