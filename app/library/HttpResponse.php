<?php
namespace App\Library;


class HttpResponse
{
    /** @var string */
    protected $body = '';

    public function getBody()
    {
        return $this->body;
    }

    public function setBody($body = '')
    {
        $this->body = $body;
    }
}