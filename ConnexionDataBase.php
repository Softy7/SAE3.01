<?php

function __init__() {
    return new PDO("[DSN]", '[username]', '[password]');
}

/* Permettra à tout le monde de travailler de leur côté avec différentes bases de données.*/