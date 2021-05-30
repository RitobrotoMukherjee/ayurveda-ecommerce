<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\BaseController;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Auth;
use Validator;
use Hash;
use App\Models\Customer;

class AuthenticationController extends BaseController
{
    use AuthenticatesUsers;
    
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/customer-dashboard';
    
    public function __construct()
    {
        Parent::__construct();
    }
    
    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('website.login', ['data' => $this->data]);
    }
    
    /**
     * Show the application registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        return view('website.register', ['data' => $this->data]);
    }
    
    public function register(Request $request){
        $input = $request->only('name','email','mobile', 'password','password_confirmation');
        $validator = $this->validator($input);
        if($validator->passes()){
            $customer = $this->createCustomer($input);
                    
            event(new Registered($customer));
            
            $this->guard()->login($customer);
            if ($response = $this->registered($request, $customer)) {
                return $response;
            }
            
        }
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        return redirect()->back()->withErrors("OOPs - Internal server error, please contact support team");
    }
    
    /**
     * The user has been authenticated.
     * Over ridding trait guard method to use custom guard
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        return redirect()->route('customer.dashboard')->with('status', $user->name .' Successfully logged in ');
    }
    
    /**
     * 
     * Custom login code
     * 
     **/
//    public function login(Request $request) {
//        $input = $request->only('email', 'password');
//        
//        if (Auth::guard('customer')->attempt($input, $request->remember)) {
//            $customer = Customer::where('email', $request->email)->first();
//            Auth::guard('customer')->login($customer);
//            return redirect()->route('customer.dashboard')->with('status', 'Successfully logged in '.$request->email);;
//        }
//        
//        return redirect()->route('customer.login')->with('error', 'Wrong Username/Password ');
//    }
    
    
    /**
     * Log the user out of the application.
     * Over ridding trait guard method to use custom guard
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/');
    }
    /**
     * The user has logged out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    protected function loggedOut(Request $request)
    {
        return redirect()->route('home')->with('status', 'Successfully logged out ');
    }
    
    
    /**
     * Get the guard to be used during authentication.
     *  Over ridding trait guard method to use custom guard
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:customers'],
            'mobile' =>['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10', 'unique:customers'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }
    
    /**
     * The user has been registered.
     * Over ridding trait guard method to use custom guard
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        return redirect()->route('customer.dashboard')->with('status', $request->name.' successfully registered. Please verify your email id');
    }
    
    private function createCustomer($input){
        return Customer::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'mobile' => $input['mobile'],
                'mobile_verified_at' => now(),
                'password' => Hash::make($input['password']),
            ]);
    }
    
    protected function guard()
    {
        return Auth::guard('customer');
    }
}
