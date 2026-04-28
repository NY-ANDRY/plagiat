<x-layout.app>
    <div class="flex-1 flex w-full min-h-full justify-center">

        <div class="b-l b-r w-332 flex flex-col">

            <header class="w-full b-b flex items-center justify-between">
                <div class="flex items-center">
                    <div class="box text-2xl font-black tracking-wide">Plagiat</div>
                </div>
                @if (Route::has('login'))
                    <nav class="flex items-center justify-end h-full">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="box b-l activable h-full flex items-center justify-center">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="box b-l activable h-full flex items-center justify-center">
                                Log in
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="box b-l activable h-full flex items-center justify-center">
                                    Register
                                </a>
                            @endif
                        @endauth
                    </nav>
                @endif
            </header>

            <div class="flex-1 flex flex-col justify-between">

                <div class="flex-1 flex flex-col justify-between w-full py-4 px-6">

                    <div class="flex-1 flex justify-between">
                        <div class="flex flex-col items-center justify-center w-full gap-8">
                            <h1 class="text-6xl tracking-tight">Plagiat</h1>
                            <div class="flex flex-col gap-3">
                                <div class="text-neutral-400 font-light text-sm text-center w-xl">Lorem ipsum dolor sit amet consectetur adipisicing elit. Saepe, placeat. Voluptatem minus non veritatis esse dolore!</div>
                            </div>
                        </div>

                    </div>

                    <div class="flex flex-col">

                        <div class="flex text-sm text-neutral-300 mb-1">download here</div>

                        <div class="flex items-center justify-between pt-4 pb-8">
                            <div class="flex flex-col gap-2">
                                <div class="flex mono">direct link</div>

                                <div
                                    class="font-light w-152 px-4 py-3 h-16 flex items-center justify-between text-white border border-neutral-200 bg-orange-500 hover:bg-orange-600 active:bg-orange-700 transition-all rounded-sm cursor-pointer">
                                    <span>
                                        download project
                                    </span>
                                    <span>
                                        <x-lucide-download class="text-white w-4" />
                                    </span>
                                </div>
                            </div>

                            <div class="flex flex-col gap-2">
                                <div class="flex mono">the developer way </div>

                                <div
                                    class="relative lilex flex items-center justify-between rounded-sm gap-3 px-4 py-3 w-152 h-16 text-sm bg-neutral-800 text-neutral-100">
                                    <div class="flex items-center gap-3">
                                        <span style="user-select:none;-webkit-user-select:none;">$</span>
                                        <code id="github_link"> git clone https://github.com/NY-ANDRY/plagiat</code>
                                    </div>

                                    <div class="flex items-center gap-3">
                                        <p id="copy-alert" class=""></p>
                                        <span
                                            class="cursor-pointer flex items-center gap-3 p-2 hover:bg-neutral-900 rounded-sm"
                                            onclick="copyGithubLink()">
                                            <x-lucide-copy class="text-white w-4" />
                                        </span>
                                    </div>

                                    <script>
                                        function copyGithubLink() {
                                            const github_link = document.getElementById('github_link');
                                            navigator.clipboard.writeText(github_link.innerText);
                                            const copy_alert = document.getElementById('copy-alert');
                                            copy_alert.innerHTML = 'copied';
                                            setTimeout(() => {
                                                copy_alert.innerHTML = '';
                                            }, 2000);
                                        }
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="b-t flex items-center justify-between px-6 h-48">
                    hello
                </div>
            </div>
        </div>

    </div>
</x-layout.app>