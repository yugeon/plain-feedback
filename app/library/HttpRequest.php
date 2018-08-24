<?php
 namespace App\Library;

 class HttpRequest {
     public $uri = '/';
     public $query = '';
     public $post = [];

     public function __construct()
     {
         $this->parseRequest();
     }

     public function parseRequest()
     {
         $this->uri=strtok($_SERVER["REQUEST_URI"],'?');
         $this->query = $_SERVER['QUERY_STRING'];
         $this->post = $_POST;
     }

     public function isGet() {
         return $_SERVER['REQUEST_METHOD'] === 'GET';
     }
     public function isPost() {
         return $_SERVER['REQUEST_METHOD'] === 'POST';
     }
 }