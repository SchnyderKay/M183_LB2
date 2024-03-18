<?php

    function executeStatement($statement){
        $conn = getConnection();
        $stmt = $conn->prepare($statement);
        $stmt->execute();
        $stmt->store_result();
        return $stmt;
    }

    function getConnection()
    {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        // Check connection
        if ($conn->connect_error) {
            // Stop outputting errors
            if (DEBUG) {
                exit("Connection failed: " . $conn->connect_error);
            } else {
                exit("Something went wrong");
            }
        }

        return $conn;
    }
