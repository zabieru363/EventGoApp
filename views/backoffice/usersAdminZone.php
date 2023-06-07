<?php
session_start();
$title = "Administrar usuarios";
require_once("templates/open.php");
?>

    <body>
        <main>
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
                                    foreach($users as $user)
                                    {
                                        echo "
                                            <tr>
                                                <td><input type='checkbox' value=" . $user["id"] . "></td>
                                                <td>" . $user["username"] . "</td>
                                                <td>" . $user["type"] . "</td>
                                                <td>" . $user["name"] . "</td>
                                                <td>" . $user["email"] . "</td>
                                                <td>" . $user["city"] . "</td>
                                                <td>" . $user["active"] . "</td>
                                                <td>" . $user["register_date"] . "</td>
                                            </tr>
                                        ";
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>

        <!-- JavaScript -->

        <!-- Bootstrap y font-awesome --->
        <?php require_once("templates/cdns.php"); ?>
    </body>

</html>