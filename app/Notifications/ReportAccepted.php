<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ReportAccepted extends Notification
{
    use Queueable;

    protected $status;
    protected $report;

    public function __construct($report, $status = 'accepted')
    {
        $this->report = $report;
        $this->status = $status;
    }

    public function via($notifiable)
    {
        return ['database']; // stored in DB
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'Your report has been ' . $this->status . ' by ' . $this->report->officer->name,
            'report_id' => $this->report->id,
        ];
    }
}
