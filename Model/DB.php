<?php
require "vendor/autoload.php";
use Illuminate\Database\Capsule\Manager as Capsule;

class DB
{
    private $capsule;
    public function __construct()
    {
        $this->capsule = new Capsule();
    }
    public function connect()
    {
        try {
            $this->capsule->addConnection([
                "driver" => __DRIVER_DB__,
                "host" => __HOST_DB__,
                "database" => __NAME_DB__,
                "username" => __USERNAME_DB__,
                "password" => __PASS_DB__,
            ]);

            $this->capsule->setAsGlobal();
            $this->capsule->bootEloquent();
            return true;
        } catch (\Exception $e) {
            error_log('Database connection error: ' . $e->getMessage());
            return false;
        }
    }
}
