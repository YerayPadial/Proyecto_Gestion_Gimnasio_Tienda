<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Orders;

class PedidoRealizadoNotification extends Notification
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
        $message = (new MailMessage)
            ->subject('Confirmación de tu pedido - FinalGym')
            ->greeting('Hola ' . $this->order->name . '!')
            ->line('Gracias por tu pedido. Aquí tienes el resumen:')
            ->line('Referencia: ' . $this->order->reference)
            ->line('Fecha: ' . optional($this->order->ordered_at)->format('d/m/Y H:i'))
            ->line('Estado: ' . $this->order->status)
            ->line('----------------------');

        foreach ($this->order->items as $item) {
            $iva = $item->subtotal * 0.21;
            $total = $item->subtotal * 1.21;
            $message->line(
                $item->product_name . ' - ' . $item->quantity . ' x ' .
                number_format($item->price, 2) . ' € = ' .
                number_format($total, 2) . ' € (IVA incluido)'
            );
        }

        $totalConIva = $this->order->total_price * 1.21;

        $message->line('----------------------')
            ->line('Total con IVA: ' . number_format($totalConIva, 2) . ' €');

        if ($this->order->shipping_method === 'recogida') {
            $message->line('Método de entrega: Recogida en tienda');
        } else {
            $message->line('Dirección de envío: ' . $this->order->street . ', ' . $this->order->municipality . ', ' . $this->order->province);
        }

        return $message->salutation('Saludos, el equipo de FinalGym');
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
