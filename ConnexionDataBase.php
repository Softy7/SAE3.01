<?php

function __init__() {
    return new PDO("pgsql:host=localhost;dbname=postgres",'postgres','v1c70I83');
}

