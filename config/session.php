<?php
    if (session_status() == PHP_SESSION_NONE) {
        ini_set("session.cookie_httponly", true);
        ini_set("session.use_only_cookies", true);
        if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {
            ini_set("session.cookie_secure", true);
        }

        session_start();
    }
?>