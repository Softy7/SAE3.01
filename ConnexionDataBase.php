<?php

function __init__(): PDO
{
    return new PDO('pgsql:host=localhost;dbname=postgres','postgres','ThomasMathieu1810');
}

