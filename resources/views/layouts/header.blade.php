<header class="flex h-16 border-b border-neutral-200 items-center justify-between px-4">
    <div class="flex items-center gap-2">
        <div class="breadcrumbs text-sm">

        </div>
    </div>
    <div class="flex items-center gap-6 px-2 h-full">
        <div class="flex items-center gap-6">
            <x-lucide-message-circle class="w-5" />
            <x-lucide-bell class="w-5" />
        </div>

        <div class="flex w-px h-6 bg-neutral-200"></div>

        <div class="dropdown dropdown-end h-full">
            <div tabindex="0"
                class="cursor-pointer border-b-2 border-transparent hover:border-neutral-400 h-full flex items-center">
                <img src="{{ Auth::user()->imageUrl() }}" alt="{{ Auth::user()->name }}"
                    class="w-10 h-10 mask mask-decagon" />
            </div>
            <ul tabindex="0" class="menu dropdown-content mt-3 z-1 p-0 shadow bg-base-100 rounded-none w-68">
                <li><a href="{{ route('profile.edit') }}"
                        class="rounded-none h-12 flex items-center hover:bg-neutral-100 active:text-neutral-900 capitalize">profile
                    </a>
                </li>
                <li>
                    <details>
                        <summary
                            class="rounded-none h-12 flex items-center justify-between hover:bg-neutral-100 active:text-neutral-900 capitalize">
                            Roles</summary>
                        <ul>
                            @foreach (Auth::user()->roles as $role)
                                <li><a href="/{{ $role->name }}"
                                        class="rounded-none h-12 flex items-center hover:bg-neutral-100 active:text-neutral-900 capitalize">{{ $role->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </details>
                </li>
                <li>
                    <a href="{{ route('logout') }}"
                        class="justify-baseline rounded-none hover:bg-neutral-100! h-12 flex items-center">
                        Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>

</header>