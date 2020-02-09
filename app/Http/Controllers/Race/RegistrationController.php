<?php

namespace App\Http\Controllers\Race;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\Race\RegistrationRequest;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

use App\Models\Race\RegistrationFormData;

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