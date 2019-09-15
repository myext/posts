<?php

namespace Src\Db;


class Post extends Model
{
    protected $fields = ["user_id", "message"];
    protected $table = "posts";
    protected $belong = "user";

    public function paginateWithBelong( $page = 1 )
    {
        $count = $this->count();

        $start = ((int) $page  - 1 ) * $this->perPage;

        $num = $count / $this->perPage;

        $last = $num > (int) $num ? (int) $num + 1 : (int) $num;

        if( $page > $last ) return null;

        $this->paginator->current = $page;
        $this->paginator->last = $last;

        $query = "SELECT m.message as message , m.created_at date , 
        u.fullname fullname , u.email email FROM 
        {$this->table} m LEFT JOIN {$this->belong}s u ON m.{$this->belong}_id = u.id 
        ORDER BY m.id DESC LIMIT {$start} , {$this->perPage}";

        $stmt = $this->pdo->query($query);

        return [ "data" => $stmt->fetchall(), "paginator" =>$this->paginator];
    }
}