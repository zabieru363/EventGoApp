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

                                                    <div class='mt-3'>
                                                        <button class='btn btn-danger' data-id={$public_event["id"]}><i class='fa-sharp fa-solid fa-trash'></i> Borrar este evento</button>
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
                                <?php
                                    foreach($user_participation_events as $participation_event)
                                    {
                                        echo "
                                            <div class='card mb-3' data-id='{$participation_event["id"]}'>
                                                <div class='card-body'>
                                                     <h4>{$participation_event["title"]}</h4>
    
                                                    <div class='event-admin'>
                                                        <h6>{$participation_event["admin"]}</h6>
                                                    </div>
    
                                                    <div class='event-description'>
                                                        {$participation_event["description"]}
                                                    </div>
    
                                                    <div class='event-location mt-3'>
                                                        <i class='fa-solid fa-location-dot'></i> {$participation_event["city"]}
                                                    </div>
    
                                                    <div class='event-date'>
                                                        <i class='fa-solid fa-clock'></i></i> 
                                                        Empieza el {$participation_event["start_date"]} y termina el {$participation_event["end_date"]}
                                                    </div>
                                            </div>
                                        </div>";
                                    }
                                ?>
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
                                <?php
                                    foreach($pending_events as $pending_event)
                                    {
                                        echo "
                                            <div class='card mb-3' data-id='{$pending_event["id"]}'>
                                                <div class='card-body'>
                                                     <h4>{$pending_event["title"]}</h4>
    
                                                    <div class='event-admin'>
                                                        <h6>{$pending_event["admin"]}</h6>
                                                    </div>
    
                                                    <div class='event-description'>
                                                        {$pending_event["description"]}
                                                    </div>
    
                                                    <div class='event-location mt-3'>
                                                        <i class='fa-solid fa-location-dot'></i> {$pending_event["city"]}
                                                    </div>
    
                                                    <div class='event-date'>
                                                        <i class='fa-solid fa-clock'></i></i> 
                                                        Empieza el {$pending_event["start_date"]} y termina el {$pending_event["end_date"]}
                                                    </div>
                                            </div>
                                        </div>";
                                    }
                                ?>
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
                                <?php
                                    foreach($cancelled_events as $cancelled_event)
                                    {
                                        echo "
                                            <div class='card mb-3' data-id='{$cancelled_event["id"]}'>
                                                <div class='card-body'>
                                                     <h4>{$cancelled_event["title"]}</h4>
    
                                                    <div class='event-admin'>
                                                        <h6>{$cancelled_event["admin"]}</h6>
                                                    </div>
    
                                                    <div class='event-description'>
                                                        {$cancelled_event["description"]}
                                                    </div>
    
                                                    <div class='event-location mt-3'>
                                                        <i class='fa-solid fa-location-dot'></i> {$cancelled_event["city"]}
                                                    </div>
    
                                                    <div class='event-date'>
                                                        <i class='fa-solid fa-clock'></i></i> 
                                                        Empieza el {$cancelled_event["start_date"]} y termina el {$cancelled_event["end_date"]}
                                                    </div>
                                            </div>
                                        </div>";
                                    }
                                ?>
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