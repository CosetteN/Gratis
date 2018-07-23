<?php

namespace Cars;


class Login
{
    protected $database;

    public function __construct($database){
        $this->database = $database;
    }

    public function confirmUser(string $user_name, string $password){
        $query = 'SELECT user_id FROM login_data WHERE user_name = ? AND password = ?';
error_log('In confirmUser');
        if (!$stmt = $this->database->prepare($query)) {
            throw new \mysqli_sql_exception(
                __CLASS__ . '::' . __FUNCTION__ . "({$this->database->errno}): {$this->database->error}",
                $this->database->errno
            );
        }

        $stmt->bind_param("ss", $user_name, $password);
        $stmt->execute();

        $results = $stmt->get_result();

        //close prepared statement
        $stmt->close();

        if ($results->num_rows === 0) {
          return false;
        }

        $row = $results->fetch_assoc();

        //free up memory
        $results->free();

        // Get the Lifetime average return and place it in the player array
        $user = $row['user_id'];

        return $user;
    }
}
