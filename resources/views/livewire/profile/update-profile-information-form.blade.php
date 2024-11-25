<?php

use App\Models\User;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component
{
    public string $name = '';

    public string $email = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);

        Flux::toast('Your changes have been saved.', variant: 'success');
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function sendVerification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<div class="max-w-xl">
    <flux:heading size="lg">
        {{ __('Profile Information') }}
    </flux:heading>

    <flux:subheading>
        {{ __("Update your account's profile information and email address.") }}
    </flux:subheading>

    <form wire:submit="updateProfileInformation" class="mt-6 space-y-6">
        <flux:input
            wire:model="name"
            :label="__('Name')"
            required
            autofocus
            autocomplete="name"
        />

        <div>
            <flux:input
                wire:model="email"
                :label="__('Email')"
                id="email"
                name="email"
                type="email"
                required
                autocomplete="username"
            />

            @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                <div>
                    <p class="text mt-2 text-sm">
                        {{ __('Your email address is unverified.') }}

                        <button
                            wire:click.prevent="sendVerification"
                            class="underline hover:text-zinc-900 dark:hover:text-zinc-100"
                        >
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p
                            class="mt-2 text-sm font-medium text-green-600 dark:text-green-400"
                        >
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <flux:button type="submit" variant="primary">
            {{ __('Save') }}
        </flux:button>
    </form>
</div>
