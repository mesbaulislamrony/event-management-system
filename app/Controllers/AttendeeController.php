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

    public function download($id)
    {
        $result = $this->attendeeModel->csv($id);
        if (!empty($result)) {
            $filename = 'attendee.csv';
            header('Content-Type: application/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename="' . $filename . '";');
            $f = fopen($filename, "w");
            fputcsv($f, ['Name', 'Mobile No', 'No Of Person']);
            foreach ($result as $row) {
                fputcsv($f, $row);
            }
            fclose($f);
        }
        header("Location: /events/show.php?id=" . $id);
    }
}
