<?php

namespace App\Http\Middleware;

use App\Helpers\CasPhp\phpCAS;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthCAS
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        //phpCAS::setDebug('/tmp/phpCAS.log'); // Schrijft debug informatie naar een log-file

        // Parameters: CAS versie, url CAS server, poort CAS server, CAS server URI (idem als host),
        // boolean die aangeeft of sessie moet gestart worden, communicatieprotocol (SAML) tussen toepassing en CAS server
        phpCAS::client(SAML_VERSION_1_1, 'jasig.firat.edu.tr', 443, '/cas', true, 'saml');

        // Geeft aan vanaf welke server logout requests mogelijk zijn
        phpCAS::handleLogoutRequests(true, array('cas1.ugent.be', 'cas2.ugent.be', 'cas3.ugent.be', 'cas4.ugent.be', 'cas5.ugent.be', 'cas6.ugent.be'));

        // Configuratie van het certificaat van de CAS server
        //phpCAS::setExtraCurlOption(CURLOPT_SSLVERSION, 3);
        // Locatie van het "trusted certificate authorities" bestand:
        //phpCAS::setCasServerCACert('/home/administrator/firat.edu.tr.pem');
        // Geen server verificatie (minder veilig!):
        phpCAS::setNoCasServerValidation();
        // Hier gebeurt de authenticatie van de gebruiker
        phpCAS::forceAuthentication();
        $attr = phpCAS::getAttributes();
        if ($attr) {
            $user = User::where('userEMailAddress', $attr['userEMailAddress'])->first();
            if ($user) {
                $user->update($attr);
            } else {
                if(User::where('userEMailAddress', $attr['userEMailAddress'])->first() && User::where('userEMailAddress', $attr['userEMailAddress'])->withTrashed()->first()->deleted_at != null){
                    $user = User::where('userEMailAddress', $attr['userEMailAddress'])->withTrashed()->first();
                    $user->deleted_at = null;
                    $user_type = 1;
                    foreach ($attr['userGroupMembership'] as $group){
                        if (str_contains($group,"Student")){
                            $user_type = 0;
                        }
                    }
                    $user->user_type = $user_type;
                    $user->save();
                }else{
                    $user_type = 1;
                    foreach ($attr['userGroupMembership'] as $group){
                        if (str_contains($group,"Student")){
                            $user_type = 0;
                        }
                    }
                    $attr['user_type'] = $user_type;
                    $user = User::create($attr);
                }
            }
            Auth::login($user);
            return $next($request);

        } else {
            return abort(403);
        }
    }
}
