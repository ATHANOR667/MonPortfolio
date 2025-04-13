<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;


class AuthController extends Controller
{
    /**
     *
     *LOGIN
     *
     *
     */
    function login(): string|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        try {
            $admin = User::where('password','=',bcrypt('0000'))->first();
        }catch (\Exception $e){
            return $e;
        }

        if($admin){
            $default = true ;
        }else{
            $default = false ;
        }
        return view('auth.login',[
            'default' => $default
        ]);
    }

    function login_process(Request $request):string|RedirectResponse
    {
        try {
            try {
                $admin = User::firstOrFail();

            }catch (\Exception $e){
                return $e;
            }


            if ($admin && Hash::check($request->input('password'),$admin->password) )
            {
                Auth::guard('admin')->login($admin);
                $request->session()->regenerate();
                return redirect()->intended(route('admin.dashboard'));
            }
            return redirect()->route('admin.login')->withErrors([
               'password' => 'Vérifiez votre mot de passe'
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
           return $e ;
        }

    }

    /**
     *
     *
     * LOGOUT
     *
     *
     */
    public function logout(Request $request):string|RedirectResponse
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
    /**
     *
     * MODIFICATION DES IDENTIFIANTS
     *
     */



    /**
     *
     *
     * MODIFICATION DES IDENTIFIANTS PAR DEFAUT (email et mot de passe)
     *
     *
     */
    function otp_request_default_erase() : \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        return view('auth.OtpRequest');
    }

    function otp_request_default_erase_process( Request $request ):string|RedirectResponse
    {
        try {
            $admin = Auth::guard('admin')->user();
        }catch (\Exception $e){
            return $e;
        }
        if (!$admin) {
            return 'ERROR 404';
        }

        $email = $request->input('email');

        // Vérifier si l'utilisateur doit attendre avant de retenter
        if (session()->has('last_email_sent_time')) {
            $lastSentTime = session()->get('last_email_sent_time');
            $currentTime = now();

            $diffInMinutes = $lastSentTime->diffInMinutes($currentTime);
            if ($diffInMinutes < 5) {
                return redirect()->route('admin.otp_request_default_erase')->with(['message' => 'Veuillez attendre '.(5-$diffInMinutes).' minutes avant de retenter.']);
            }
        }

        //on verifie que l'admin qui veut s'inscrire n'est pas deja inscrit avant de lui envoyer le mail d'inscription

        try {
            $otp = random_int(1000, 9999);
            Cache::put('otp_' . $email, $otp, 600);
            Mail::to($email)->queue(new OtpMail($otp));
            session()->put('validation_email', $email);
            // Mettre à jour le timestamp de l'envoi d'e-mail
            session()->put('last_email_sent_time', now());
            return redirect()->route('admin.default_erase')->with(['message' => 'E-mail envoyé avec succès.']);
        } catch (\Exception $e) {
                return redirect()->route('admin.otp_request_default_erase')->with(['message' => 'Une erreur s\'est produite lors de l\'envoi de l\'e-mail. Veuillez réessayer.']);
        }
    }


    function default_erase(): string|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        return view('auth.default_erase');
    }

    function default_erase_process(Request $request):string|RedirectResponse
    {
        $email = session('validation_email');
        $otp = $request->input('otp');
        $admin = Auth::guard('admin')->user();

        try {
            if (Cache::has('otp_' . $email) ) {
                if(Cache::get('otp_' . $email) == $otp){
                    Cache::forget('otp_' . $email);
                    $admin->update([
                        'password'=> bcrypt($request->input('password')),
                        'email'=>$email
                    ]);
                    return redirect()->route('admin.login')->with(['message','Modification reussie , vous pouvez vous connecter ']);
                }else{
                    return redirect()->route('admin.default_erase')->withErrors([
                        'otp' => ' Otp Incorrect '
                    ]);
                }
            }else{
                return redirect()->route('admin.otp_request_default_erase')->with([
                    'message' => 'Session expirée , veuillez recommencer le processus'
                ]);
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $e ;
        }


    }




    /**
     *
     *
     *MODIFICAION DU MOT DE PASSE D'UN UTILISATEUR QUI N'EST CONNECTE
     *
     *
     *
    */



    function password_reset_init():string|RedirectResponse
    {
        try {
            $admin = Auth::guard('admin')->user();
            $email = $admin->email;
        }catch (\Exception $e){
            return $e;
        }

        // Vérifier si l'utilisateur doit attendre avant de retenter
        if (session()->has('last_email_sent_time')) {
            $lastSentTime = session()->get('last_email_sent_time');
            $currentTime = now();

            $diffInMinutes = $lastSentTime->diffInMinutes($currentTime);
            if ($diffInMinutes < 5) {
                return redirect()->route('admin.security.index')->with(['message' => 'Veuillez attendre '.(5-$diffInMinutes).' minutes avant de retenter.']);
            }
        }

        try {
            $otp = random_int(1000, 9999);
            Cache::put('otp_' . $email, $otp, 600);
            Mail::to($email)->queue(new OtpMail($otp));
            session()->put('validation_email', $email);
            // Mettre à jour le timestamp de l'envoi d'e-mail
            session()->put('last_email_sent_time', now());
            return   redirect()->route('admin.password_reset')->with(['message' => 'E-mail envoyé avec succès.']);
        } catch (\Exception $e) {
            return redirect()->route('admin.security.index')->with(['message' => 'Une erreur s\'est produite lors de l\'envoi de l\'e-mail. Veuillez réessayer.']);
        }
    }

    function password_reset(): string|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        return  view('auth.password_reset');
    }

    function password_reset_process( Request $request):string|RedirectResponse
    {
        $email = session('validation_email');

        $otp = $request->input('otp');

        try {
            $admin = Auth::guard('admin')->user();
            if (Cache::has('otp_' . $email) ) {

                if(Cache::get('otp_' . $email) == $otp){
                    Cache::forget('otp_' . $email);
                    $admin->update([
                        'password'=> bcrypt($request->input('password')),
                    ]);
                    return redirect()->route('admin.login')->with(['message','Modification reussie , vous pouvez vous connecter ']);

                }else{
                    return redirect()->route('admin.password_reset')->withErrors([
                        'otp' => ' Otp Incorrect '
                    ]);
                }
            }else{
                return redirect()->route('admin.security.index')->with([
                    'message' => 'Session expirée '
                ]);
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $e ;
        }
    }


    /**
     *
     *
     *MODIFICAION DU MOT DE PASSE D'UN UTILISATEUR QUI N'ETAIT PAS CONNECTE
     *
     *
     */



    function password_reset_init_while_dissconnected(): string|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        return view('auth.email_check');
    }

    function password_reset_init_while_dissconnected_process(Request $request):string|RedirectResponse
    {
        $email = $request->input('email');
        $admin = User::where('email','=',$email)->first();
        if($admin){
            // Vérifier si l'utilisateur doit attendre avant de retenter
            if (session()->has('last_email_sent_time')) {
                $lastSentTime = session()->get('last_email_sent_time');
                $currentTime = now();

                $diffInMinutes = $lastSentTime->diffInMinutes($currentTime);
                if ($diffInMinutes < 5) {
                    return redirect()->route('admin.login')->with(['message' => 'Veuillez attendre '.(5-$diffInMinutes).' minutes avant de retenter.']);
                }
            }

            try {
                $otp = random_int(1000, 9999);
                Cache::put('otp_' . $email, $otp, 600);
                Mail::to($email)->queue(new OtpMail($otp));
                session()->put('validation_email', $email);
                // Mettre à jour le timestamp de l'envoi d'e-mail
                session()->put('last_email_sent_time', now());
                return   redirect()->route('admin.password_reset_while_dissconnected')->with(['message' => 'E-mail envoyé avec succès.']);
            } catch (\Exception $e) {
                return redirect()->route('admin.login')->with(['message' => 'Une erreur s\'est produite lors de l\'envoi de l\'e-mail. Veuillez réessayer.']);
            }
        }else{

            return redirect()->route('admin.login')->with(['message' => 'Adresse inconnue']);
        }

    }

    function password_reset_while_dissconnected(): string|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        return  view('auth.password_reset');
    }

    function password_reset_process_while_dissconnected( Request $request):string|RedirectResponse
    {
        $email = session('validation_email');
        $otp = $request->input('otp');
        $admin = User::where('email', '=', $email)->first();
        if ($admin) {
            try {
                if (Cache::has('otp_' . $email)) {

                    if (Cache::get('otp_' . $email) == $otp) {
                        Cache::forget('otp_' . $email);
                        $admin->update([
                            'password' => bcrypt($request->input('password')),
                        ]);
                        return redirect()->route('admin.login')->with(['message', 'Modification reussie , vous pouvez vous connecter ']);

                    } else {
                        return redirect()->route('admin.password_reset_while_dissconnected')->withErrors([
                            'otp' => ' Otp Incorrect '
                        ]);
                    }
                }
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                return $e;
            }
        } else {
            return redirect()->route('admin.login')->with([
                'message' => 'Session expirée '
            ]);
        }
    }







    /**
     *
     *
     *MODIFICATION DE L'EMAIL
     *
     *
     */

    function email_reset_otp_request(): string|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        return view('auth.email_reset_otp_request');
    }

    function email_reset_otp_request_process(Request $request):string|RedirectResponse
    {
        try {
            $admin = Auth::guard('admin')->user();
            $email = $request->input('email');

            if (Hash::check($request->input('password'),$admin->password) ){
                // Vérifier si l'utilisateur doit attendre avant de retenter
                if (session()->has('last_email_sent_time')) {
                    $lastSentTime = session()->get('last_email_sent_time');
                    $currentTime = now();
                    $diffInMinutes = $lastSentTime->diffInMinutes($currentTime);
                    if ($diffInMinutes < 5) {
                        return redirect()->route('admin.email_reset_otp_request')->with(['message' => 'Veuillez attendre '.(5-$diffInMinutes).' minutes avant de retenter.']);
                    }
                }
                try {
                    $otp = random_int(1000, 9999);
                    Cache::put('otp_' . $email, $otp, 600);
                    Mail::to($email)->queue(new OtpMail($otp));
                    session()->put('validation_email', $email);
                    // Mettre à jour le timestamp de l'envoi d'e-mail
                    session()->put('last_email_sent_time', now());
                    return redirect()->route('admin.email_reset')->with(['message' => 'E-mail envoyé avec succès.']);
                } catch (\Exception $e) {
                    return redirect()->route('admin.email_reset_otp_request')->with(['message' => 'Une erreur s\'est produite lors de l\'envoi de l\'e-mail. Veuillez réessayer.']);
                }
            }
            return redirect()->route('admin.email_reset_otp_request')->withErrors([
                'password' => 'Vérifiez votre mot de passe'
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
           return $e ;
        }
    }

    public function email_reset(): string|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        return view('auth.email_reset');
    }

    public function email_reset_process(Request $request):string|RedirectResponse{
        $otp = $request->input('otp');
        $email = session('validation_email');
        try {
            $admin = Auth::guard('admin')->user();

            if (Cache::has('otp_' . $email) && Cache::get('otp_' . $email) == $otp) {
                Cache::forget('otp_' . $email);
                $admin->update([
                    'email'=> $email ,
                ]);

            return redirect()->route('admin.security.index')->with(['message','Modification reussie , vous pouvez vous connecter ']);
            }else{
                return redirect(route('admin.email_reset'))->withErrors([
                    'otp' => 'Otp incorrect'
                ]);
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $e ;
        }
    }


}
