<?php
session_start();

if (isset($_SESSION['user_id'])) {
    echo "Logged In";
} else {
    echo "Not logged in";
}
