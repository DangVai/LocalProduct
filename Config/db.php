<?php
class db
{
protected $connect;

public function __construct()
{
$host = 'localhost';
$dbname = 'localProducts';
$username = 'root';
$password = '';

$this->connect = new mysqli($host, $username, $password, $dbname);

if ($this->connect->connect_error) {
die("Connection failed: " . $this->connect->connect_error);
}
}

public function getConnection()
{
return $this->connect;
}
}