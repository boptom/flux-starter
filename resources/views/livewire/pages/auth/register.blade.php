<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';

    public string $email = '';

    public string $password = '';

    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <flux:heading size="xl" class="mb-6">
        {{ __('Create your account') }}
    </flux:heading>

    <form wire:submit="register" class="space-y-6">
        <!-- Name -->
        <flux:input
            wire:model="name"
            :label="__('Name')"
            style="font-size: 16px"
            required
            autofocus
            autocomplete="name"
        />

        <!-- Email Address -->
        <flux:input
            wire:model="email"
            :label="__('Email')"
            style="font-size: 16px"
            type="email"
            name="email"
            required
            autocomplete="username"
        />

        <!-- Password -->
        <flux:input
            wire:model="password"
            :label="__('Password')"
            style="font-size: 16px"
            type="password"
            name="password"
            required
            viewable
            autocomplete="new-password"
        />

        <!-- Confirm Password -->
        <flux:input
            wire:model="password_confirmation"
            :label="__('Confirm Password')"
            style="font-size: 16px"
            type="password"
            name="password_confirmation"
            required
            viewable
            autocomplete="new-password"
        />

        <div class="space-y-2">
            <flux:button type="submit" variant="primary" class="w-full">
                {{ __('Register') }}
            </flux:button>

            <flux:button
                href="{{ route('login') }}"
                variant="ghost"
                class="w-full"
                wire:navigate
            >
                {{ __('Already registered?') }}
            </flux:button>
        </div>
    </form>
</div>
