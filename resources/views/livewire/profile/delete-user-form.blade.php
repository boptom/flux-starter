<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component
{
    public string $password = '';

    /**
     * Delete the currently authenticated user.
     */
    public function deleteUser(Logout $logout): void
    {
        $this->validate([
            'password' => ['required', 'string', 'current_password'],
        ]);

        tap(Auth::user(), $logout(...))->delete();

        $this->redirect('/', navigate: true);
    }
}; ?>

<div class="max-w-xl">
    <flux:heading size="lg">
        {{ __('Delete Account') }}
    </flux:heading>

    <flux:subheading>
        {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
    </flux:subheading>

    <div class="mt-6">
        <flux:modal.trigger name="confirm-user-deletion">
            <flux:button variant="danger">
                {{ __('Delete Account') }}
            </flux:button>
        </flux:modal.trigger>
    </div>

    <flux:modal name="confirm-user-deletion">
        <form wire:submit="deleteUser">
            <flux:heading size="lg">
                {{ __('Are you sure you want to delete your account?') }}
            </flux:heading>

            <flux:subheading class="mb-6">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </flux:subheading>

            <flux:input
                wire:model="password"
                :label="__('Password')"
                type="password"
                placeholder="{{ __('Password') }}"
            />

            <div class="mt-4 flex justify-end">
                <flux:modal.close>
                    <flux:button variant="ghost">
                        {{ __('Cancel') }}
                    </flux:button>
                </flux:modal.close>

                <flux:button type="submit" variant="danger" class="ms-3">
                    {{ __('Delete Account') }}
                </flux:button>
            </div>
        </form>
    </flux:modal>
</div>
