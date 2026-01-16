<?php

namespace App\Mail;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;
class AppointmentMail extends Mailable
{

    use Queueable, SerializesModels;
     public $appointment;
     public $patient;
     public $statusText;
     public $actionType;
    /**
     * Create a new message instance.
     */
    public function __construct(Appointment $appointment, $actionType = 'new')
    {
      $this->appointment = $appointment;
      $this->patient = $appointment->patient;
      $this->statusText =$this->getStatusText($appointment->status);
      $this->actionType =$actionType;
    }

    /**
     * Get the message envelope.
     */
    public function getStatusText($status){
        $statuses=[
            'hold'=>'hold',
            'scheduled'=> 'scheduled',
            'completed'=>'completed',
            'cancelled'=>'cancelled',
        ];
          return $statuses[$status] ?? $status;
    }
    public function envelope(): Envelope
    {
        if($this->actionType == 'new'){
            $subject='your appointment is registered  '.$this->statusText;
        }
        else{
            $subject= 'your appointment is updated  '.$this->statusText;
        }
        return new Envelope(
            subject: $subject,
            from:new Address('rahaftaha594@gmail.com','Together to heal your pain'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.appointment-status',
            with:[
                'appointment' => $this->appointment,
                'patient' => $this->patient,
                'statusText' => $this->statusText,
                'actionType' => $this->actionType,
                'appointmentDate' => $this->appointment->appointment_date,
                'doctorName' => $this->appointment->doctor->name ?? 'Emergency',
                'clinicName' => 'Together to heal your pain',
                'clinicEmail'=>'rahaftaha594@gmail.com'
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
