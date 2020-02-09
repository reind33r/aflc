$r= new App\Models\Race\Race();
$r->subdomain = 'application';
$r->name = 'À fond la caisse !';
$r->date = new \DateTime('2021-01-01');
$r->location = 'Tancarville';
$r->save();