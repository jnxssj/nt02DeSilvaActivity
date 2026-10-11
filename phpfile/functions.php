<?php
    session_start();

    function getPost($name) 
    {
        if (isset($_POST[$name])) {
            return trim($_POST[$name]);
        }
        return '';
    }

    function loadUsers()
    {
        if (!file_exists('data/users.json')) {
            return [];
        }
        $json  = file_get_contents('data/users.json');
        $users = json_decode($json, true);
        if (!is_array($users)) {
            return [];
        }
        return $users;
    }

    function saveUsers($users)
    {
        $json = json_encode($users, JSON_PRETTY_PRINT);
        file_put_contents('data/users.json', $json);
    }

    function findUser($email)
    {
        $users = loadUsers();
        foreach ($users as $user) {
            if ($user['email'] == strtolower($email)) {
                return $user;
            }
        }
        return null;
    }

?>