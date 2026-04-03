<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;
use App\Models\User;
use App\Services\ForumService;
use Illuminate\Support\Facades\Hash;



class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        
    Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
        
        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });
Fortify::authenticateUsing(function (Request $request) {

    $login = $request->input('email'); // ⚠️ important
    $password = $request->password;

    // EMAIL
    if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
        $user = User::where('email', $login)->first();
    } 
    // MATRICULE
    else {
        $user = User::join('inscriptions', 'inscriptions.id', '=', 'users.inscription_id')
                    ->join('apprenants', 'apprenants.id', '=', 'inscriptions.apprenant_id')
                    ->where('apprenants.matricule', $login)
                    ->select('users.*')
                    ->first();
    }

    if ($user && $user->is_active && Hash::check($password, $user->password)) {
        return User::find($user->id); // 🔑 IMPORTANT
    }

    return null;
});
        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        $this->app->singleton(\Laravel\Fortify\Contracts\LoginResponse::class, \App\Actions\Fortify\CustomLoginResponse::class);

    }
}
