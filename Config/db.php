<!-- this is basically just for the migration.php and if any errors surrounding login arises -->
<!-- UPDATE: decided to use this to connect all of the databases -->
<?php

class database
{
    private $host = "localhost";
    private $user = "root";
    private $pass = "";

    public $users_conn;
    public $ticket_conn;
    public $inventory_conn;
    public $logs_conn;

    public function connect()
    {
        try {
            // USERS DB
            $this->users_conn = new PDO(
                "mysql:host=$this->host;dbname=chams_users",
                $this->user,
                $this->pass
            );

            // TICKETING DB
            $this->ticket_conn = new PDO(
                "mysql:host=$this->host;dbname=chams_ticketing",
                $this->user,
                $this->pass
            );

            // INVENTORY DB
            $this->inventory_conn = new PDO(
                "mysql:host=$this->host;dbname=chams_inventory",
                $this->user,
                $this->pass
            );

            // LOGS DB
            $this->logs_conn = new PDO(
                "mysql:host=$this->host;dbname=chams_logs",
                $this->user,
                $this->pass
            );

            // SET ERRORS
            $this->users_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->ticket_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->inventory_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->logs_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }
}