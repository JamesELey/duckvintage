<?php
// Simple PHP file to test if XAMPP is working
echo "<!DOCTYPE html>";
echo "<html>";
echo "<head>";
echo "<title>Duck Vintage - Test Page</title>";
echo "<style>";
echo "body { background-color: #000; color: #FFD700; font-family: Arial, sans-serif; text-align: center; padding: 50px; }";
echo "h1 { font-size: 3rem; margin-bottom: 2rem; }";
echo "p { font-size: 1.2rem; margin-bottom: 1rem; }";
echo ".btn { display: inline-block; padding: 1rem 2rem; background-color: #FFD700; color: #000; text-decoration: none; border-radius: 4px; font-weight: bold; margin: 1rem; }";
echo ".btn:hover { background-color: #FFF; }";
echo "</style>";
echo "</head>";
echo "<body>";
echo "<h1>🦆 Duck Vintage</h1>";
echo "<p>Welcome to Duck Vintage Clothing Store!</p>";
echo "<p>Your Laravel application is being set up...</p>";
echo "<p>PHP Version: " . phpversion() . "</p>";
echo "<p>Server: " . $_SERVER['SERVER_SOFTWARE'] . "</p>";
echo "<p>Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "</p>";
echo "<a href='#' class='btn'>Coming Soon</a>";
echo "</body>";
echo "</html>";
?>


