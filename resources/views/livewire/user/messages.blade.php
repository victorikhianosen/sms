<div class="flex flex-col bg-white rounded-lg pt-8 mt-8 px-6 space-y-2 mb-24 pb-8">
    <div class="flex justify-between items-center">
        <h3 class="font-bold text-2xl">Messages</h3>
        <input type="text" wire:model.live.debounce.500ms="search"
            placeholder="Search by Message ID, Phone, status, Date "
            class="px-4 py-2 border rounded-md bg-gray-100 text-gray-600 w-64 placeholder:text-xs">
    </div>
    <div class="-m-1.5 overflow-x-auto">
        <div class="p-1.5 min-w-full inline-block align-middle">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 table-fixed">
                    <thead>
                        <tr class="bg-blue text-white">
                            <th scope="col" class="px-4 py-3 text-start text-xs font-semibold uppercase w-28">
                                Message ID</th>
                            <th scope="col" class="px-4 py-3 text-start text-xs font-semibold uppercase w-40">
                                Title</th>
                            <th scope="col" class="px-4 py-3 text-start text-xs font-semibold uppercase w-40">
                                Destination</th>
                            <th scope="col" class="px-4 py-3 text-start text-xs font-semibold uppercase w-60">
                                Message</th>

                            <th scope="col" class="px-4 py-3 text-start text-xs font-semibold uppercase w-12">
                                Amount</th>
                            <th scope="col" class="px-4 py-3 text-start text-xs font-semibold uppercase w-24">
                                Status</th>
                            <th scope="col" class="px-4 py-3 text-start text-xs font-semibold uppercase w-60">
                                Date</th>

                            <th scope="col" class="px-4 py-3 text-start text-xs font-semibold uppercase">
                                Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($allMessage as $item)
                            <tr class="odd:bg-white even:bg-gray-100">
                                <td class="px-4 py-4 whitespace-normal text-sm font-medium text-gray">
                                    {{ substr($item->message_reference, 0, 8) }}
                                </td>
                                <td class="px-4 py-4 whitespace-normal text-sm text-gray">{{ $item->sender }}</td>
                                <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                    {{ $item->destination }}
                                </td>
                            
                                <td class="px-4 py-4 whitespace-normal text-sm">
                                    {{ Str::limit($item->message, 20) }}
                                </td>

                                </td>

                                {{-- <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                    {{ $item->page_rate }}
                                </td> --}}

                                <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                    {{ $item->amount }}
                                </td>

                                <td
                                    class="px-4 py-4 whitespace-normal text-sm 
                                    @if ($item->status == 'sent') text-green-600 
                                    @elseif($item->status == 'failed') text-red-600 
                                    @elseif($item->status == 'pending') text-yellow-600 
                                    @elseif($item->status == 'cancel') text-gray-600 
                                    @else text-gray-600 @endif">
                                    {{ ucfirst($item->status) }}
                                </td>

                                <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                    {{ $item->created_at->format('d M Y, h:i A') }}
                                </td>
                                <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                    <span class="bg-blue py-2 px-2 text-white rounded-lg cursor-pointer"
                                        wire:click="showMessage({{ $item->id }})">
                                        View
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-4 py-4 text-center text-sm text-gray">
                                    No recent Messages
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pagination Controls -->
                <div class="mt-4 py-8">
                    {{ $allMessage->links() }}
                </div>

            </div>
        </div>
    </div>


    @if ($viewModal)
        <div" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">

            <div class="bg-white rounded-xl shadow-2xl w-full max-w-2xl p-8 relative">
                <!-- Close Button (Top Right) -->
                <button wire:click.prevent="closeModal"
                    class="absolute top-3 right-3 text-gray-500 hover:text-red-600 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <!-- Modal Header -->
                <h3 class="text-2xl font-semibold text-gray-900 border-b pb-3">Message Details</h3>

                <!-- Modal Body -->
                <div class="mt-4 grid grid-cols-2 gap-4 text-gray-700">
                    <div>
                        <label class="font-medium text-gray-700">Message ID</label>
                        <input type="text" class="w-full px-3 py-2 border rounded-md bg-gray-100 text-gray-600"
                            value="{{ $selectedMessage->message_reference }}" readonly>
                    </div>

                    <div>
                        <label class="font-medium text-gray-700">Sender</label>
                        <input type="text" class="w-full px-3 py-2 border rounded-md bg-gray-100 text-gray-600"
                            value="{{ $selectedMessage->sender }}" readonly>
                    </div>

                    <div>
                        <label class="font-medium text-gray-700">Destination</label>
                        <input type="text" class="w-full px-3 py-2 border rounded-md bg-gray-100 text-gray-600"
                            value="{{ $selectedMessage->destination }}" readonly>
                    </div>

                    <div>
                        <label class="font-medium text-gray-700">Status</label>
                        <input type="text" class="w-full px-3 py-2 border rounded-md bg-gray-100 text-gray-600"
                            value="{{ $selectedMessage->status }}" readonly>
                    </div>

                    <div>
                        <label class="font-medium text-gray-700">Amount</label>
                        <input type="text" class="w-full px-3 py-2 border rounded-md bg-gray-100 text-gray-600"
                            value="{{ $selectedMessage->amount }}" readonly>
                    </div>

                    <div>
                        <label class="font-medium text-gray-700">Date</label>
                        <input type="text" class="w-full px-3 py-2 border rounded-md bg-gray-100 text-gray-600"
                            value="{{ $selectedMessage->created_at->format('d M Y, h:i A') }}" readonly>
                    </div>
                </div>

                <!-- Full Width Message Textarea -->
                <div class="mt-4">
                    <label class="font-medium text-gray-700">Message</label>
                    <textarea class="w-full px-3 py-2 border rounded-md bg-gray-100 text-gray-600 h-32 resize-none" readonly>{{ $selectedMessage->message }}</textarea>
                </div>


            </div>
</div>
@endif


</div>
