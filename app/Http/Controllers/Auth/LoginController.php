<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Laravel\Passport\Client;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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

    Private $client;

    public function __construct()
    {
        $this->client = Client::find(2);
    }
	
	public function login(Request $request)
	{
		$this->validate($request,[
			'username' => 'required',
            'password' => 'required'
		]);
		
		$params =  [
			'grant_type' => 'password',
			'client_id' => $this->client->id,
			'client_secret' => $this->client->secret,
			'username' => request('username'),
			'password' => request('password'),
			'scope' => '*'
		];
		
		$request->request->add($params);
		
		$proxy = Request::create('oauth/token','POST');
		
		return Route::dispatch($proxy);
	}
	
	public function Refresh(Request $request)
	{
		$this->validate($request,[
			'refresh_token' => 'required'
		]);

		$params =  [
			'grant_type' => 'refresh_token',
			'client_id' => $this->client->id,
			'client_secret' => $this->client->secret,
			'username' => request('username'),
			'password' => request('password')
		];
		
		$request->request->add($params);
		
		$proxy = Request::create('oauth/token','POST');
		
		return Route::dispatch($proxy);
			
	}
	
	public function logout(Request $request)
	{
		$accessToken = Auth::user()->token();

		DB::table('oauth_refresh_tokens')
			->where('access_token_id',$accessToken->id)
			->update(['revoked'=>true]);

		$accessToken->revoke();

		return response()->json([],204);
		//return response()->json(['data' => 'User logged out.'], 200);
	}
}
