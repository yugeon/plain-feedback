<?php

namespace App\Library;

class Router
{
    /** @var HttpRequest*/
    protected $request;
    protected $gets;
    protected $posts;
    protected $namespace = 'App\\Controllers\\';

    public function __construct($request = null)
    {
        if (!is_null($request)) {
            $this->request = $request;
        }
    }

    public function get($url, $controllerRoute)
    {
        $this->registerGet($url, $controllerRoute);
    }

    public function post($url, $controllerRoute)
    {
        $this->registerPost($url, $controllerRoute);
    }

    protected function registerGet($url, $controllerRoute)
    {
        $url = '/' . ltrim($url, '/');
        $this->gets[$url] = $controllerRoute;
    }

    protected function registerPost($url, $controllerRoute)
    {
        $url = '/' . ltrim($url, '/');
        $this->posts[$url] = $controllerRoute;
    }

    /**
     * @return HttpResponse
     * @throws NotFoundException
     */
    public function processRequest()
    {
        $response = new HttpResponse();

        if ($this->request->isGet()) {
            if (isset($this->gets[$this->request->uri])) {
                return $this->extractControllerAction($response, $this->gets[$this->request->uri]);
            } else {
                throw new NotFoundException();
            }
        }


        if ($this->request->isPost()) {
            if (isset($this->posts[$this->request->uri])) {
                return $this->extractControllerAction($response, $this->posts[$this->request->uri]);
            } else {
                throw new NotFoundException();
            }
        }

        throw new NotFoundException();
    }

    protected function extractControllerAction(HttpResponse $response, $controllerRoute)
    {
            list($controllerName, $controllerAction) = explode('@', $this->namespace . $controllerRoute);

            /** @var BaseController $controller */
            $controller = new $controllerName();
            $controller->setRequest($this->request);
            $view = $controller->$controllerAction();

            $response->setBody($view);
            return $response;
    }
}