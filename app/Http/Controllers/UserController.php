<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\User;


class UserController extends Controller
{
    use ApiResponse;

    private $userField = ['id', 'username', 'email', 'name', 'password', 'role'];
    
    private $validRole = ['admin', 'normal'];

    public function index(Request $request)
    {
        $id = $request->id;
        try {
            $users = User::get();             
            $msg = "Found user data";
            if (count($users) < 1) {
                $msg = "User data is empty";
            }
            return $this->successResponse($users, $msg, 200);            
        } catch(\Illuminate\Database\QueryException $e){                                 
            return $this->errorResponse(null, $e->getMessage(), 500);       
        } catch (Exception $e) {
            return $this->errorResponse(null, $e->getMessage(), 400);       
        }
    }

    public function login(Request $request)
    {   
        $email = $request->input('email');
        $pass = $request->input('password');
        $errorMsg = null;
        $code = 400;
        try {
            $user = User::where('email', '=', $email)->first();  
                      
            if ($user == null) {
                return $this->errorResponse(null, 'Email not found', 404);                           
            } else if (!password_verify($pass, $user->password)) {
                return $this->errorResponse(null, 'Wrong password', 401);                                               
            } else {                                
                $msg = "Success";
                return $this->successResponse($user, $msg, 200);
            }
        } catch(\Illuminate\Database\QueryException $e){                                 
            $errorMsg = $e->getMessage();
            $code = 500;   
        } catch (Exception $e) {
            $errorMsg = $e->getMessage();
        }
        return $this->errorResponse(null, $errorMsg, $code);       
    }

    public function register(Request $request)
    {
        $errorMsg = null;
        $code = 400;

        try {
            $data = $request->all();
            
            if (!isValidJsonFields($data, $this->userField)) {
                return $this->errorResponse(null, 'Invalid JSON Field', 412);            
            }
            
            $name = $data['name'];
            $username = $data['username'];
            $email = $data['email'];
            $password = $data['password'];
            $role = $data['role'];
                        
            if (!is_null($password) && strlen($password) < 6) {
                return $this->errorResponse(null, 'Password must be at least 6 characters', 400);                            
            } else if (!in_array($role, $this->validRole)){
                return $this->errorResponse(null, 'Invalid role', 400);                                            
            }

            $user = User::where('email', '=', $email)
                        ->orWhere('username', '=', $username)
                        ->first(); 
            
            if ($user) {
                return $this->errorResponse(null, 'Username or email already registered', 400);                                            
            }
            
            $user = new User();
            $user->name = $name;
            $user->username = $username;
            $user->email = $email;
            $user->password = bcrypt($password);  
            $user->role = $role;  

            $save = $user->save();

            if ($save) {
                return $this->successResponse(null, 'Successful registration ', 201);                
            } else {
                return $this->errorResponse(null, 'Failed, please try again', 400);                        
            }

        } catch (QueryException $e){
            $errorMsg = $e->getMessage();
            $code = 500;                       
        } catch (Exception $e) {
            $errorMsg = $e->getMessage();                                  
        }          

        return $this->errorResponse(null, $errorMsg, $code);       
    }
}
