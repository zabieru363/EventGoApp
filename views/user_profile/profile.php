<?php
    session_start();
    $title = "Perfil de " . $_SESSION["username"];
    $css = "../../public/css/styles.css";
    require_once("../../templates/open.php");
?>
    <body>
        <div class="container-fluid my-5">
            <div class="row p-5 user-profile-container">

                <div class="col-md-3 p-4 d-flex justify-content-center align-items-center border">
                    <div class="row user-info text-center">
                        <img class="rounded-circle w-100 h-100 object-fit-cover" src="" alt="Imagen de usuario">
                        <h2 class="display-6"></h2>
                        <h5 class="user-fullname"></h5>
                        <p class="user-email"></p>
    
                        <button class="submit-btn mb-2 edit-profile-btn">
                            <i class="fa-solid fa-pencil"></i> Editar perfil
                        </button>
                        <button class="submit-btn events-button show-all-events-btn">
                            <i class="fa-solid fa-calendar-days"></i> Mis eventos
                        </button>
                    </div>
                </div>
    
                <div class="col-md-9 my-auto dynamic-profile-container">
                    <div class="events-container d-none">
                        <div class="text-center">
                            <h1>Tus eventos</h1>
                        </div>
    
                        <div class="d-flex justify-content-center">
                            <button class="btn btn-outline-primary me-3" type="button" data-bs-toggle="offcanvas"
                                data-bs-target="#publicEvents" aria-controls="offcanvasRight">Publicados <i
                                    class="fa-solid fa-earth-americas"></i></button>
    
                            <div class="offcanvas offcanvas-end" tabindex="-1" id="publicEvents"
                                aria-labelledby="publicEventsLabel">
                                <div class="offcanvas-header border">
                                    <h5 class="offcanvas-title" id="publicEventsLabel">Eventos que has publicado</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                        aria-label="Close"></button>
                                </div>
                                <div class="offcanvas-body">
                                    <div class="card public-event">
                                        <div class="card-body">
                                            <h5 class="">Fiesta en mi casa, parti hard</h5>
                                            <p>Empieza el 19/96/2023 a las 16:30:00</p>
                                            <i class="fa-solid fa-location-dot"></i> <strong>Ciudad Real</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
    
                            <button class="btn btn-outline-success" type="button" data-bs-toggle="offcanvas"
                                data-bs-target="#pEvents" aria-controls="offcanvasRight">En los que participas <i
                                    class="fa-solid fa-users"></i></button>
    
                            <div class="offcanvas offcanvas-end" tabindex="-1" id="pEvents" aria-labelledby="pEventsLabel">
                                <div class="offcanvas-header border">
                                    <h5 class="offcanvas-title" id="pEventsLabel">Eventos en los que participas</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                        aria-label="Close"></button>
                                </div>
                                <div class="offcanvas-body"></div>
                            </div>
                        </div>
    
                        <div class="d-flex justify-content-center mt-3">
                            <button class="btn btn-outline-warning me-3" type="button" data-bs-toggle="offcanvas"
                                data-bs-target="#pendingEvents" aria-controls="offcanvasRight">Pendientes de confirmación <i
                                    class="fa-solid fa-triangle-exclamation"></i></i></button>
    
                            <div class="offcanvas offcanvas-end" tabindex="-1" id="pendingEvents"
                                aria-labelledby="pendingEventsLabel">
                                <div class="offcanvas-header border">
                                    <h5 class="offcanvas-title" id="pendingEventsLabel">Eventos por confirmar</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                        aria-label="Close"></button>
                                </div>
                                <div class="offcanvas-body">
                                    <div class="card pending-event">
                                        <div class="card-body border">
                                            <h5 class="">Fiesta en mi casa, parti hard</h5>
                                            <p>Empieza el 19/96/2023 a las 16:30:00</p>
                                            <div>
                                                <i class="fa-solid fa-location-dot"></i> <strong>Ciudad Real</strong>
                                                <button class="btn btn-success">Iré</button>
                                                <button class="btn btn-danger">No iré</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
    
                            <button class="btn btn-outline-danger" type="button" data-bs-toggle="offcanvas"
                                data-bs-target="#canceledEvents" aria-controls="offcanvasRight">Cancelados <i
                                    class="fa-solid fa-xmark"></i></button>
    
                            <div class="offcanvas offcanvas-end" tabindex="-1" id="canceledEvents"
                                aria-labelledby="canceledEventsLabel">
                                <div class="offcanvas-header border">
                                    <h5 class="offcanvas-title" id="canceledEventsLabel">Eventos cancelados</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                        aria-label="Close"></button>
                                </div>
                                <div class="offcanvas-body"></div>
                            </div>
                        </div>
                    </div>

                    <div class="w-50 edit-profile-container d-none">
                        <form name="edit-profile-form" class="needs-validation" novalidate method="POST" action="#" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="username" class="form-label">Nombre de usuario</label>
                                <input type="text" class="form-control" name="username" id="username">
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="mb-3">
                                <label for="fullname" class="form-label">Nombre completo</label>
                                <input type="text" class="form-control" name="fullname" id="fullname">
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" id="email">
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
        <script src="../../public/js/profile.js"></script>

        <!-- Bootstrap y Font Awesome -->
        <?php require_once("../../templates/cdns.php"); ?>
    </body>
</html>