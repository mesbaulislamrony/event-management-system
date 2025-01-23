<?php

namespace App\Controllers;

use App\Models\Event;
use App\Models\Attendee;
use Carbon\Carbon;

class EventController
{
    private $eventModel;
    private $attendeeModel;

    public function __construct($db)
    {
        $this->eventModel = new Event($db);
        $this->attendeeModel = new Attendee($db);
    }

    public function create($array)
    {
        $this->eventModel->create($array);
        header("Location: /events/create.php");
    }

    public function index()
    {
        $events = $this->eventModel->index();
        return array_map(function ($event) {
            $event['datetime'] = Carbon::parse($event['datetime'])->toDayDateTimeString();
            $event['available'] = ($event['capacity'] - $event['total']);
            return $event;
        }, $events);
    }

    public function delete($id)
    {
        $this->eventModel->destroy($id);
        header("Location: /events/index.php");
    }

    public function update($id, $array)
    {
        $this->eventModel->update($id, $array);
        header("Location: /events/edit.php?id=" . $id);
    }

    public function edit($id)
    {
        return $this->eventModel->find($id);
    }

    public function show($id)
    {
        $event = $this->eventModel->find($id);
        $event['datetime'] = Carbon::parse($event['datetime'])->toDayDateTimeString();
        $event['available'] = ($event['capacity'] - $event['total']);
        return $event;
    }
}
