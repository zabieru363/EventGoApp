<?php
    session_start();
    
    if(!$user_active)
    {
        if(isset($_COOKIE["remember_me"])) setcookie("remember_me", "", time() - 3600);
    
        unset($_SESSION["id_user"]);
        unset($_SESSION["username"]);
    
        session_destroy();
    }

    $title = "Inicio";
    require_once("templates/open.php");
?>
    <body>
        <!-- Bootstrap y Font Awesome -->
        <?php require_once("templates/cdns.php"); ?>
        
        <?php
            if(isset($_SESSION["id_user"]))
            {
                if($_SESSION["username"] === "admin_eventgo")
                {
                    require_once("templates/admin_header.php");
                    require_once("templates/admin_body.php");
                }
                else
                {
                    require_once("templates/header.php");
                    require_once("templates/eventsZone.php");

                    echo '<script src="public/js/getEventsCategory.js" type="module"></script>';
                    echo '<script src="public/js/searchEvents.js"></script>';
                }
            }
            else
            {
                require_once("templates/header.php");
                require_once("templates/eventsZone.php");

                echo '<script src="public/js/getEventsCategory.js" type="module"></script>';
                echo '<script src="public/js/searchEvents.js"></script>';

                if(!(isset($_COOKIE["cookies-accepted"])))
                {
                    require_once("templates/cookiesComponent.php");
                    echo '<script src="public/js/cookiesControl.js"></script>';
                }
            }
        ?>
    </body>
</html>