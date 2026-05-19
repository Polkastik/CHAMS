<!-- this is basically just for the migration.php and if any errors surrounding login arises -->
<!-- UPDATE: decided to use this to connect all of the databases -->
<?php

class database
{
    private $host = "sql200.infinityfree.com";
    private $user = "if0_41961525";
    private $pass = "HX03Ig4eZx42Z";
    private $dbname = "if0_41961525_chams_central";

    public $users_conn;
    public $ticket_conn;
    public $inventory_conn;
    public $logs_conn;

    public function connect()
    {
        try {            
            $live_connection = new PDO(
                "mysql:host=$this->host;dbname=$this->dbname;charset=utf8mb4",
                $this->user,
                $this->pass
            );

            $live_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $this->users_conn     = $live_connection;
            $this->ticket_conn    = $live_connection;
            $this->inventory_conn = $live_connection;
            $this->logs_conn      = $live_connection;

        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }
}