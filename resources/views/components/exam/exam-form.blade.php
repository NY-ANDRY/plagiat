<form action="{{ route('prof.exams.store') }}" method="POST" class="space-y-4">
    @csrf

    <div class="flex justify-between gap-8">

        <div class="w-xl">
            <label for="name">Name</label>
            <input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required
                autofocus />
        </div>


        <div class="w-xs">
            <label for="close_date">close date</label>
            <input id="close_date" name="close_date" type="date" class="mt-1 block w-full" :value="old('close_date')"
                required />
        </div>

    </div>

    <div class="flex flex-col gap-1">
        <label for="close_date">about</label>
        <textarea id="about" name="about" rows="8"
            class="block w-full border-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('about') }}</textarea>
    </div>

    <div class="flex flex-col gap-2">
        <label>extensions</label>
        <div class="flex gap-5">
            @foreach($extensions as $extension)
                <label for="ext-{{ $extension->id }}" class="flex items-center gap-2 cursor-pointer">
                    <input name="extensions[]" type="checkbox" id="ext-{{ $extension->id }}" value="{{ $extension->id }}"
                        checked="checked" class="checkbox rounded-none" />
                    <div>
                        <x-icon.file-extension :extension="$extension" />
                    </div>
                </label>
            @endforeach
        </div>
    </div>

    <div class="flex flex-col gap-2">
        <div class="flex items-center">
            <label>restrictions</label>
        </div>

        <div class="flex items-center gap-2 text-sm text-neutral-600">
            <p class="mr-2">value separator : </p>
            <div class="flex mr-1">"<span id="separator-value" class="flex">{{ $separator->value }}</span>"</div>
            <div onclick="copySeparator()" class="flex p-1 border b-f activable">
                <x-lucide-copy class="w-4 text-neutral-900" />
            </div>
            <p id="separator-copy-alert" class="text-neutral-800"></p>
            <script>
                function copySeparator() {
                    const separator_value = document.getElementById('separator-value');
                    navigator.clipboard.writeText(separator_value.innerText);
                    const copy_alert = document.getElementById('separator-copy-alert');
                    copy_alert.innerHTML = 'copy !!!';
                    setTimeout(() => {
                        copy_alert.innerHTML = '';
                    }, 2000);
                }
            </script>
        </div>

        <div class="flex flex-col gap-2">
            @foreach ($fileTypes as $key => $fileType)
                <div class="flex gap-2">
                    <x-icon.file-type :fileType="$fileType" />
                    <div class="flex flex-1">
                        <textarea name="restrictions-{{ $fileType->id }}" rows="3" id=""></textarea>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="flex items-center gap-4">
        <div class="flex w-48">
            <button>Create Exam</button>
        </div>

        @if (session('success'))
            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                class="text-sm text-green-600 dark:text-green-400">{{ session('success') }}</p>
        @endif
    </div>
</form>