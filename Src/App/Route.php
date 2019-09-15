<?php

namespace Src\App;

use \SplQueue;
use \Src\App\Actions\Middleware;


class Route implements Middleware
{
    protected $queue;
    protected $request;

    public function __construct( Request $request, $actions = [] )
    {
        $this->queue = new SplQueue();
        $this->request = $request;

        if(!empty($actions)) $this->addActions($actions);
    }

    public function addAction( $action )
    {
        $this->queue->enqueue($action);
    }

    public function addActions( $actions = [] )
    {
        foreach ($actions as $action){
            $this->queue->enqueue($action);
        }
    }

    protected function isEmpty()
    {
        return $this->queue->isEmpty();
    }

    protected function getAction()
    {
        $func = $this->queue->dequeue();

        return $func();
    }

    public function run()
    {
        $current = $this->getAction();

        return $current->handle($this->request, $this);
    }

    public function handle( Request $request, Middleware $next = null ) : Response
    {
        if(!$this->isEmpty()){

            $func = $this->getAction();
            return $func->handle($request, $this);
        }
        return null;
    }
}