<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Psgdbuser;
use App\Models\Mysqluser;

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
    protected $redirectTo = '/home';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
       // $this->middleware('auth')->only('logout');
    }
	
	public function showLoginForm()
    {
        return view('auth.login');
    }
	
	public function login(Request $request,$username_login)
	{
		$credentials = $request->only('username', 'password');
		// Cek di MySQL terlebih dahulu
		$user = Mysqluser::where('username','=',$username_login)->first();
        //Get info user
        $getUsr = DB::connection('mitra')->table('gate.sc_userrole as ur')
        ->join('gate.sc_role as r', 'r.koderole', '=', 'ur.koderole')
        ->join('gate.ms_unit as u', 'u.kodeunit', '=', 'ur.kodeunit')
        ->join('gate.sc_user as us', 'us.userid', '=', 'ur.userid')
        ->leftJoin('akademik.ms_mahasiswa as ms', 'ms.nim', '=', 'us.username')
        // Perbaikan untuk table ms_pegawai
        ->leftJoin('sdm.ms_pegawai as pw', 'pw.nidn', '=', 'us.username') // Menggunakan gate_sdm sebagai schema
        ->leftJoin('gate.sc_menurole as mr', 'mr.koderole', '=', 'r.koderole')
        ->leftJoin('gate.sc_menu as mn', 'mn.idmenu', '=', 'mr.idmenu')
        ->leftJoin('gate.sc_modul as m', 'm.kodemodul', '=', 'mn.kodemodul')
        ->select([
            'us.userdesc',
            'us.email',
            'ur.koderole',
            'r.namarole', 
            'ur.kodeunit',
            'u.namaunit',
            'u.kodeunit',
            'u.infoleft',
            'u.inforight',
            'mn.kodemodul',
            'm.namamodul',
            'r.levelcp',
            'ms.nim',
            'u.namaunit',
            'pw.nidn'
        ])
        ->where('us.username', $username_login) // Menggunakan username dari objek user
        ->first();
        
        // cek user 
		if ($user) {
			//if ($user && md5($password) === $user->password) 
			Auth::login($user); // Login melalui Laravel Auth
			// return response()->json(['message' => 'Login berhasil melalui MySQL']);
            return redirect('/home');
		}

        $roles = '2';
        $active = '1';
		// Jika tidak ditemukan di MySQL, cek di PostgreSQL
		$pgUser = Psgdbuser::where('username','=',$username_login)->first();
		//if ($pgUser && md5($password) === $pgUser->password) {
			if ($pgUser) {
			// Simpan data ke MySQL
		        $newUser = new Mysqluser(); 
                $newUser->username = $pgUser->username;
                $newUser->name= $getUsr->userdesc;
                $newUser->email= $getUsr->email;
                $newUser->role_id= $roles;
                $newUser->kodeunit= $getUsr->kodeunit;
                $newUser->namaunit= $getUsr->namaunit;
                $newUser->save();
                Auth::login($newUser); // Login melalui Laravel Auth
                return redirect('/home');

           
		}

		// return response()->json(['message' => 'Login gagal, username atau password salah'], 401);
        return redirect('/login');
	}


	/*public function login(Request $request)
	{
    // Validate user input
    $request->validate([
        'username' => 'required',  // Remove `username` validation rule
        'password' => 'required',
    ]);

    $username = $request->input('username');
    $password = $request->input('password');

    // Check if user exists in PostgreSQL
    $pgsqlUser = DB::connection('mitra')->table('gate.sc_user')->where('username', $username)->first();
    
    if ($pgsqlUser && password_verify($password, $pgsqlUser->password)) {
        // Check if the user already exists in MySQL
        $Mysqluser = User::where('username', $username)->first();
        
        if (!$Mysqluser) {
            // Create the user in MySQL if they don't exist
            User::create([
                'username' => $pgsqlUser->username,
                'password' => bcrypt($pgsqlUser->password),  // Encrypt password when storing in MySQL
            ]);
        }

        // Log in the user using Laravel's Auth
        if (Auth::attempt(['username' => $username, 'password' => $password])) {
            // Redirect to dashboard if login is successful
            return redirect()->route('dashboard');
        }
    }

    return back()->withErrors([
        'username' => 'The provided credentials do not match our records.',
    ]);
	}*/

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function dashboard()
    {
        return view('home');
    }
}