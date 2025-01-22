<?php

namespace App\Controllers;

use App\Models\Event;
use Carbon\Carbon;

class HomeController
{
    private $eventModel;

    public function __construct($db)
    {
        $this->eventModel = new Event($db);
    }

    public function list()
    {
        $events = $this->eventModel->getAll();
        return array_map(function ($event) {
            $event['datetime'] = Carbon::parse($event['datetime'])->toDayDateTimeString();
            $event['price'] = ($event['price'] > 0) ? $event['price'] . " Tk" : "Free";
            return $event;
        }, $events);
    }

    public function show($id)
    {
        $event = $this->eventModel->find($id);
        $event['datetime'] = Carbon::parse($event['datetime'])->toDayDateTimeString();
        $event['price'] = ($event['price'] > 0) ? $event['price'] . " Tk" : "Free";
        return $event;
    }
}
