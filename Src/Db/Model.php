<?php

namespace Src\Db;

use \PDO;


class Model
{
    protected $table = "";
    protected $pdo;
    protected $perPage;
    protected $fields = [];
    protected $belong;
    protected $paginator;
    protected $data = [];

    public function __construct ( $perPage = 10 )
    {
        $this->pdo = DB::getPDO();
        $this->perPage = (int) $perPage;
        $this->paginator = new Paginator();
    }

    public function count()
    {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM {$this->table}");

        return $stmt->fetch(PDO::FETCH_COLUMN);
    }

    public function paginateWithBelong( $page = 1 )
    {
        $count = $this->count();

        $start = ((int) $page  - 1 ) * $this->perPage;

        $num = $count / $this->perPage;

        $last = $num > (int) $num ? (int) $num + 1 : (int) $num;

        if( $page > $last ) return null;

        $this->paginator->current = $page;
        $this->paginator->last = $last;

        $query = "SELECT * FROM 
        {$this->table} m LEFT JOIN {$this->belong}s u ON m.{$this->belong}_id = u.id 
        ORDER BY m.id DESC LIMIT {$start} , {$this->perPage}";

        $stmt = $this->pdo->query($query);

        return [ "data" => $stmt->fetchall(), "paginator" =>$this->paginator];
    }

    public function save( $input )
    {
        $input = array_merge($input, $this->data);

        $fillable = array_flip( $this->fields );

        $to_insert = array_intersect_key( $input , $fillable );
        $to_insert = array_diff($to_insert, ['']);

        if(!empty($to_insert)){

            $names =  trim(implode( ', ' , array_keys($to_insert)));
            $placeholders = ":".trim(implode( ', :' , array_keys($to_insert)));

            $query = "INSERT INTO {$this->table} ({$names}) VALUES($placeholders)";

            $this->pdo->beginTransaction();

            $stm = $this->pdo->prepare($query);
            $stm->execute($to_insert);

            $query  = $this->pdo->query("SELECT LAST_INSERT_ID()");
            $id = $query->fetchColumn();

            $this->pdo->commit();

            return $id;
        }
        return null;
    }

    public function __set ( string $name , $value )
    {
        if (in_array($name, $this->fields)) {
            $this->data[$name] = $value;
        }
    }


}