<?php

function __init__() {
    return new PDO("pgsql:host=localhost;dbname=postgres",'postgres','hugo2004');
}

/* Permettra à tout le monde de travailler de leur côté avec différentes bases de données.*/