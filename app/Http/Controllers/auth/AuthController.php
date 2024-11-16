<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    //
    public function login(Request $request){
        try {
            $request->validate([
                "email" => "required|email",
                "password" => "required|min:6",
            ]);

            $client = new Client();
            $url = 'http://127.0.0.1:8100/api/auth/login';
            $response = $client->request('POST', $url, [
                'form_params' => [ 
                    'email' => $request->email,
                    'password' => $request->password,
                ],
                'headers' => [
                    'Accept' => 'application/json', // Pastikan menerima respons JSON
                ],
            ]);
            if(!$response){
                return back()->withErrors(['error' => 'Email Atau Password salah!']);
            }
            $responseBody = json_decode($response->getBody(), true);
           // Periksa jika respons berhasil
            if (!isset($responseBody['token_']) || !isset($responseBody['data'])) {
                return back()->withErrors(['error' => 'Invalid API response']);
            }
            Session::put('token', $responseBody["token_"]);
            Session::put('user_data', $responseBody["data"]);
 
            return redirect()->route('dashboard');
        } catch (\Exception $e) {
            // Tangani error (misalnya koneksi gagal atau status tidak 200)
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function signup(Request $request){
        try {
            $request->validate([
                "email" => "required|email",
                "password" => "required|min:6",
                "address" => "required",
                "name" => "required",
                "password_confirmation" => "required|min:6",
            ]);

            $client = new Client();
            $url = 'http://127.0.0.1:8100/api/auth/register';
            $response = $client->request('POST', $url, [
                'form_params' => [ 
                    'email' => $request->email,
                    'name' => $request->name,
                    'password' => $request->password,
                    'address' => $request->address,
                    'password_confirmation' => $request->password_confirmation,
                ],
                'headers' => [
                    'Accept' => 'application/json', // Pastikan menerima respons JSON
                ],
            ]);
            if(!$response){
                return back()->withErrors(['error' => 'Gagal Registrasi Admin']);
            }
 
            return redirect()->route('login');
        } catch (\Exception $e) {
            // Tangani error (misalnya koneksi gagal atau status tidak 200)
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function logout()
    {
        // Hapus semua session
        Session::flush();

        // Redirect ke halaman login
        return redirect()->route('login')->with('success', 'You have successfully logged out.');
    }
}
