<?php
    $title = "Detalles del evento";
    require_once("templates/open.php");
?>
    <body>
        <?php require_once("templates/basic_header.php"); ?>

        <?php
            if(isset($_SESSION["id_user"]))
            {
                $carousel_HTML = "";

                for($i = 0; $i < count($event_images); $i++)
                {
                    if($i == 0)
                    {
                      $carousel_HTML .= "
                        <div class='carousel-item active'>
                            <img src='uploads/{$event_images[$i]}' class='d-block w-100' alt='Imagen del evento'>
                        </div>";
                    }
                    else
                    {
                      $carousel_HTML .= "
                        <div class='carousel-item'>
                            <img src='uploads/{$event_images[$i]}' class='d-block w-100' alt='Imagen del evento'>
                        </div>";
                    }
                }

                $dropdown_HTML = "";

                if($event["rule"] == 1)
                {
                    $dropdown_HTML = "<div class='dropdown' rule='1'>
                        <button class='btn btn-primary dropdown-toggle' type='button' data-bs-toggle='dropdown' aria-expanded='false'>
                            Participar
                        </button>
                        <ul class='dropdown-menu event-participation-options'>
                            <li class='dropdown-item opt2'>Puedo ir</li>
                            <li class='dropdown-item opt3'>No puedo ir</li>
                            <li class='dropdown-item opt4'>Todavía no lo se</li>
                        </ul>
                    </div>";
                }

                if($event["rule"] == 2)
                {
                    $dropdown_HTML = "<div class='dropdown' rule='2'>
                        <button class='btn btn-success'>Participaré</button>
                    </div>";
                }

                if($event["rule"] == 3)
                {
                    $dropdown_HTML = "<div class='dropdown' rule='3'>
                        <button class='btn btn-danger'>No participaré</button>
                    </div>";
                }

                if($event["rule"] == 4)
                {
                    $dropdown_HTML = "<div class='dropdown' rule='4'>
                        <button class='btn btn-warning dropdown-toggle' type='button' data-bs-toggle='dropdown' aria-expanded='false'>
                            Pendiente de confirmar
                        </button>
                        <ul class='dropdown-menu event-participation-options'>
                            <li class='dropdown-item opt2'>Puedo ir</li>
                            <li class='dropdown-item opt3'>No puedo ir</li>
                        </ul>
                    </div>";
                }

                $start_date_time = explode(" ", $event["start_date"]);
                $end_date_time = explode(" ", $event["ending_date"]);

                echo "
                    <div class='container session-active'>
                        <div class='mt-4 card mb-3' data-id={$event["id"]}>
                            <h1 class='card-header display-6 p-3 text-center'>{$event["title"]}</h1>
                            <div class='card-body'>
                                <div id='carouselControls' class='carousel slide mb-3' data-bs-ride='carousel'>
                                    <div class='carousel-inner'>" .
                                        $carousel_HTML . "
                                    </div>
                                <button class='carousel-control-prev' type='button' data-bs-target='#carouselControls' data-bs-slide='prev'>
                                    <span class='carousel-control-prev-icon' aria-hidden='true'></span>
                                    <span class='visually-hidden'>Previous</span>
                                </button>
                                <button class='carousel-control-next' type='button' data-bs-target='#carouselControls' data-bs-slide='next'>
                                    <span class='carousel-control-next-icon' aria-hidden='true'></span>
                                    <span class='visually-hidden'>Next</span>
                                </button>
                            </div>

                            <h5 class='card-title'>Organizado por {$event["admin"]}</h5>
                            <div class='card-text'>
                                <p class='event-description'>
                                    {$event["description"]}
                                </p>
                                <i class='fa-solid fa-clock'></i> Empieza el <strong>{$start_date_time[0]}</strong> a las {$start_date_time[1]} y termina el <strong>{$end_date_time[0]}</strong> a las {$end_date_time[1]}
                                <p><strong><i class='fa-solid fa-location-dot'></i> {$event["city"]}</strong></p>
                            </div>" .
                            $dropdown_HTML .
                        "</div>
                    </div>
                <div>";
            }
            else
            {
                $carousel_HTML = "";

                for($i = 0; $i < count($event_images); $i++)
                {
                    if($i == 0)
                    {
                      $carousel_HTML .= "
                        <div class='carousel-item active'>
                            <img src='uploads/{$event_images[$i]}' class='d-block w-100' alt='Imagen del evento'>
                        </div>";
                    }
                    else
                    {
                      $carousel_HTML .= "
                        <div class='carousel-item'>
                            <img src='uploads/{$event_images[$i]}' class='d-block w-100' alt='Imagen del evento'>
                        </div>";
                    }
                }

                echo "
                    <div class='container session-clossed'>
                        <div class='mt-4 card mb-3' data-id={$event["id"]}>
                            <h1 class='card-header display-6 p-3 text-center'>{$event["title"]}</h1>
                            <div class='card-body'>
                                <div id='carouselControls' class='carousel slide mb-3' data-bs-ride='carousel'>
                                    <div class='carousel-inner'>" .
                                        $carousel_HTML . "
                                    </div>
                                <button class='carousel-control-prev' type='button' data-bs-target='#carouselControls' data-bs-slide='prev'>
                                    <span class='carousel-control-prev-icon' aria-hidden='true'></span>
                                    <span class='visually-hidden'>Previous</span>
                                </button>
                                <button class='carousel-control-next' type='button' data-bs-target='#carouselControls' data-bs-slide='next'>
                                    <span class='carousel-control-next-icon' aria-hidden='true'></span>
                                    <span class='visually-hidden'>Next</span>
                                </button>
                            </div>

                            <h5 class='card-title'>Organizado por {$event["admin"]}</h5>
                            <div class='card-text'>
                                <p class='event-description'>
                                    {$event["description"]}
                                </p>
                                <p class='event-date'><i class='fa-solid fa-clock'></i> Empieza el <strong>{$event["start_date"]}</strong>, finaliza el <strong>{$event["ending_date"]}</strong></p>
                                <p><strong><i class='fa-solid fa-location-dot'></i> {$event["city"]}</strong></p>
                            </div>
                            <div class='dropdown' rule='1'>
                                <button class='btn btn-primary dropdown-toggle' type='button' data-bs-toggle='dropdown' aria-expanded='false'>
                                    Participar
                                </button>
                                <ul class='dropdown-menu event-participation-options'>
                                    <li class='dropdown-item opt2'>Puedo ir</li>
                                    <li class='dropdown-item opt3'>No puedo ir</li>
                                    <li class='dropdown-item opt4'>Todavía no lo se</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                <div>";
            }
        ?>

        <div class="modal fade" id="eventParticipationModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="eventParticipationModal">Operación realizada</h1>
                    </div>
                    <div class="modal-body event-participation-modal-body"></div>
                    <div class="modal-footer">
                        <button type="button" id="closeEventsParticipationModalBtn" class="submit-btn text-decoration-none">De acuerdo</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- JavaScript -->
        <script src="public/js/eventDetailsControl.js"></script>

        <!-- Bootstrap y Font Awesome -->
        <?php require_once("templates/cdns.php"); ?>
    </body>
</html>