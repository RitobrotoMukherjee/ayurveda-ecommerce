<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Password;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class CustomerForgotPasswordController extends BaseController
{
    use SendsPasswordResetEmails;
    
    public function __construct() {
        parent::__construct();
    }
    
    
    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\View\View
     */
    public function showLinkRequestForm()
    {
        return view('website.passwords.email', ['data' => $this->data]);
    }
    
    /**
     * Get the broker to be used during password reset.
     * Override Trait broker
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker()
    {
        return Password::broker('customers');
    }
}
