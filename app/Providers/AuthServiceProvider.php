<?php

namespace App\Providers; use Illuminate\Support\ServiceProvider; use Illuminate\Support\Facades\URL;

use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServProvider;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use App\Http\Controllers\AuthController;


class AuthServiceProvider extends ServProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        VerifyEmail::toMailUsing(function ($notifiable, $url) {
            // $spaUrl = "http://spa.test?email_verify_url=".$url;

            // $frontendUrl = 'localhost:3000/setup-account?exampleURLparam=';

            // $verifyUrl = URL::temporarySignedRoute(
            //     'verification.verify',
            //     Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            //     [
            //         'id' => $notifiable->getKey(),
            //         'hash' => sha1($notifiable->getEmailForVerification()),
            //     ]
            // );

            return (new MailMessage)
                ->subject('Verify Email Address')
                ->line('Click the button below to verify your email address.')
                ->action('Verify Email Address', $url);

            // return $frontendUrl . '?verify_url=' . urlencode($verifyUrl);
        });

    }
}
