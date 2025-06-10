<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Orders;

class PedidoEnviado extends Notification
{
    use Queueable;

    protected $order;

    public function __construct(Orders $order)
    {
        $this->order = $order;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Tu pedido está en camino')
            ->greeting('Hola ' . $this->order->name . '!')
            ->line('Tu pedido con referencia ' . $this->order->reference . '.')
            ->line('Tu pedido acaba de ser enviado. Esperamos que lo recibas pronto.')
            ->line('Gracias por confiar en nosotros.')
            ->salutation('Saludos, el equipo de FinalGym');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
