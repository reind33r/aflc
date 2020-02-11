$r= new App\Models\Race\Race();
$r->subdomain = 'application';
$r->name = 'À fond la caisse !';
$r->date = new \DateTime('2021-01-01');
$r->location = 'Tancarville';
$r->save();

# Codes d'erreur

* 5001 : race registration error during DB transaction
* 5002 : update profile error during DB transaction