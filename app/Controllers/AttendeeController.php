<?php

namespace App\Controllers;

use App\Models\Attendee;
use App\Models\User;

class AttendeeController
{
    private $attendeeModel;
    private $userModel;

    public function __construct($db)
    {
        $this->attendeeModel = new Attendee($db);
        $this->userModel = new User($db);
    }

    public function register($id, $array)
    {
        $this->attendeeModel->register($array);
        $attendee = $this->attendeeModel->findByMobileNo($array['mobile_no']);
        $this->attendeeModel->join($id, $attendee, $array);
        header("Location: /join.php?id=" . $id);
    }
}
