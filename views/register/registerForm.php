<?php
    $title = "Registrarse";
    $css = "../../public/css/styles.css";
    require_once("templates/open.php");
?>
    <body>
        <section class="wrapper d-flex justify-content-center">
            <div class="row mt-5">
                <div class="col-md-12">
                    <div class="p-5 shadow fields-container">
                        <h1 class="display-5 mb-3 text-center">Registro</h1>
                        <form class="needs-validation" name="register-form" method="POST" action="#" enctype="multipart/form-data" novalidate>
                            <div class="row">

                                <div class="col">
                                    <div class="mb-3">
                                        <label for="fullname" class="form-label">Nombre completo *</label>
                                        <input type="text" class="form-control" id="fullname" name="fullname" aria-describedby="emailHelp" placeholder="Ej: Pedro Garcia...">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                    
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email *</label>
                                        <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Ej: alguien@example.com">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Nombre de usuario *</label>
                                        <input type="text" class="form-control" id="username" name="username" aria-describedby="emailHelp" placeholder="Entre 8 y 15 caracteres">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="mb-3">
                                        <label for="cities" class="form-label">Selecciona tu ciudad *</label>
                                        <select name="cities" id="cities" class="form-select">
                                            <option value="">Selecciona tu ciudad</option>
                                            <?php
                                                foreach($cities as $city)
                                                {
                                                    echo "<option value=''>{$city->__get("name")}</option>";
                                                }
                                            ?>
                                        </select>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                            </div>
                                
                                
                            <div class="row">

                                <div class="col">
                                    <div class="mb-3">
                                        <label for="pass" class="form-label">Contraseña *</label>
                                        <input type="password" class="form-control" id="pass" name="pass" placeholder="Mínimo 8 caracteres, una mayúscula y un digito">
                                        <div class="form-text">No se admiten caracteres especiales (_, *, etc)</div>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                    
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="pass-confirmed" class="form-label">Confirmar contraseña *</label>
                                        <input type="password" class="form-control" id="passConfirmed">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3 d-flex justify-content-center">
                                <div class="circle">
                                    <label for="image" class="form-label"><i class="fa-solid fa-camera"></i> Imagen de perfil</label>
                                    <input type="file" class="form-control" id="image" name="image">
                                    <img id="preview" src="#" alt="Preview">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-center">
                                <button type="submit" name="register" class="submit-btn p-3">Registrarse</button>
                            </div>
                        </form>

                        <div class="modal fade" id="registerCompleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Registro completado <i class="fa-solid fa-badge-check"></i></h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        El usuario ha sido registrado correctamente.
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="return-home-btn submit-btn">Volver a inicio</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <script src="../../public/js/validateRegisterForm.js"></script>

        <!-- Bootstrap y Font Awesome -->
        <?php require_once("templates/cdns.php"); ?>
    </body>
</html>