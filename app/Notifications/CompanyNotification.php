<?php

namespace App\Notifications;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Company;

class CompanyNotification extends Notification
{
    use Queueable;

    protected $company;

    public function __construct(Company $company)
    {
        $this->company = $company;
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'Company ' . ($this->company->id . 'created') . ': ' . $this->company->company_name,
            'company_id' => $this->company->id,
        ];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Company Registration')
            ->line('A new company named ' . $this->company->company_name . ' has been registered.')
            ->line('[Approve](' . route('company.approve', $this->company->id) . ') OR [Disapprove](' . route('company.disapprove', $this->company->id) . ')');
    }

}
