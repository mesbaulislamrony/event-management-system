<?php

namespace App\Controllers;

use App\Models\Event;
use Carbon\Carbon;

class EventController
{
    private $eventModel;

    public function __construct($db)
    {
        $this->eventModel = new Event($db);
    }

    public function create($array)
    {
        $this->eventModel->create($array);
        header("Location: /events/create.php");
    }

    public function list()
    {
        return $this->eventModel->getAll();
    }

    public function delete($id)
    {
        $this->eventModel->delete($id);
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
        return $event;
    }
}
