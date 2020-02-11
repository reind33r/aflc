<?php

namespace App\Http\Controllers\Race;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\Race\RegistrationRequest;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

use App\Services\UsernameGenerator;

use App\Models\Race\RegistrationFormData;
use App\Models\Race\Team;
use App\Models\User;
use App\Models\ContactInfo;
use App\Models\Race\Soapbox;
use App\Models\Race\TeamPilot;
use App\Models\Race\TeamSoapbox;

use App\Mail\Race\RegistrationSuccess;

class RegistrationController extends Controller
{
    private function _getRegistrationFormData() {
        return Session::get('registration_form_data', new RegistrationFormData);
    }

    private function _redirectUserProgressViolation() {
        flash('Tu ne dois pas sauter d\'étapes.')->warning();
        return redirect()->route('race.register.step' . $this->_getRegistrationFormData()->userProgress());
    }

    /**
     * Step 1: login
     */
    public function handleStep(RegistrationRequest $request) {
        $validated = $request->validated();
        $registration_form_data = $this->_getRegistrationFormData();

        $step = $validated['step'];
        unset($validated['step']);
        
        $registration_form_data->updateUserProgress($step + 1);
        
        switch ($step) {
            case 1:
                foreach($validated as $key => $value) {
                    $registration_form_data->set('captain_' . $key, $value);
                }

                $response = redirect()->route('race.register.step2');
                break;

            case 2:
                foreach($validated as $key => $value) {
                    $registration_form_data->set($key, $value);
                }
                
                $response = redirect()->route('race.register.step3');
                break;

            case 3:
                foreach($validated as $key => $value) {
                    $registration_form_data->set($key, $value);
                }
                
                $response = redirect()->route('race.register.step4');
                break;

            case 4:
                $registration_form_data->set('team_name', $validated['team_name']);
                
                $response = redirect()->route('race.register.step5');
                break;

            case 5:
                $race = $request->route('race');

                // Creating models from RegistrationFormData
                $captain = Auth::user();
                $captain->honorific_prefix = $registration_form_data->get('captain_honorific_prefix');
                $captain->first_name = $registration_form_data->get('captain_first_name');
                $captain->last_name = $registration_form_data->get('captain_last_name');
                // $captain->email = $registration_form_data->get('captain_email'); // TODO: verify uniqueness and unverify field email_is_verified
                $captain->birthday = $registration_form_data->get('captain_birthday');

                $captain_contact_info = ($captain->contact_info()->exists()) ? $captain->contact_info : new ContactInfo;

                $captain_contact_info->mobile_phone = $registration_form_data->get('captain_mobile_phone');
                $captain_contact_info->address = $registration_form_data->get('captain_address');
                $captain_contact_info->zip_code = $registration_form_data->get('captain_zip_code');
                $captain_contact_info->city = $registration_form_data->get('captain_city');

                $team = new Team;
                $team->name = $registration_form_data->get('team_name');
                $team->race_subdomain = $race->subdomain;
                $team->captain_id = $captain->id;

                $pilots = [];
                foreach($registration_form_data->get('pilots') as $pilot) {
                    $user = new User;
                    $user->honorific_prefix = $pilot['honorific_prefix'];
                    $user->first_name = $pilot['first_name'];
                    $user->last_name = $pilot['last_name'];
                    $user->birthday = $pilot['birthday'];
                    $user->username = UsernameGenerator::usernameFromName($user->first_name, $user->last_name);

                    $pilots[] = $user;
                }

                $soapboxes = [];
                foreach($registration_form_data->get('soapboxes') as $soapbox) {
                    $m_soapbox = new Soapbox;
                    $m_soapbox->name = $soapbox['name'];
                    $m_soapbox->desired_number = $soapbox['desired_number'];

                    $soapboxes[] = $m_soapbox;
                }

                // Saving models to database
                try{
                    DB::beginTransaction();
                
                    $captain_contact_info->save();
                    $captain->contact_info_id = $captain_contact_info->id;
                    $captain->save();

                    $team->save();

                    foreach($pilots as $pilot) {
                        $pilot->save();

                        TeamPilot::create([
                            'user_id' => $pilot->id,
                            'team_id' => $team->id,
                        ]);
                    }

                    if($registration_form_data->get('captain_is_pilot')) {
                        TeamPilot::create([
                            'user_id' => $captain->id,
                            'team_id' => $team->id,
                        ]);
                    }

                    foreach($soapboxes as $soapbox) {
                        $soapbox->save();

                        TeamSoapbox::create([
                            'soapbox_id' => $soapbox->id,
                            'team_id' => $team->id,
                        ]);
                    }
                
                    DB::commit();
                } catch(\Exception $e) {
                    DB::rollback();
                    
                    flash('Une erreur inattendue s\'est produite (code 5001). Si elle persiste, tu peux contacter le responsable du site (louis@hostux.fr).')->error();
                    return redirect()->route('race.register.step4');
                }

                // Sending email
                Mail::to($captain)
                    ->send(new RegistrationSuccess($captain, $race));

                // Forgetting the form data
                Session::forget('registration_form_data');

                // Redirecting the user with a little message
                flash('Ton inscription a bien été enregistrée. Nous t\'avons envoyé un e-mail pour expliquer la suite des opérations !')->success();
                return redirect()->route('index');
                
                break;
            
            default:
                throw new \Exception('Erreur inattendue : la validation du numéro d\'étape n\'a pas fonctionné correctement (App\Http\Requests\Race\RegistrationRequest).');
                break;
        }

        Session::put('registration_form_data', $registration_form_data);

        return $response;
    }

