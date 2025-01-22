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
        if (!empty($_SESSION)) {
            $array = $array + $_SESSION['user'];
        }

        $attendee = $this->userModel->findByMobileNo($array['mobile_no']);
        if (empty($attendee)) {
            $this->userModel->register($array);
            $_SESSION['user'] = $attendee;
        }
        $attendee = $this->userModel->findByMobileNo($array['mobile_no']);

        $this->attendeeModel->join($id, $attendee['id'], $array);
        header("Location: /join.php?id=" . $id);
    }

    public function tickets($id)
    {
        return $this->attendeeModel->noOftickets($id);
    }
}
