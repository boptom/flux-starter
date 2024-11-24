<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <flux:heading size="xl" class="mb-6">
        {{ __('Sign in to your account') }}
    </flux:heading>

    <form wire:submit="login" class="space-y-6">
        <!-- Email Address -->
        <flux:input
            wire:model="form.email"
            label="Email"
            icon-trailing="envelope"
            style="font-size: 16px"
            required
        />

        <!-- Password -->
        <flux:field>
            <div class="mb-3 flex justify-between">
                <flux:label>Password</flux:label>

                @if (Route::has('password.request'))
                    <flux:link
                        href="{{ route('password.request') }}"
                        variant="subtle"
                        class="text-sm"
                    >
                        Forgot password?
                    </flux:link>
                @endif
            </div>

            <flux:input
                wire:model="form.password"
                type="password"
                style="font-size: 16px"
                viewable
                required
            />

            <flux:error name="password" />
        </flux:field>

        <!-- Remember Me -->
        <flux:checkbox
            id="remember"
            wire:model="form.remember"
            :label="__('Remember me on this device')"
        />

        <div class="space-y-2">
            <flux:button variant="primary" class="w-full">
                {{ __('Sign in') }}
            </flux:button>

            <flux:button
                href="{{ route('register') }}"
                variant="ghost"
                class="w-full"
            >
                {{ __('Sign up for a new account') }}
            </flux:button>
        </div>
    </form>
</div>
