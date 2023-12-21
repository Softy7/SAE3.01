<?php

function __init__() {
    return new PDO('pgsql:host=[host];dbname=[dbname]','[username]','[password]');
}

