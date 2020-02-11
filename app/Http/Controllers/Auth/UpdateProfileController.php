<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\Auth\UpdateProfileRequest;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

use App\Models\ContactInfo;

class UpdateProfileController extends Controller
{
    public function showForm(Request $request) {
        return view('auth.update_profile', [
            'user' => Auth::user(),
        ]);
    }

    public function handleForm(UpdateProfileRequest $request) {
        $validated = $request->validated();

        $user = Auth::user();

        $user->honorific_prefix = $validated['honorific_prefix'];
        $user->first_name = mb_convert_case($validated['first_name'], MB_CASE_TITLE);
        $user->last_name = mb_convert_case($validated['last_name'], MB_CASE_TITLE);
        // $user->email = $validated['email']; // TODO: verify uniqueness and unverify field email_is_verified

        $user->birthday = $validated['birthday'];

        $user_contact_info = ($user->contact_info()->exists()) ? $user->contact_info : new ContactInfo;

        $user_contact_info->mobile_phone = str_replace([' ', '-', '.'], '', $validated['mobile_phone']);
        $user_contact_info->address = $validated['address'];
        $user_contact_info->zip_code = $validated['zip_code'];
        $user_contact_info->city = $validated['city'];

        try{
            DB::beginTransaction();
        
            $user_contact_info->save();
            $user->contact_info_id = $user_contact_info->id;
            $user->save();

            DB::commit();
        } catch(\Exception $e) {
            DB::rollback();
            
            flash('Une erreur inattendue s\'est produite (code 5002). Si elle persiste, tu peux contacter le responsable du site (louis@hostux.fr).')->error();
            return redirect()->route('auth.update_profile');
        }

        // Redirecting the user with a little message
        flash('Ton profil a été mis à jour avec succès.')->success();
        return redirect()->route('close_popup');
    }
}
