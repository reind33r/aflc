<?php

namespace App\Models\Race;

use Carbon\Carbon;

class RegistrationFormData {
    private $_userProgress = 1;

    private $registration_opportunity_id = null;

    private $captain_honorific_prefix = null;
    private $captain_first_name = null;
    private $captain_last_name = null;
    private $captain_email = null;
    private $captain_mobile_phone = null;
    private $captain_address = null;
    private $captain_zip_code = null;
    private $captain_city = null;

    private $captain_is_pilot = false;
    private $captain_birthday = null;

    private $pilots = []; // honorific_prefix, first_name, last_name, birthday

    private $soapboxes = []; // name, desired_number

    private $team_name = null;
    private $team_comments = null;

    public function initial($key, $value) {
        if(!property_exists($this, $key)) {
            throw new \Exception('RegistrationFormData has no property "'. $key .'".');
        }

        if($this->{$key} === null) {
            $this->{$key} = $value;
        }
    }

    public function get($key, $default = null) {
        if(!property_exists($this, $key)) {
            throw new \Exception('RegistrationFormData has no property "'. $key .'".');
        }

        return $this->{$key} ?? $default;
    }

    public function set($key, $value) {
        if(!property_exists($this, $key)) {
            throw new \Exception('RegistrationFormData has no property "'. $key .'".');
        }

        if($key == 'pilots') {
            $this->pilots = [];

            foreach($value as $pilot) {
                $this->addPilot($pilot);
            }

            return;
        }

        if($key == 'soapboxes') {
            $this->soapboxes = [];

            foreach($value as $soapbox) {
                $this->addSoapbox($soapbox);
            }
            return;
        }

        if($key == 'captain_mobile_phone') {
            $value = str_replace([' ', '-', '.'], '', $value);
        }

        if(in_array($key, ['captain_first_name', 'captain_last_name'])) {
            $value = mb_convert_case($value, MB_CASE_TITLE);
        }

        if($key == 'captain_birthday') {
            $value = Carbon::createFromFormat('Y-m-d', $value);
        }

        $this->{$key} = $value;
    }

    public function addPilot($pilot) {
        if( !array_key_exists('first_name', $pilot) ||
            !array_key_exists('last_name', $pilot) ||
            !array_key_exists('birthday', $pilot) ||
            !array_key_exists('honorific_prefix', $pilot)
        ) {
            throw new \Exception('RegistrationFormData: incorrect $pilot provided in addPilot(). Required keys are: first_name, last_name, birthday and honorific_prefix');
        }

        $pilot['birthday'] = Carbon::createFromFormat('Y-m-d', $pilot['birthday']);
        $pilot['first_name'] = mb_convert_case($pilot['first_name'], MB_CASE_TITLE);
        $pilot['last_name'] = mb_convert_case($pilot['last_name'], MB_CASE_TITLE);

        $this->pilots[count($this->pilots) + 1] = $pilot;
    }

    public function addSoapbox($soapbox) {
        if( !array_key_exists('name', $soapbox) ||
            !array_key_exists('desired_number', $soapbox)
        ) {
            throw new \Exception('RegistrationFormData: incorrect $soapbox provided in addSoapbox(). Required keys are: name, desired_number.');
        }

        $this->soapboxes[count($this->soapboxes) + 1] = $soapbox;
    }

    public function userProgress() {
        return $this->_userProgress;
    }
    public function updateUserProgress($validated_step) {
        if($validated_step > $this->_userProgress) {
            $this->_userProgress = $validated_step;
        }
    }
}