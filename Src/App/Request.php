<?php

namespace Src\App;


class Request
{
    protected $data;

    public function __construct()
    {
        $this->data = $_SERVER;
        $this->data["input"] = array_merge($_REQUEST, $_SESSION);
    }

    public function get( $key = '' )
    {
        $data = $this->data;

        $key = str_replace('.', '"]["',$key);

        eval("\$cnf = \$data[\"$key\"] ?? null;");

        return $cnf;
    }

    public function has( $key )
    {
       return $this->get($key);
    }

    public function set ( $key, $value )
    {
        $key = str_replace('.', '"]["',$key);
        $data = &$this->data;

        eval("\$data[\"$key\"] = \$value;");
    }

    public function isAjax()
    {
        return $this->get("HTTP_X_REQUESTED_WITH") === "XMLHttpRequest";
    }

}