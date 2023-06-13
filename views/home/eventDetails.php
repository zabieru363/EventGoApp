<?php
    $title = "Detalles del evento";
    require_once("templates/open.php");
?>
    <body>
        <?php require_once("templates/basic_header.php"); ?>

        <?php
            if(isset($event["rule"]))
            {
                echo "

                ";
            }
            else
            {
                echo "
                    <div class='mt-4 card mb-3' data-id={$event["id"]}>
                        <h1 class='card-header display-6 p-3 text-center'>{$event["title"]}</h1>
                        <div class='card-body'>
                            <div id='carouselControls' class='carousel slide mb-3' data-bs-ride='carousel'>
                                <div class='carousel-inner'>
                                    
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
                            <p><strong><i class='fa-solid fa-location-dot'></i>{$event["city"]}</strong></p>
                        </div>
                    </div>
                </div>
                ";
            }
        ?>

        <!-- Bootstrap y Font Awesome -->
        <?php require_once("templates/cdns.php"); ?>
    </body>
</html>