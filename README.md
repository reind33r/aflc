>>> $r= new App\Models\Race\Race();
=> App\Models\Race\Race {#3069}
>>> $r->subdomain = 'application';
=> "application"
>>> $r->name = 'À fond la caisse !';
=> "À fond la caisse !"
>>> $r->date = new \DateTime('2021-01-01');
=> DateTime @1609459200 {#3074
     date: 2021-01-01 00:00:00.0 UTC (+00:00),
   }
>>> $r->location = 'Tancarville';
=> "Tancarville"
>>> $r->save();
=> true
>>> 