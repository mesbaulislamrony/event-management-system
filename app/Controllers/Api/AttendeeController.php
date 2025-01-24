<?php

namespace App\Controllers\Api;

use App\Models\Attendee;
use App\Models\Event;

class AttendeeController
{
    private $attendeeModel;
    private $eventModel;

    public function __construct($db)
    {
        $this->attendeeModel = new Attendee($db);
        $this->eventModel = new Event($db);
    }

    public function join($data)
    {
        $required_fields = ['name', 'mobile_no', 'no_of_person', 'event_id'];
        foreach ($required_fields as $field) {
            if (!isset($data[$field]) || empty(trim($data[$field]))) {
                http_response_code(400);
                echo json_encode(['error' => ucfirst(str_replace('_', ' ', $field)) . ' is required']);
                return;
            }
        }

        if (strlen($data['mobile_no']) < 11) {
            http_response_code(400);
            echo json_encode(['error' => 'Mobile number must be at least 11 characters']);
            return;
        }

        $no_of_person = (int)$data['no_of_person'];
        if ($no_of_person <= 0) {
            http_response_code(400);
            echo json_encode(['error' => 'Number of persons must be greater than 0']);
            return;
        }

        $event = $this->attendeeModel->findByEventId($data['event_id']);
        if (!$event) {
            http_response_code(404);
            echo json_encode(['error' => 'Event not found']);
            return;
        }

        $available = $event['capacity'] - $event['total'];
        if ($no_of_person > $available) {
            http_response_code(400);
            echo json_encode(['error' => 'Not enough seats available. Only ' . $available . ' seats left']);
            return;
        }

        if ($this->attendeeModel->findByMobileNo($data['mobile_no'])) {
            http_response_code(400);
            echo json_encode(['error' => 'You have already registered for this event']);
            return;
        }

        try {
            $this->attendeeModel->register([
                'name' => $data['name'],
                'mobile_no' => $data['mobile_no']
            ]);

            $attendee_id = $this->attendeeModel->findByMobileNo($data['mobile_no'])['id'];
            $this->attendeeModel->join([
                'attendee_id' => $attendee_id,
                'event_id' => $data['event_id'],
                'no_of_person' => $no_of_person
            ]);

            echo json_encode([
                'success' => true,
                'message' => 'Successfully joined the event',
                'data' => [
                    'name' => $data['name'],
                    'mobile_no' => $data['mobile_no'],
                    'no_of_person' => $no_of_person
                ]
            ]);
        } catch (\Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
            http_response_code(500);
            echo json_encode(['error' => 'Failed to join event. Please try again.']);
        }
    }
}
