<div wire:poll.1000ms>
    <div class="pt-4 pb-10 px-6 flex justify-between items-center">
        <h3 class="font-bold text-2xl">All Schedules</h3>
        <a href="{{ route('schedule') }}" wire:navigate.hover
            class="mt-6 px-5 py-2.5 rounded-lg text-white text-xs tracking-wider font-medium border-none outline-none bg-blue hover:opacity-90">
            Add Schedule
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">


        @if ($allSchedule->isEmpty())
            <p class="text-center text-gray-500 text-sm">No scheduled messages yet.</p>
        @else
            @foreach ($allSchedule as $item)
                @php
                    $statusColor = match ($item['status']) {
                        'pending' => 'bg-yellow-500',
                        'sent' => 'bg-green-500',
                        'failed' => 'bg-red-500',
                        default => 'bg-gray-500',
                    };
                @endphp
                <div class="relative p-6 text-center shadow-sm bg-white space-y-3 rounded-lg">
                    <h3 class="text-lg font-medium">{{ $item['description'] }}</h3>
                    <p class="text-textPrimary font-light text-sm leading-relaxed"></p>
                    <div class="pt-3 flex justify-center items-center gap-2">
                        {{-- <a href="#"
                            class="mt-6 px-5 py-2 block w-full rounded-lg text-white text-xs tracking-wider font-light border-none outline-none bg-blue hover:opacity-90">
                            View
                        </a> --}}
                        <button type="button" wire:click.prevent="cancelSchedule({{ $item['id'] }})"
                            class="mt-6 px-5 py-2 w-full rounded-lg text-white text-xs tracking-wider font-light border-none outline-none bg-red-600 hover:opacity-90">Cancel</button>
                    </div>
                    <span
                        class="block absolute top-0 right-4 {{ $statusColor }} text-white py-1 px-2 rounded-lg text-[12px]">
                        {{ $item['status'] }}
                    </span>
                </div>
            @endforeach
        @endif


    </div>

      <div class="mt-12">
        {{ $allSchedule->links() }}
    </div>


</div>
