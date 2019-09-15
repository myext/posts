<?php

namespace Src\Db;


class Paginator
{
    public $last;
    public $current;
    public $url = "/";

    public function navigate()
    {
        include (DIR.config("views").'navigate.php');
    }

}