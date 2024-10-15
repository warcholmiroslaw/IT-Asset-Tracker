<?php

class Database {
    private $username;
    private $password;
    private $host;
    private $database;
    private $port = 5432;

    private $conn;

    // tables
    public const OWNERSHIP_TABLE = "ownership";
    public const EQUIPMENT_TABLE = "equipment";
    public const USERS_TABLE = "users";


    public function __construct()
    {
        // TODO it should be singleton
         $this->username = "docker";
         $this->password = "docker";
         $this->host = "db";
         $this->database = "db";
        $this->conn = $this->connect();
    }

    public function connect()
    {
        try {
            $conn = new PDO(
                "pgsql:host=$this->host;
                port=$this->port;
                dbname=$this->database", $this->username, $this->password,
                ["sslmode"  => "prefer"]
            );

            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        }
        catch(PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function initDatabaseStructure(){
        try {
            $this->conn->beginTransaction();

            $this->conn->exec("
        CREATE TABLE IF NOT EXISTS public.equipment
        (
            id serial NOT NULL,
            type character varying(100),
            brand character varying(100),
            model character varying(100),
            serial_number character varying(100),
            purchase_date date,
            CONSTRAINT equipment_pkey PRIMARY KEY (id)
        );

        CREATE TABLE IF NOT EXISTS public.users
        (
            id serial NOT NULL,
            name character varying(100) NOT NULL,
            surname character varying(100) NOT NULL,
            account_type account_type_enum NOT NULL,
            job_title character varying(100),
            department character varying(100),
            manager integer,
            email character varying(255) NOT NULL,
            phone_number character varying(15),
            password character varying(255) NOT NULL,
            created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
            CONSTRAINT users_pkey PRIMARY KEY (id),
            CONSTRAINT users_email_key UNIQUE (email)
        );

        CREATE TABLE IF NOT EXISTS public.ownership
        (
            id serial NOT NULL,
            equipment_id integer,
            user_id integer,
            assigned_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
            returned_at timestamp without time zone,
            status character varying(50) NOT NULL,
            CONSTRAINT ownership_pkey PRIMARY KEY (id)
        );");

            $this->conn->commit();
        } catch (Exception $e) {
            $this->conn->rollBack();
            throw $e;
        }

    }


}