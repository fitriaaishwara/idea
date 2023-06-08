<?php

namespace App\Console\Commands;

use App\Mail\ScheduleEmailSales;
use App\Models\Client;
use App\Models\FollowUp;
use App\Models\FollowUpClient;
use App\Models\ScheduleEmail;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AutoScheduleEmailSales extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:emailsales';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $today = Carbon::now(new \DateTimeZone('Asia/Jakarta'));

        $data = ScheduleEmail::with(['schedule_email_scopes'])
            ->whereDate('date', $today)
            ->where('schedule_status', 1)
            ->where('status', true)
            ->oldest()
            ->first();

        if ($data) {
            $subject                = $data['subject'];
            $body                   = $data['body'];
            $attachment_id          = $data['attachment_id'];
            $user_id                = $data['user_id'];
            $is_html                = $data['is_html'];
            $arrayFollowUpClient    = [];
            $arrayEmailClient       = [];
            $scope                  = $data->schedule_email_scopes->pluck('scope_id');

            $clients = Client::select()
                ->whereDoesntHave('follow_up_clients', function ($query) use ($subject) {
                    $query->where('note', 'like', '%' . $subject . '%');
                })
                ->where('email', 'like', '%@%')
                ->where('user_id', $user_id)
                ->where('status', true)
                ->where(function ($query) use ($scope) {
                    $query->whereIn('scope_1', $scope)->orWhereIn('scope_2', $scope)->orWhereIn('scope_3', $scope);
                })
                ->get()
                ->take(100);

            foreach ($clients as $key => $client) {
                $followUpClient = [
                    'id'            => Str::uuid(),
                    'client_id'     => $client->id,
                    'date'          => $today,
                    'type'          => 4,
                    'note'          => $subject,
                    'created_by'    => $user_id,
                    'created_at'    => $today
                ];
                array_push($arrayFollowUpClient, $followUpClient);
                array_push($arrayEmailClient, $client->email);
            }
            try {
                Mail::mailer('smtp')->bcc($arrayEmailClient)->send(new ScheduleEmailSales($subject, $body, $attachment_id, $is_html));
                FollowUp::insert($arrayFollowUpClient);
                ScheduleEmail::where('id', $data['id'])->update([
                    'schedule_status'       => 2
                ]);
            } catch (\Exception $ex) {
                ScheduleEmail::where('id', $data['id'])->update([
                    'schedule_status'       => 3
                ]);
            }
        }
        return 0;
    }
}
