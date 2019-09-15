<?php

namespace Src\App;


class Response
{
    protected $status = 200;
    protected $headers = [];
    protected $body = '';
    protected $errors = [];
    protected $old = [];
    protected $data = [];

    public function setStatus( $status = 200 )
    {
        $this->status = $status;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setHeader( $value = [] )
    {
        $this->headers = $value;
    }

    public function addHeader( $value  )
    {
        $this->headers[] = $value;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function setBody( $str = '' )
    {
        $this->body = $str;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function setErrors( Array $errors )
    {
        $this->errors = $errors;
    }

    public function addError( $key, $value )
    {
        $this->errors[$key][] = $value;
    }

    public function setOld(Array $data = [] )
    {
        $this->old = $data;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function addOld( $key, $value )
    {
        $this->old[$key] = $value;
    }

    public function getOlds()
    {
        return $this->old;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function addData($key, $data)
    {
        $this->data[$key] = $data;
    }

    public function getError( $key = '' )
    {
        $data = $this->errors;

        $key = str_replace('.', '"]["',$key);

        eval("\$cnf = \$data[\"$key\"] ?? null;");

        return $cnf;
    }

    public function hasError ( $key )
    {
        if( $this->getError($key)) return true;
        return false;
    }

    public function getAll()
    {
        return [
           "errors" => $this->errors,
           "old" => $this->old,
           "data" => $this->data
        ];
    }

}