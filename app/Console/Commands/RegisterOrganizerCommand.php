<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\Organizer;
use App\Mail\OrganizerRegistered;

class RegisterOrganizerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'register:organizer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates an organizer account.';

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
     * @return mixed
     */
    public function handle()
    {
        $name = $this->ask('Organizer name');
        $email = $this->ask('Email');
        
        $password = Str::random(8);
        $hashed_password = Hash::make($password);

        $organizer = Organizer::create([
            'name' => $name,
            'email' => $email,
            'password' => $hashed_password
        ]);

        $this->info('Organizer account created.');
        $this->table(['Name', 'Email', 'Password'], [[$name, $email, $password]]);

        // Sending email
        Mail::to($organizer)
            ->send(new OrganizerRegistered($name, $password));

        $this->info('An email has been sent to '. $email .' with the credentials.');
    }
}
