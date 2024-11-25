<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net" />
        <link
            href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap"
            rel="stylesheet"
        />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @fluxStyles
    </head>
    <body class="min-h-screen">
        <flux:sidebar
            sticky
            stashable
            class="border-r border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900"
        >
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <flux:brand
                href="/"
                logo="https://fluxui.dev/img/demo/logo.png"
                :name="config('app.name')"
                class="px-2 dark:hidden"
            />
            <flux:brand
                href="/"
                logo="https://fluxui.dev/img/demo/dark-mode-logo.png"
                name="Flux AI"
                class="hidden px-2 dark:flex"
            />

            <flux:input
                as="button"
                variant="filled"
                placeholder="Search..."
                icon="magnifying-glass"
            />

            <flux:navlist variant="outline"></flux:navlist>

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile name="{{ Auth::user()->name }}" />

                <flux:navmenu>
                    <flux:navmenu.item
                        href="{{ route('profile') }}"
                        icon="user-circle"
                    >
                        Profile
                    </flux:navmenu.item>

                    <flux:menu.separator />

                    @volt
                        <flux:navmenu.item
                            wire:click="logout"
                            icon="arrow-right-start-on-rectangle"
                        >
                            Logout
                        </flux:navmenu.item>
                    @endvolt
                </flux:navmenu>
            </flux:dropdown>
        </flux:sidebar>

        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />
        </flux:header>

        <!-- Page Content -->
        <flux:main>
            {{ $slot }}
        </flux:main>

        @persist('toast')
            <flux:toast />
        @endpersist

        @fluxScripts
    </body>
</html>
