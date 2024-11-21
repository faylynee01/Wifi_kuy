<?php

// Load Config...
include_once('config.php');

// Load OOP Class
include_once('action.php');

$pengaturan = $pengaturanClass->pengaturanSekarang();

// Load Routes
include_once('routes.php');
