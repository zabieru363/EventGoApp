<?php
    $title = "Administración";
    $css = "../../public/css/styles.css";
    require_once("../../templates/open.php");
?>
    <body>
        <header class="d-flex justify-content-between align-items-center p-2 border mb-5">
            <h1 class="display-6">Administración</h1>
        </header>

         <div class="user-form-container">
            <div class="d-flex justify-content-center mb-3">
                <form name="user-form" method="POST" axtion="#">
                    <label for="search-user" class="form-label">Buscar usuario</label>
                    <input type="search" name="search-user" id="search-user" class="form-control">
                </form>
            </div>

            <div class="d-flex justify-content-center">
                <button class="btn btn-danger">Eliminar seleccionados</button>
                <button class="btn btn-danger">Desactivar seleccionados</button>
            </div>
        </div>

        <div class="users-table-container container mt-3">
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <!-- Tabla de usuarios -->
                    <table class="table table-striped border">
                        <thead class="submit-btn">
                            <tr>
                                <th scope="col">Seleccionar</th>
                                <th scope="col">Nombre de usuario</th>
                                <th scope="col">Nombre completo</th>
                                <th scope="col">Email</th>
                                <th scope="col">Ciudad</th>
                                <th scope="col">Activo</th>
                                <th scope="col">Fecha de registro</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

        <div class="event-form-container">
            <div class="d-flex justify-content-center mb-3">
                <form name="event-form" method="POST" axtion="#">
                    <label for="search-event" class="form-label">Buscar evento</label>
                    <input type="search" name="search-event" id="search-event" class="form-control">
                </form>
            </div>

            <div class="d-flex justify-content-center">
                <button class="btn btn-danger">Eliminar seleccionados</button>
                <button class="btn btn-danger">Desactivar seleccionados</button>
            </div>
        </div>

        <div class="events-table-container container mt-3">
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <!-- Tabla de eventos -->
                    <table class="table table-striped border">
                        <thead class="submit-btn">
                            <tr>
                                <th scope="col">Seleccionar</th>
                                <th scope="col">Título</th>
                                <th scope="col">Descripción</th>
                                <th scope="col">Localidad</th>
                                <th scope="col">Creado por</th>
                                <th scope="col">Fecha de inicio</th>
                                <th scope="col">Fecha de finalizacion</th>
                                <th scope="col">Activo</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>