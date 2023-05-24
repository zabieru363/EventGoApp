<?php
    session_start();
    $title = "Crear evento";
    require_once("templates/open.php");
?>
    <body>
        <?php require_once("templates/header.php"); ?>

        <div class="container">
            <h1>Crear evento público</h1>

            <!-- Formulario para crear eventos -->
            <form name="create-event-form" method="POST" novalidate action="#" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="event_title" class="form-label">Título del Evento</label>
                    <input type="text" class="form-control" id="event_title" name="event_title" placeholder="Título del evento">
                </div>

                <div class="mb-3">
                    <label for="event_description" class="form-label">Descripción</label>
                    <textarea class="form-control" id="event_description" name="event_description" rows="3" placeholder="Información del evento"></textarea>
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
                </div>

                <div class="mb-3">
                    <label for="locations" class="form-label">Lugar del evento</label>
                    <select class="form-select" id="locations" name="locations">
                        <option value="">Seleccione una localización</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="start_date" class="form-label">Fecha y hora de inicio</label>
                    <input type="datetime-local" class="form-control" id="start_date" name="start_date">
                </div>

                <div class="mb-3">
                    <label for="end_date" class="form-label">Fecha y hora de finalización</label>
                    <input type="datetime-local" class="form-control" id="end_date" name="end_date">
                </div>

                <div class="mb-3">
                    <label for="images" class="form-label">Fotos del evento</label>
                    <input type="file" class="form-control" id="images" name="images[]" multiple>
                </div>

                <button type="submit" class="submit-btn">Crear Evento</button>
            </form>
        </div>

        <!-- JavaScript -->

        <!-- Bootstrap y Font Awesome -->
        <?php require_once("templates/cdns.php"); ?>
    </body>
</html>