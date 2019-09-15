<?php

namespace Src\App;


class Render
{
    protected $response;

    public function __construct( Response $response )
    {
        $this->response = $response;

    }

    public function flush()
    {
        ob_start();

        foreach ($this->response->getHeaders() as $header){
            header($header);
        }

        echo $this->response->getBody();

        ob_end_flush();
    }
}