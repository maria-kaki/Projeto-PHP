<?php

// Class definition
class Database {
    // Function to get a database connection
    public static function getConnection() {
        // Get the path to the environment configuration file (env.ini)
        $envPath = realpath(dirname(__FILE__) . '/../env.ini');

        // Parse the environment configuration file into an associative array
        $env = parse_ini_file($envPath);

        // Create a new MySQLi (MySQL Improved) database connection using the parsed environment settings
        $conn = new mysqli($env['host'], $env['username'], $env['password'], $env['database']);

        // Check if there was an error while connecting to the database
        if($conn->connect_error) {
            die("Erro: " . $conn->connect_error); // Terminate the script and display an error message
        }

        // Return the established database connection
        return $conn;
    }

    // Function to execute a database query and return the result
    public static function getResultFromQuery($sql) {
        // Get a database connection
        $conn = self::getConnection();

        // Execute the SQL query and store the result
        $result = $conn->query($sql);

        // Close the database connection
        $conn->close();

        // Return the query result
        return $result;
    }

    // Function to execute an SQL query and return the ID of the last inserted record
    public static function executeSQL($sql) {
        // Get a database connection
        $conn = self::getConnection();
        // Execute the SQL query and check for errors
        if(!mysqli_query($conn, $sql)) {
            // If there is an error, throw an exception with the error message
            throw new Exception(mysqli_error($conn));
        }
        // Get the ID of the last inserted record
        $id = $conn->insert_id;
        // Close the database connection
        $conn->close();
        // Return the ID of the last inserted record
        return $id;
    }
}