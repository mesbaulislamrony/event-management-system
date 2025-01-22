<?php

namespace App\Controllers;

use App\Models\Attendee;
use App\Models\Event;
use Carbon\Carbon;

class AttendeeController
{
    private $attendeeModel;
    private $eventModel;

    public function __construct($db)
    {
        $this->attendeeModel = new Attendee($db);
        $this->eventModel = new Event($db);
    }

    public function register($id, $array)
    {
        $attendee = $this->attendeeModel->findByMobileNo($array['mobile_no']);
        if(empty($attendee)){
            $this->attendeeModel->register($array);
        }

        if(!$this->attendeeModel->checkAlreadyExists($event_id, $attendee_id))
        {
            header("Location: /join.php?id=" . $id);
        }

        $attendee = $this->attendeeModel->findByMobileNo($array['mobile_no']);
        $this->attendeeModel->join($id, $attendee['id']);
        header("Location: /join.php?id=" . $id);
    }
}
