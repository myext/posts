<?php

namespace Src\Db;


class User extends Model

{
    protected $fields = ["fullname", "birthdate", "email"];
    protected $table = "users";

}