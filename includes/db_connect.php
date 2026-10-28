<?php
// ============================================================
// Database connection — used by every page in this project
// ============================================================

// Reads from environment variables if deployed to cloud (Railway, Render, Docker, etc.)
// Defaults to local XAMPP configuration if environment variables are not set.
$host   = getenv('DB_HOST') ?: "localhost";
$dbuser = getenv('DB_USER') ?: "root";
$dbpass = getenv('DB_PASS') !== false ? getenv('DB_PASS') : "";
$dbname = getenv('DB_NAME') ?: "placement_db";
$port   = getenv('DB_PORT') ? (int)getenv('DB_PORT') : 3306;

$conn = new mysqli($host, $dbuser, $dbpass, $dbname, $port);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error .
        "<br>Check your database host, credentials, and ensure the database is imported.");
}
