<?php
    session_start();
    $title = "Administrar eventos";
    require_once("templates/open.php");
?>
    <body>
        <main>
            <?php require_once("templates/admin_header.php") ?>
            <div class="container py-4 text-center">
                <h2>Eventos</h2>

                <div class="row py-4">
                    <div class="col">
                        <table class="table table-sm table-bordered table-striped">
                            <thead>
                                <th>#</th>
                                <th>Titulo</th>
                                <th>Descripción</th>
                                <th>Administrador</th>
                                <th>Localidad</th>
                                <th>Fecha inicio</th>
                                <th>Fecha fin</th>
                                <th>Categoria</th>
                                <th>Activo</th>
                            </thead>

                            <!-- El id del cuerpo de la tabla. -->
                            <tbody id="content">
                                <?php
                                    foreach($params["events"] as $event)
                                    {
                                        $result_active = $event["active"] ? "SI" : "NO";
                                        echo "
                                            <tr class=user-row-" . $event["id"] . ">
                                                <td><input type='checkbox' class='user-selected' value=" . $event["id"] . "></td>
                                                <td>" . $event["title"] . "</td>
                                                <td>" . $event["description"] . "</td>
                                                <td>" . $event["admin"] . "</td>
                                                <td>" . $event["city"] . "</td>
                                                <td>" . $event["start_date"] . "</td>
                                                <td>" . $event["ending_date"] . "</td>
                                                <td>" . $event["category"] . "</td>
                                                <td>" . $result_active . "</td>
                                            </tr>
                                        ";
                                    }
                                ?>
                            </tbody>
                        </table>

                        <div class="user-pagination d-flex justify-content-center">
                            <nav class="pages" aria-label="pagination">
                                <ul class="pagination">
                                    <?php if ($params["pagination"]["current_page"] > 1): ?>
                                        <li class="page-item">
                                            <a class="page-link" href="?page=<?php echo $params["pagination"]["current_page"] - 1; ?>" aria-label="Anterior">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                    <?php for ($i = 1; $i <= $params["pagination"]["total_pages"]; $i++): ?>
                                        <?php $activeStyle = $i == $params["pagination"]["current_page"] ? "active" : ""; ?>

                                        <li class="page-item <?php echo $activeStyle?>" aria-current="page">
                                            <a class="page-link" href="index.php?url=admin&action=events&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                        </li>
                                    <?php endfor; ?>

                                    <?php if ($params["pagination"]["current_page"] < $params["pagination"]["total_pages"]): ?>
                                        <li class="page-item">
                                            <a class="page-link" href="?page=<?php echo $params["pagination"]["current_page"] + 1; ?>" aria-label="Siguiente">
                                                <span aria-hidden="true">&raquo;</span>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </nav>
                        </div>

                        <div>
                            <button class="btn btn-danger" id="delete-selected-users-btn"><i class="fa-sharp fa-solid fa-trash"></i> Eliminar seleccionados</button>
                            <button class="btn btn-danger" id="disabled-selected-users-btn"><i class="fa-sharp fa-solid fa-ban"></i> Desactivar seleccionados</button>
                            <button class="btn btn-success" id="active-selected-users-btn"><i class="fa-sharp fa-solid fa-circle-check"></i> Activar seleccionados</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="resultOperationModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="resultOperationModal">Proceso terminado <i class="fa-solid fa-badge-check"></i></h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body"></div>
                    </div>
                </div>
            </div>
        </main>

    <!-- JavaScript -->

    <!-- Bootstrap y font-awesome --->
    <?php require_once("templates/cdns.php"); ?>
</body>

</html>