<?php

namespace App\Notifications;


use App\Models\invoices;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

// use Illuminate\Support\Facades\Auth;


class AddInvoiceDatabase extends Notification
{
    use Queueable;
    private $invoices;

    /**
     * Create a new notification instance.
     */
    public function __construct(invoices $invoices)
    {
        $this->invoices = $invoices;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    // public function toMail(object $notifiable): MailMessage
    // {
    //     return (new MailMessage)
    //         ->line('The introduction to the notification.')
    //         ->action('Notification Action', url('/'))
    //         ->line('Thank you for using our application!');
    // }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        // $url = 'http://invoices.test/invoicesDetails/' . $this->invoice_id . '/edit';

        return [

            'id' => $this->invoices->id,
            'title' => '  تم اضافة فاتورة جديدة بواسطة : ',
            // ...

            'user' => Auth::user()->name,
        ];
    }
}
