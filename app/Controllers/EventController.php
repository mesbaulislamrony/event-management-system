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

    public function index()
    {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = 5;
        $offset = ($page - 1) * $perPage;
        
        $events = $this->eventModel->paginate($offset, $perPage);
        $total = $this->eventModel->count();
        $totalPages = ceil($total / $perPage);
        
        return [
            'events' => array_map(function ($event) {
                $event['datetime'] = Carbon::parse($event['date'])->toFormattedDateString() . " " . Carbon::parse($event['start_time'])->format('h:i A') . " - ". Carbon::parse($event['end_time'])->format('h:i A');
                $event['available'] = ($event['capacity'] - $event['total']);
                return $event;
            }, $events),
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'perPage' => $perPage,
            'total' => $total
        ];
    }

    public function create($array)
    {
        return $this->eventModel->store($array);
    }

    public function edit($id)
    {
        return $this->eventModel->find($id);
    }

    public function delete($id)
    {
        return $this->eventModel->destroy($id);
    }

    public function show($id)
    {
        $event = $this->eventModel->find($id);
        if(empty($event))
        {
            return [];
        }
        $event['datetime'] = Carbon::parse($event['date'])->toFormattedDateString() . " " . Carbon::parse($event['start_time'])->format('h:i A') . " - ". Carbon::parse($event['end_time'])->format('h:i A');
        $event['available'] = ($event['capacity'] - $event['total']);
        return $event;
    }

    public function update($id, $array)
    {
        $this->eventModel->update($id, $array);
        header("Location: /events/edit.php?id=" . $id);
    }

    public function download($id)
    {
        $result = $this->eventModel->findByEventId($id);
        if (!empty($result)) {
            $filename = "attendees_" . date('Y-m-d_H-i-s') . ".csv";
            header('Content-Type: application/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            
            $output = fopen('php://output', 'w');
            fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($output, ['Name', 'Mobile No', 'No Of Person']);
            
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
