<?php

global $conn;

$conn = mysqli_connect("localhost", "root", "123456789", "alumni_donation");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}