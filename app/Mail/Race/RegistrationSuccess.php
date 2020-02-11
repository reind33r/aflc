<?php

namespace App\Mail\Race;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistrationSuccess extends Mailable
{
    use Queueable, SerializesModels;

    public $captain, $race;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($captain, $race)
    {
        $this->captain = $captain;
        $this->race = $race;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.race.registration_success', [
            'captain' => $this->captain,
            'race' => $this->race,
        ]);
    }
}
