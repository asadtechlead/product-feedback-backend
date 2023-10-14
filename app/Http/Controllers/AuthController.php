<?php


namespace App\Http\Controllers;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string',
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
            'status' => true,
            'message' => 'User Created Successfully'
        ];

        return $this->sendJson($response, true);
    }

    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|email|string',
            'password' => 'required|string',
        ]);
        $user = User::where('email', $fields['email'])->first();

        if(!$user || !Hash::check($fields['password'], $user->password)){
            return response([
                'message' => 'Bad Credentials',
            ], 401);
        }
        else
        {
            $token = $user->createToken('myapptoken')->plainTextToken;

            $response = [
                'user' => $user,
                'token' => $token,
                'message' => 'Logged In Successfully',
                'status' => true
            ];

            return $this->sendJson($response, true);
        }
    }

    public function logout() {
        auth()->user()->tokens()->delete();
        return $this->sendJson(['message' => "You are Logged out now!"], true);
    }

    public function commentSetting(Request $request) {
        $commentSetting = Setting::where('name', 'commentState')->first();
        if(!$commentSetting){
            $commentSetting = new Setting();
            $commentSetting->name = 'commentState';
        }
        if($request->state === "Enabled"){
            $commentSetting->value = "Enabled";
        }
        else{
            $commentSetting->value = "Disabled";
        }
        $commentSetting->save();
        return $this->sendJson(['message' => "Comments Settings updated successfully", "commentState"=>$commentSetting->value], true);
    }
}
