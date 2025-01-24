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
        $attendee = $this->attendeeModel->findByMobileNo($array['mobile_no']);

        if (!empty($attendee)) {
            $_SESSION['error'] = "Mobile number already exists. Please use a different mobile number.";
            header("Location: /join.php?id=" . $id);
            exit();
        }

        $this->attendeeModel->register($array);
        $attendee = $this->attendeeModel->findByMobileNo($array['mobile_no']);
        $this->attendeeModel->join($id, $attendee, $array);
        header("Location: /join.php?id=" . $id);
    }

    public function download($id)
    {
        $result = $this->attendeeModel->findByEventId($id);
        if (!empty($result)) {
            $filename = "attendees_" . date('Y-m-d_H-i-s') . ".csv";
            header('Content-Type: application/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            
            // Open output stream
            $output = fopen('php://output', 'w');
            
            // Add UTF-8 BOM for proper Excel encoding
            fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Add headers
            fputcsv($output, ['Name', 'Mobile No', 'No Of Person']);
            
            // Add data rows
            foreach ($result as $row) {
                fputcsv($output, [
                    $row['name'],
                    $row['mobile_no'],
                    $row['no_of_person']
                ]);
            }
            
            fclose($output);
            exit();
        }
        
        header("Location: /events/show.php?id=" . $id);
        exit();
    }
}
