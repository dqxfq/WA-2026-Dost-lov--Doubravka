<?php
//PRVNÍ SOUBOR CO SE SPOUŠTÍ

session_start(); //Session je paměť pro ukládání ifo o uživateli

ini_set('display_errors', 1); //zapnutí zobrazováná php chyb, KDŽ NĚCO NAPÍŠU ŠPATNĚ, UKÁŽE SE TO
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); // ukazuje všechNY chyby, varování i upozornění

//dirname vezme pouze název složky, kde se nachází soubor index.php, a nahradí zpětná lomítka za normální lomítka
//výseledek se uloží do proměnné $baseDir, která se použije pro definování konstanty BASE_URL
$baseDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])); //zjištění základní adresy projektu localhost/Jizerky/Public
define('BASE_URL', $baseDir); //base_url mnou pojmenovaná konstanta, která obsahuje základní adresu projektu

require_once '../CORE/app.php'; //načtení souboru app.php, který obsahuje třídu App

$app = new App(); //spust aplikace (do porměnné na levo ulož proměnnou v pravo) nová aplikace podle tříd app