<?php
    session_start();
    $title = "Perfil de " . $_SESSION["username"];
    require_once("templates/open.php");
?>
    <body>
        <div class="container-fluid my-5 d-flex justify-content-center">
            <div class="row mt-3 user-profile-container">
                <div class="col-md-4 p-4 d-flex justify-content-center align-items-center border">
                    <div class="row user-info d-flex justify-content-center align-items-center">
                        <img class="w-50 h-50 rounded-circle object-fit-cover" src="<?php echo "uploads/" . $user_data["image"] ?>" alt="Imagen de usuario">
                        <h2 class="username display-6 text-center"><?php echo $_SESSION["username"] ?></h2>
                        <h5 class="user-fullname text-center"><?php echo $user_data["fullname"] ?></h5>
                        <p class="user-email text-center"><?php echo $user_data["email"] ?></p>
                        <p class="user-location text-center"><i class="fa-solid fa-location-dot"></i> <?php echo $user_data["city"] ?></p>
    
                        <button class="submit-btn mb-2 edit-profile-btn">
                            <i class="fa-solid fa-pencil"></i> Editar perfil
                        </button>
                    </div>
                </div>
    
                <div class="col-md-4 my-auto">
                    <div class="edit-profile-container d-none">
                        <form name="edit-profile-form" class="needs-validation" novalidate method="POST" action="#" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="pass" class="form-label">Cambiar contraseña</label>
                                <input type="password" class="form-control" name="pass" id="pass">
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="mb-3">
                                <label for="fullname" class="form-label">Nombre completo</label>
                                <input type="text" class="form-control" name="fullname" id="fullname">
                                <div class="invalid-feedback"></div>
                            </div>
        
                            <div class="mb-3">
                                <label for="imageEdit" class="form-label">Foto de perfil</label>
                                <input type="file" class="form-control" name="image" id="imageEdit">
                                <div class="invalid-feedback"></div>
                            </div>
        
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </form>

                        <div class="modal fade" id="editProfileSuccessModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Operación realizada <i class="fa-solid fa-badge-check"></i></h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Datos de usuario actualizados.
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="return-home-btn submit-btn">¡Vale!</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- JavaScript -->
        <script src="public/js/profile.js"></script>

        <!-- Bootstrap y Font Awesome -->
        <?php require_once("templates/cdns.php"); ?>
    </body>
</html>