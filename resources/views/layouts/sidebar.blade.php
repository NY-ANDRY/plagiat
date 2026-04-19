<div class="flex flex-col w-64 gap-2 border-r border-neutral-200">
    <div class="flex items-center px-6 h-16">
        <span class="text-xl font-bold">{{ config('app.name', 'Plagiat') }}</span>
    </div>
    <div class="flex flex-col gap-0 flex-1">
        @foreach ($nav as $item)
            <a href="{{ $item['url'] }}"
                class="flex items-center px-6 py-3 text-sm activable text-neutral-600 capitalize">
                <x-dynamic-component :component="'lucide-' . $item['icon']" class="w-4 h-4 mr-3" />
                <span class="text-gray-700">{{ $item['label'] }}</span>
            </a>
        @endforeach
    </div>
    <div class="flex flex-col">
        <form action="{{ route('logout') }}" method="post">
            @csrf
            <button type="submit"
                class="flex items-center px-6 py-3 text-sm activable text-neutral-600 capitalize w-full text-left">
                <span class="text-gray-700">Logout</span>
            </button>
        </form>
    </div>
</div>
