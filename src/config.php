<?php

class Config {

    private $dbSettings;
    private $errorSettings;

    public function __construct(){
        $this->dbSettings = [
            'dbname' => $_ENV['DB_NAME'],
            'user' =>$_ENV['DB_USER'],
            'password' => $_ENV['DB_PASSWORD'],
            'host' => $_ENV['DB_HOST'],
            'driver' => $_ENV['DB_DRIVER']
        ];
    }
    public function getDbConfig(){
        return $this->dbSettings;
    }
}