    /**
     * Step 1: login
     */
    public function showStep1(Request $request) {
        $registration_form_data = $this->_getRegistrationFormData();

        if(Auth::check()) {
            // TODO: gender
            $registration_form_data->initial('captain_first_name', Auth::user()->first_name);
            $registration_form_data->initial('captain_last_name', Auth::user()->last_name);
            $registration_form_data->initial('captain_email', Auth::user()->email);
            $registration_form_data->initial('captain_mobile_phone', Auth::user()->contact_info->mobile_phone ?? '');
            $registration_form_data->initial('captain_address', Auth::user()->contact_info->address ?? '');
            $registration_form_data->initial('captain_zip_code', Auth::user()->contact_info->zip_code ?? '');
            $registration_form_data->initial('captain_city', Auth::user()->contact_info->city ?? '');
        } else {
            // If login error, errors are shown in this page; if success, redirect to next step
            Session::put('previous_url', URL::current());
        }
    

        return view('race.register.step1', [
            'registration_form_data' => $registration_form_data,
        ]);
    }

    /**
     * Step 2: pilots
     */
    public function showStep2(Request $request) {
        $registration_form_data = $this->_getRegistrationFormData();

        if($registration_form_data->userProgress() < 2) {
            return $this->_redirectUserProgressViolation();
        }

        return view('race.register.step2', [
            'registration_form_data' => $registration_form_data,
        ]);
    }

    /**
     * Step 3: soapboxes
     */
    public function showStep3(Request $request) {
        $registration_form_data = $this->_getRegistrationFormData();

        if($registration_form_data->userProgress() < 3) {
            return $this->_redirectUserProgressViolation();
        }

        return view('race.register.step3', [
            'registration_form_data' => $registration_form_data,
        ]);
    }

    /**
     * Step 4: overview
     */
    public function showStep4(Request $request) {
        $registration_form_data = $this->_getRegistrationFormData();

        if($registration_form_data->userProgress() < 4) {
            return $this->_redirectUserProgressViolation();
        }

        return view('race.register.step4', [
            'registration_form_data' => $registration_form_data,
        ]);
    }

    /**
     * Step 4: payment
     */
    public function showStep5(Request $request) {
        $registration_form_data = $this->_getRegistrationFormData();

        if($registration_form_data->userProgress() < 5) {
            return $this->_redirectUserProgressViolation();
        }

        return view('race.register.step5', [
            'registration_form_data' => $registration_form_data,
        ]);
    }

    // https://www.5balloons.info/multi-page-step-form-in-laravel-with-validation/
}