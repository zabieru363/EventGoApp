<?php
    session_start();
    $title = "Mis eventos";
    require_once("templates/open.php");
?>
    <body>
        <?php require_once("templates/basic_header.php"); ?>

        <div class="container-fluid shadow mt-5 p-3 w-50">
            <div class="user-events-header">
                <h1 class="display-6">Tus eventos</h1>
            </div>
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="row user-event-option">
                        <a data-bs-toggle="offcanvas" href="#offcanvas-o1" role="button" aria-controls="offcanvasExample">
                            <p>Eventos publicados <i class="ms-2 fa-solid fa-arrow-up-from-bracket"></i></p>
                        </a>

                        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvas-o1" aria-labelledby="offcanvasBottomLabel">
                            <div class="offcanvas-header">
                                <h5 class="offcanvas-title" id="offcanvasBottomLabel">Eventos publicados por ti</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body">
                                <?php
                                    foreach($public_user_events as $public_event)
                                    {
                                        echo "
                                            <div class='card mb-3' data-id='{$public_event["id"]}'>
                                                <div class='card-body'>
                                                     <h4>{$public_event["title"]}</h4>
    
                                                    <div class='event-admin'>
                                                        <h6>{$public_event["admin"]}</h6>
                                                    </div>
    
                                                    <div class='event-description'>
                                                        {$public_event["description"]}
                                                    </div>
    
                                                    <div class='event-location mt-3'>
                                                        <i class='fa-solid fa-location-dot'></i> {$public_event["city"]}
                                                    </div>
    
                                                    <div class='event-date'>
                                                        <i class='fa-solid fa-clock'></i></i> 
                                                        Empieza el {$public_event["start_date"]} y termina el {$public_event["end_date"]}
                                                    </div>
                                            </div>
                                        </div>";
                                    }
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="row user-event-option">
                        <a data-bs-toggle="offcanvas" href="#offcanvas-o2" role="button" aria-controls="offcanvasExample">
                            <p>Eventos en los que participas <i class="ms-2 fa-solid fa-users"></i></p>
                        </a>

                        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvas-o2" aria-labelledby="offcanvasBottomLabel">
                            <div class="offcanvas-header">
                                <h5 class="offcanvas-title" id="offcanvasBottomLabel">Eventos en los que participas</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h4>Titulo del evento</h4>

                                        <div class="event-admin">
                                            <h6>Organizado por [usuario]</h6>
                                        </div>

                                        <div cñass="event-description">
                                            Descripción sobre el evento.
                                        </div>

                                        <div class="event-location mt-3">
                                            <i class="fa-solid fa-location-dot"></i> Ciudad Real
                                        </div>

                                        <div class="event-date">
                                            <i class="fa-solid fa-clock"></i></i> Empieza el x y termina el x
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row user-event-option">
                        <a data-bs-toggle="offcanvas" href="#offcanvas-o3" role="button" aria-controls="offcanvasExample">
                            <p>Pendientes de confirmación <i class="ms-2 fa-solid fa-triangle-exclamation"></i></p>
                        </a>

                        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvas-o3" aria-labelledby="offcanvasBottomLabel">
                            <div class="offcanvas-header">
                                <h5 class="offcanvas-title" id="offcanvasBottomLabel">Pendientes de confirmación</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h4>Titulo del evento</h4>

                                        <div class="event-admin">
                                            <h6>Organizado por [usuario]</h6>
                                        </div>

                                        <div cñass="event-description">
                                            Descripción sobre el evento.
                                        </div>

                                        <div class="event-location mt-3">
                                            <i class="fa-solid fa-location-dot"></i> Ciudad Real
                                        </div>

                                        <div class="event-date">
                                            <i class="fa-solid fa-clock"></i></i> Empieza el x y termina el x
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row user-event-option">
                        <a data-bs-toggle="offcanvas" href="#offcanvas-o4" role="button" aria-controls="offcanvasExample">
                            <p>Eventos cancelados <i class="ms-2 fa-solid fa-xmark"></i></p>
                        </a>

                        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvas-o4" aria-labelledby="offcanvasBottomLabel">
                            <div class="offcanvas-header">
                                <h5 class="offcanvas-title" id="offcanvasBottomLabel">Eventos cancelados</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h4>Titulo del evento</h4>

                                        <div class="event-admin">
                                            <h6>Organizado por [usuario]</h6>
                                        </div>

                                        <div cñass="event-description">
                                            Descripción sobre el evento.
                                        </div>

                                        <div class="event-location mt-3">
                                            <i class="fa-solid fa-location-dot"></i> Ciudad Real
                                        </div>

                                        <div class="event-date">
                                            <i class="fa-solid fa-clock"></i></i> Empieza el x y termina el x
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap y font-awesome -->
       <?php require_once("templates/cdns.php"); ?> 
    </body>
</html>