<?php

namespace Src\App\Actions;

use Src\App\Request;
use Src\App\Response;


class ValidatorAction implements Middleware
{
    protected $required = ['fullname', 'message', 'birthdate'];
    protected $purifie = ["message"];
    protected $date = ["birthdate"];
    protected $email = ["email"];
    protected $fullname = ["fullname"];
    protected $max = [
        "message"=> 100,
        "fullname" => 30
    ];

    protected $rules = [
        "purifie" => "/[^a-zA-Z0-9ŽžŪūŲųŠšĖėĘęČčĄą@.\?\*,]+/",
        "date" => "/^[12]{1}\d{3}([-\/])\d{1,2}\g{1}\d{1,2}$/m",
        "email" => "/^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/",
        "fullname" => "/^[a-zA-ZŽžŪūŲųŠšĖėĘęČčĄą]{2,15}\s{1}[a-zA-ZŽžŪūŲųŠšĖėĘęČčĄą]{2,15}$/",
    ];

    protected $response;


    protected function purifie( Request $request )
    {
        $input = $request->get('input');

        foreach ($this->purifie as $field){

            if(isset($input[$field])){

                $clean = preg_replace( $this->rules["purifie"], "", $input[$field]);

                $request->set("input.".$field, $clean);
            }
        }
    }

    protected function date( Request $request )
    {
        $input = $request->get('input');

        foreach ($this->date as $field){

            if(isset($input[$field])){

                if(!preg_match( $this->rules["date"],$input[$field], $matches)){

                    $this->response->addError( $field, "format");

                    return;
                }
                $d_array = explode( $matches[1], $input[$field]);

                if($d_array[1] > 12 or $d_array[2] > 31){
                    $this->response->addError( $field, "format");
                    return;
                }
                $d = new \DateTime($input[$field]);

                if ( $d >= new \DateTime()) {
                    $this->response->addError( $field, "format");
                    return;
                }

                $request->set("input.birthdate", $d->format('Y-m-d'));
            }
        }
    }

    protected function email( Request $request )
    {
        $input = $request->get('input');

        foreach ($this->email as $field){

            if(isset($input[$field])){

                if(!preg_match( $this->rules["email"],$input[$field], $matches)){

                    $this->response->addError( $field, "format");

                    return;
                }
            }
        }
    }

    protected function fullname( Request $request )
    {
        $input = $request->get('input');

        foreach ($this->fullname as $field){

            if(isset($input[$field])){

                if(!preg_match( $this->rules["fullname"],$input[$field], $matches)){

                    $this->response->addError( $field, "format");

                    return;
                }
            }
        }
    }

    protected function max( Request $request )
    {
        $input = $request->get('input');

        foreach ($this->max as $field => $value){

            if(isset($input[$field])){

                if( mb_strlen ($input[$field]) > $value){

                    $this->response->addError( $field, "length");
                }
            }
        }
    }

    protected function required ( Request $request )
    {
        $input = $request->get('input');

        $input = array_diff($input, ['']); //dell empty

        $need = array_flip( $this->required );

        $fields = array_diff_key($need, $input);

        foreach ($fields as $key => $field){
            $this->response->addError( $key, "required");
        }
    }

    protected function validate( $request )
    {
        $this->purifie( $request );
        $this->required( $request );
        $this->date( $request );
        $this->email( $request );
        $this->fullname( $request );
        $this->max( $request );
    }

    public function handle( Request $request, Middleware $next) :Response
    {
        $response = $next->handle($request);

        $this->response = $response;
        $this->validate( $request );

        $input = $request->get('input');

        $errors = array_merge(array_diff($input, ['']), array_flip( $this->required ));

        $_SESSION['field_errors'] = array_intersect_key($response->getErrors(), $errors);
        $_SESSION['old'] = $input;
        $response->setErrors($_SESSION['field_errors']);
        $response->setOld(array_diff_key($input, ["CSRF" =>'', "csrfToken" => '']));

        return $response;
    }

}