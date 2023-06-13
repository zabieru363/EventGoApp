<?php
    $title = "Detalles del evento";
    require_once("templates/open.php");
?>
    <body>
        <?php require_once("templates/basic_header.php"); ?>

        <?php
            if(isset($event["rule"]))
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

                $dropdown_HTML = match($event["rule"])
                {
                    2 => "<button class='btn btn-success'>Participaré</button>",
                    3 => "<button class='btn btn-danger'>No participaré</button>",
                    4 => "<div class='dropdown' rule='1'>
                            <button class='btn btn-warning dropdown-toggle' type='button' data-bs-toggle='dropdown' aria-expanded='false'>
                                Pendiente de confirmar
                            </button>
                            <ul class='dropdown-menu event-participation-options'>
                                <li class='dropdown-item op21'>Puedo ir</li>
                                <li class='dropdown-item opt3'>No puedo ir</li>
                            </ul>
                        </div>",
                    default => "<div class='dropdown' rule='1'>
                        <button class='btn btn-primary dropdown-toggle' type='button' data-bs-toggle='dropdown' aria-expanded='false'>
                            Participar
                        </button>
                        <ul class='dropdown-menu event-participation-options'>
                            <li class='dropdown-item op21'>Puedo ir</li>
                            <li class='dropdown-item opt3'>No puedo ir</li>
                            <li class='dropdown-item opt4'>Todavía no lo se</li>
                        </ul>
                    </div>"
                };

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
                                <p class='event-date'><i class='fa-solid fa-clock'></i> Empieza el <strong>{$event["start_date"]}</strong>, finaliza el <strong>{$event["ending_date"]}</strong></p>
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
                                    <li class='dropdown-item op21'>Puedo ir</li>
                                    <li class='dropdown-item opt3'>No puedo ir</li>
                                    <li class='dropdown-item opt4'>Todavía no lo se</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                <div>";
            }
        ?>

        <!-- Bootstrap y Font Awesome -->
        <?php require_once("templates/cdns.php"); ?>
    </body>
</html>