<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Orders;

class PedidoParaRecoger extends Notification
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
            ->subject('Tu pedido está listo para recoger')
            ->greeting('Hola ' . $this->order->name . '!')
            ->line('Tu pedido con referencia ' . $this->order->reference . '.')
            ->line('Tu pedido está en nuestras instalaciones y listo para ser recogido.')
            ->line('Por favor, asegúrate de llevar una identificación válida al recogerlo.')
            ->line('Si tienes alguna pregunta, no dudes en contactarnos.')
            ->line('Recuerda que el horario de recogida es de lunes a viernes de 8:30 a 20:00.')
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
