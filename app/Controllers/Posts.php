<?php


class Posts extends Controller
{
    private $postModel;

    private $userModel;

    public function __construct()
    {
        if(!isLoggedIn()) {
            redirect('users/login');
        }

        $this->postModel = $this->model('Post');
        $this->userModel = $this->model('User');
    }

    public function index()
    {
        $posts = $this->postModel->getPosts();

        $data = [
            'posts' => $posts,
        ];

        $this->view('posts/index', $data);
    }


    public function add()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            //Sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'title' => trim($_POST['title']),
                'body' => trim($_POST['body']),
                'user_id' => $_SESSION['user_id'],
                'title_err' => '',
                'body_err' => '',
            ];

            //Validate data
            if(empty($data['title'])) {
                $data['title_err'] = 'Please enter a title to the new post';
            }
            if(empty($data['body'])) {
                $data['body_err'] = 'Please add a body text to the new post';
            }

            if(empty($data['title_err']) && empty($data['body_err'])) {
                //Validated
                if($this->postModel->addPost($data)) {
                    flash('post_message', 'Post added');
                    redirect('posts');
                } else {
                    flash('post_add_error', 'Posting request has failed. Please try again.', 'alert alert-danger');

                    $this->view('posts/add', $data);
                }

            } else {
                $this->view('posts/add', $data);
            }

        } else {

            $data = [
                'title' => '',
                'body' => '',
            ];

            $this->view('posts/add', $data);
        }
    }


    public function edit($id)
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            //Sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'id' => $id,
                'title' => trim($_POST['title']),
                'body' => trim($_POST['body']),
                'user_id' => $_SESSION['user_id'],
                'title_err' => '',
                'body_err' => '',
            ];

            //Validate data
            if(empty($data['title'])) {
                $data['title_err'] = 'Please enter a title to the new post';
            }
            if(empty($data['body'])) {
                $data['body_err'] = 'Please add a body text to the new post';
            }

            if(empty($data['title_err']) && empty($data['body_err'])) {
                //Validated
                if($this->postModel->updatePost($data)) {
                    flash('post_message', 'Post updated');
                    redirect('posts');
                } else {
                    flash('post_add_error', 'Update request has failed. Please try again.', 'alert alert-danger');
                    $this->view('posts/edit/'. $id, $data);
                }

            } else {
                $this->view('posts/edit/'. $id, $data);
            }

        } else {
            //Get existing post from model
            $post = $this->postModel->getPostById($id);

            //Check for owner
            if($post->user_id != $_SESSION['user_id']) {
                redirect('posts');
            }

            $data = [
                'id' => $id,
                'title' => $post->title,
                'body' => $post->body,
            ];

            $this->view('posts/edit', $data);
        }
    }


    public function show($id)
    {
        $post = $this->postModel->getPostById($id);
        $user = $this->userModel->getUserById($post->user_id);

        $data = [
            'post' => $post,
            'user' => $user
        ];

        $this->view('posts/show', $data);

    }

    public function delete($id)
    {
        $post = $this->postModel->getPostById($id);

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
//Get existing post from model
            $post = $this->postModel->getPostById($id);

            //Check for owner
            if($post->user_id != $_SESSION['user_id']) {
                redirect('posts');
            }

            if($this->postModel->deletePost($id)) {
                flash('post_message', 'Delete request completed.');
                redirect('posts');

            } else {
                flash('post_delete_error', 'Delete request has failed. Please try again.', 'alert alert-danger');
                redirect('posts/show/' . $id);
            }

        } else {
            redirect('posts');
        }
    }

}