<x-guest-layout>
<div class="flex justify-center">
  <div class="flex flex-wrap w-full">
    <div class="w-full sm:w-5/12 md:w-5/12 lg:w-5/12 xl:w-5/12">
      <img src="{{asset('loginAssets/images/backgoundImage.svg')}}" class="w-full object-cover" alt="Icon"/>
    </div>
    <div class="w-full sm:w-7/12 md:w-7/12 lg:w-7/12 xl:w-7/12 flex items-center justify-center p-8">
    <div class="bg-white px-4 flex-1">
                    <x-authentication-card>
                        <x-slot name="logo">
                        </x-slot>

                        <x-validation-errors class="mb-4" />

                        @if (session('status'))
                        <div class="mb-4 font-medium text-sm text-green-600">
                            {{ session('status') }}
                        </div>
                        @endif
                        <div class="text-left mb-4">
                            <span class="text-gray-900 text-4xl font-black font-poppins_black">Bonjour !</span>
                            <br>
                        </div>
                        <div class="text-left mb-4">
                            <span class="text-gray-600 text-xl font-black font-poppins_black">Connectez-vous</span>
                            <br>
                        </div>

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div>
                                <x-label for="email" value="{{ __('Email') }}" />
                                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                                
                            </div>

                            <div class="mt-4">
                                <x-label for="password" value="{{ __('Mot de passe') }}" />
                                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                            </div>

                            <div class="flex items-center justify-between mt-4">
                                <div class="block">
                                    <label for="remember_me" class="flex items-center">
                                        <x-checkbox id="remember_me" name="remember" />
                                        <span class="ml-2 text-sm text-gray-600">{{ __('Se rappeler de moi') }}</span>
                                    </label>
                                </div>

                                <div class="block">
                                    @if (Route::has('password.request'))
                                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                                        {{ __('Mot de passe oublié?') }}
                                    </a>
                                    @endif
                                </div>
                            </div>
                            <div class="mt-6">
                                <button type="submit" class="bg-first-orange text-white font-bold py-3 px-4 rounded-md w-full text-sm">
                                    Se connecter
                                </button>
                            </div>
                        </form>
                    </x-authentication-card>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>

</x-guest-layout>
