<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\LogQrcode;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(Request $request, $user)
    {
        if ($user->role == 'pegawai') {
        // if ($user->hasRole('pegawai')) {
            $logQr = LogQrcode::where('pegawai_id', $user->pegawai->id)->first();

            if ($logQr) {
                if (!searchData($logQr->json_data, 'tanggal', date('Y-m-d'))) {
                    // get json data
                    $jsonData = json_decode($logQr->json_data, true);

                    $newDataQr = [
                        'id' => count($jsonData) + 1,
                        'tanggal' => date('Y-m-d'),
                        'qr_code' => $user->pegawai->id . '_' . now()->toDateTimeString(),
                        'status' => false
                    ];

                    // Add the new data to the existing JSON data
                    $jsonData[] = $newDataQr;

                    $logQr->json_data = json_encode($jsonData, JSON_PRETTY_PRINT);
                    $logQr->save();
                }
            }

            return redirect()->route('staff.dashboard');
        }
    }
}
