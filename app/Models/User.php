<?php

class User
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    //Register User
    public function register($data)
    {
        $this->db->query('INSERT INTO users (name, email, password) VALUES(:name, :email, :password)');

        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']);

        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }


    public function login($email, $pwd)
    {
        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind(':email', $email);

        $row = $this->db->single();

        $hashed_pwd = $row->password;
        if(password_verify($pwd, $hashed_pwd)) {
            return $row;
        } else {
            return false;
        }
    }


    /**
     * Find user by email
     */
    public function FindUserByEmail($email)
    {
        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind(':email', $email);

        $row = $this->db->single();

        if($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getUserById($id)
    {
        $this->db->query('SELECT * FROM users WHERE id = :id');
        $this->db->bind(':id', $id);

        return $this->db->single();
    }
}