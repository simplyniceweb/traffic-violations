<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ReportAccepted extends Notification
{
    use Queueable;

    protected $report;

    public function __construct($report)
    {
        $this->report = $report;
    }

    public function via($notifiable)
    {
        return ['database']; // stored in DB
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'Your report has been accepted by ' . $this->report->officer->name,
            'report_id' => $this->report->id,
        ];
    }
}
