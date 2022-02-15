<?php

class PDOperso extends PDO
{

    function __construct(
        $host = 'localhost',
        $dbname = 'phppdo',
        $port = 3306,
        $user = 'root',
        $pwd = ''
    ) {
        parent::__construct(
            'mysql:host=' . $host . ':' . $port . ';dbname=' . $dbname . ';charset=UTF8',
            $user,
            $pwd
        );
        $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
}

