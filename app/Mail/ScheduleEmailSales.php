<?php

namespace App\Mail;

use App\Models\Attachment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ScheduleEmailSales extends Mailable
{
    use Queueable, SerializesModels;
    public $subject;
    public $body;
    public $attachment_id;
    public $is_html;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject, $body, $attachment_id, $is_html)
    {
        $this->subject          = $subject;
        $this->body             = $body;
        $this->attachment_id    = $attachment_id;
        $this->is_html          = $is_html;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $attachment = Attachment::where('id', $this->attachment_id)->first();
        if ($this->is_html) {
            $view = $this->from('rezihandianto98@gmail.com', 'IDEA Konsultan')
                ->subject($this->subject)
                ->view('emails.schedule_html');
        } else {
            $view = $this->from('rezihandianto98@gmail.com', 'IDEA Konsultan')
                ->subject($this->subject)
                ->view('emails.schedule');
        }
        if ($this->attachment_id) {
            $view = $view->attach(public_path('storage/' . $attachment->path . '/' . $attachment->name . '.' . $attachment->extension), [
                'as' => $this->subject . '.' . $attachment->extension,
            ]);
        }
        return $view;
    }
}
