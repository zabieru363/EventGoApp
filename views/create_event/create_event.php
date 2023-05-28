<?php
session_start();
$title = "Crear evento";
require_once("templates/open.php");
?>

<body>
    <?php require_once("templates/header.php"); ?>

    <div class="container shadow p-5 mt-3 mb-3">
        <h1>Crear evento público</h1>

        <!-- Formulario para crear eventos -->
        <form name="create-event-form" method="POST" novalidate class="needs-validation" action="#" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="event_title" class="form-label">Título del evento</label>
                <input type="text" class="form-control" id="event_title" name="event_title" placeholder="Título del evento">
                <div class="invalid-feedback"></div>
            </div>

            <div class="mb-3">
                <label for="event_description" class="form-label">Descripción</label>
                <textarea class="form-control" id="event_description" name="event_description" rows="3" placeholder="Información del evento"></textarea>
                <div class="invalid-feedback"></div>
            </div>

            <div class="mb-3">
                <label for="administrator" class="form-label">El evento está organizado por</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="adminRadio" id="me" value="me">
                    <label class="form-check-label" for="me">Yo mismo</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="adminRadio" id="other" value="other">
                    <label class="form-check-label" for="other">Otra persona</label>
                </div>

                <input type="text" class="d-none form-control mt-2" id="administrator_name" name="administrator_name" placeholder="Pedro Garcia">
                <div class="invalid-feedback"></div>
            </div>

            <div class="mb-3">
                <div class="row">
                    <div class="col">
                        <label for="locations" class="form-label">Lugar del evento</label>
                        <select class="form-select" id="locations" name="locations">
                            <option value="">Seleccione una localización</option>
                            <?php foreach($cities as $city) echo "<option value='{$city->__get("id")}'>{$city->__get("name")}</option>"; ?>
                        </select>
        
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="col">
                        <label for="locations" class="form-label">Categoria del evento</label>
                        <select class="form-select" id="event_categories" name="event_categories">
                            <option value="">Seleccione una categoria</option>
                            <?php foreach($categories as $category) echo "<option value='{$category->__get("id")}'>{$category->__get("name")}</option>"; ?>
                        </select>
        
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <div class="row">
                    <div class="col">
                        <label for="start_date" class="form-label">Fecha y hora de inicio</label>
                        <input type="datetime-local" class="form-control" id="start_date" name="start_date">
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="col">
                        <label for="end_date" class="form-label">Fecha y hora de finalización</label>
                        <input type="datetime-local" class="form-control" id="end_date" name="end_date">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
            </div>

            <div class="mb-3 event-images">
                <label for="images" class="form-label">Fotos del evento</label>
                <input type="file" class="form-control" id="images" name="images[]" multiple>
                <div class="form-text">Se pueden subir hasta 3 imagenes cómo máximo</div>
                <div class="invalid-feedback"></div>
            </div>

            <button type="submit" class="submit-btn">Crear evento</button>
        </form>
    </div>

    <div class="modal fade" id="createEventModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel"> <i class="fa-solid fa-badge-check"></i></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body"></div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="public/js/createEvent.js"></script>

    <!-- Bootstrap y Font Awesome -->
    <?php require_once("templates/cdns.php"); ?>
</body>

</html>