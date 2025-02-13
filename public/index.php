<?php
require_once "../db.php";
session_start();
require_once "../Router.php";
require_once "../lib.php";
require_once "../controller/page.php";
Router::handleRequest();