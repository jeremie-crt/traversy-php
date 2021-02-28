<?php

/**
 * Class Pages
 */
class Pages extends Controller
{
    private $postModel;

    public function __construct()
    {
    }

    public function index()
    {
        if(isLoggedIn()) {
            redirect('posts');
        }

        $data = [
            'title' => 'Welcome on ' . SITENAME,
            'description' => 'Simple social network build on TraversyMedia Framework',
        ];

        $this->view('pages/index', $data);
    }

    public function about()
    {
        $data = [
            'title' => 'About page',
            'description' => 'App to share posts with other users',
        ];

        $this->view('pages/about', $data);
    }
}

