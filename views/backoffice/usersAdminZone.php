<?php
    session_start();
    $title = "Administrar usuarios";
    require_once("templates/open.php");
?>

    <body>
        <main>
            <?php require_once("templates/admin_header.php") ?>

            <div class="container py-4 text-center">
                <h2>Usuarios</h2>

                <div class="row py-4">
                    <div class="col">
                        <table class="table table-sm table-bordered table-striped">
                            <thead>
                                <th>#</th>
                                <th>Nombre de usuario</th>
                                <th>Tipo de usuario</th>
                                <th>Nombre completo</th>
                                <th>Email</th>
                                <th>Ciudad</th>
                                <th>Activo</th>
                                <th>Fecha registro</th>
                            </thead>

                            <!-- El id del cuerpo de la tabla. -->
                            <tbody id="content">
                                <?php
                                    foreach($params["users"] as $user)
                                    {
                                        if($user["username"] !== "admin_eventgo")
                                        {
                                            $result_active = $user["active"] ? "SI" : "NO";
                                            echo "
                                                <tr class=user-row-" . $user["id"] . ">
                                                    <td><input type='checkbox' class='user-selected' value=" . $user["id"] . "></td>
                                                    <td>" . $user["username"] . "</td>
                                                    <td>" . $user["type"] . "</td>
                                                    <td>" . $user["name"] . "</td>
                                                    <td>" . $user["email"] . "</td>
                                                    <td>" . $user["city"] . "</td>
                                                    <td>" . $result_active . "</td>
                                                    <td>" . $user["register_date"] . "</td>
                                                </tr>
                                            ";
                                        }
                                    }
                                ?>
                            </tbody>
                        </table>

                        <div class="user-pagination d-flex justify-content-center">
                            <nav class="pages" aria-label="pagination">
                                <ul class="pagination">
                                    <?php if ($params["pagination"]["current_page"] > 1): ?>
                                        <li class="page-item">
                                            <a class="page-link" href="index.php?url=admin&action=events&page=<?php echo $params["pagination"]["current_page"] - 1; ?>" aria-label="Anterior">
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
                                            <a class="page-link" href="index.php?url=admin&action=events&page=<?php echo $params["pagination"]["current_page"] + 1; ?>" aria-label="Siguiente">
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
        <script src="public/js/selectedUserControlSystem.js"></script>

        <!-- Bootstrap y font-awesome --->
        <?php require_once("templates/cdns.php"); ?>
    </body>

</html>