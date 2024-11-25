<x-app-layout>
    <flux:tab.group>
        <flux:tabs wire:model="tab">
            <flux:tab name="update-profile">Profile</flux:tab>
            <flux:tab name="update-password">Password</flux:tab>
            <flux:tab name="delete-user">Delete Account</flux:tab>
        </flux:tabs>
        <flux:tab.panel name="update-profile">
            <livewire:profile.update-profile-information-form />
        </flux:tab.panel>
        <flux:tab.panel name="update-password">
            <livewire:profile.update-password-form />
        </flux:tab.panel>
        <flux:tab.panel name="delete-user">
            <livewire:profile.delete-user-form />
        </flux:tab.panel>
    </flux:tab.group>
</x-app-layout>
