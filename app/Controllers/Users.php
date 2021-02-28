<?php

class Users extends Controller
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = $this->model('User');
    }

    /**
     *
     */
    public function register()
    {
        //Check for post
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            //Process form

            //Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            /*$args = array(
                'product_id'   => FILTER_SANITIZE_ENCODED,
                'component'    => array('filter'    => FILTER_VALIDATE_INT,
                    'flags'     => FILTER_REQUIRE_ARRAY,
                    'options'   => array('min_range' => 1, 'max_range' => 10)
                ),
                'version'      => FILTER_SANITIZE_ENCODED,
                'doesnotexist' => FILTER_VALIDATE_INT,
                'testscalar'   => array(
                    'filter' => FILTER_VALIDATE_INT,
                    'flags'  => FILTER_REQUIRE_SCALAR,
                ),
                'testarray'    => array(
                    'filter' => FILTER_VALIDATE_INT,
                    'flags'  => FILTER_REQUIRE_ARRAY,
                )

            );*/

            //Init Data
            $data = [
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => '',
            ];


            //Validate name
            if(empty($data['name'])) {
                $data['name_err'] = 'Please enter a name';
            }

            //Validate email
            if(empty($data['email'])) {
                $data['email_err'] = 'Please enter a email';
            } else {
                //Check email
                if($this->userModel->findUserByEmail($data['email'])) {
                    $data['email_err'] = 'Email is already taken';
                }
            }

            //Validate password
            if(empty($data['password'])) {
                $data['password_err'] = 'Please enter a password';
            } else if(strlen($data['password']) < 6) {
                $data['password_err'] = 'Please enter a password with at least 6 characters';
            }

            //Validate password
            if(empty($data['confirm_password'])) {
                $data['confirm_password_err'] = 'Please enter a confirm_password';
            } else {
                if($data['confirm_password'] != $data['password']) {
                    $data['confirm_password_err'] = 'Passwords must match';
                }
            }

            //Make sure errors are empty
            if(empty($data['name_err']) && empty($data['email_err']) && empty($data['password_err']) &&  empty($data['confirm_password_err'])) {
                //Validated

                //Hash password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                //Register User
                if($this->userModel->register($data)) {
                    flash('register_success', 'You are now registered and can log in.');
                    redirect('users/login');

                } else {
                    die('ERROR FORM');
                }

            } else {
                $this->view('users/register', $data);
            }


            die('fafafa');

        } else {
            //Init data
            $data = [
                'name' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',
                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => '',
            ];

            $this->view('users/register', $data);
        }
    }

    /**
     *
     */
    public function login()
    {
        //Check for post
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            //Process form

            //Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            //Init Data
            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'email_err' => '',
                'password_err' => '',
            ];

            //Validate email
            if(empty($data['email'])) {
                $data['email_err'] = 'Please enter a email';
            }

            //Validate password
            if(empty($data['password'])) {
                $data['password_err'] = 'Please enter a password';
            } else if(strlen($data['password']) < 6) {
                $data['password_err'] = 'Please enter a password with at least 6 characters';
            }

            //Check for user/email
            if($this->userModel->findUserByEmail($data['email'])) {
                //User found
            } else {
                //User not found
                $data['email_err'] = 'No user found';
            }

            //Make sure errors are empty
            if(empty($data['email_err']) && empty($data['password_err'])) {
                //Validated
                //Check and set logged in user
                $loggedInUser = $this->userModel->login($data['email'], $data['password']);


                if($loggedInUser) {
                    //Create Session
                    $this->createUserSession($loggedInUser);

                } else {
                    $data['password_err'] = 'Password incorrect';

                    $this->view('users/login', $data);
                }

            } else {
                $this->view('users/login', $data);
            }

            $this->view('users/login', $data);

        } else {
            //Init Data
            $data = [
                'email' => '',
                'password' => '',
                'email_err' => '',
                'password_err' => '',
            ];

            $this->view('users/login', $data);
        }
    }

    /**
     * @param $user
     */
    public function createUserSession($user)
    {
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['user_name'] = $user->name;

        redirect('posts');
    }

    /**
     *
     */
    public function logout()
    {
        unset($_SESSION['user_id'], $_SESSION['user_email'], $_SESSION['user_name']);
        session_destroy();

        redirect('users/login');
    }



}