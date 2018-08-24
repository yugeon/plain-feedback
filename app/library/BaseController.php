<?php

namespace App\library;


class BaseController
{
    /** @var HttpRequest */
    protected $request;

    public function setRequest($request)
    {
        $this->request = $request;
    }

    public function view($viewFile, $data = []) {
        extract($data);
        ob_start();
        include dirname(__FILE__) . '/../views/' . $viewFile . '.phtml';
        return ob_get_clean();
    }
}