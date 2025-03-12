<div class="flex flex-col bg-white rounded-lg pt-8 mt-8 px-6 space-y-2">
    <div class="flex justify-between items-center">
        <h3 class="font-bold text-2xl">Schedule Message</h3>
    </div>

    <div class="-m-1.5 overflow-x-auto">
        <div class="p-1.5 min-w-full inline-block align-middle">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 table-fixed">
                    <thead>
                        <tr class="bg-blue text-white">
                            <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-40">User</th>
                            <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-60">Sender</th>
                            <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-40">Destination</th>
                            <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-40">Amount</th>
                            <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-40">Status</th>
                            <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-60">Date</th>

                            @adminOrSuperAdmin
                                <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-40">Action</th>
                            @endadminOrSuperAdmin
                        </tr>
                    </thead>

                    <tbody>
                        @if ($allSchedule && $allSchedule->isEmpty())
                            <tr>
                                <td colspan="7" class="text-center py-4 text-gray-600">No Payment Found</td>
                            </tr>
                        @else
                            @foreach ($allSchedule ?? [] as $schedule)
                                <tr>
                                    <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                        {{ $schedule->user->email }}
                                    </td>
                                    <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                        {{ $schedule->sender }}
                                    </td>
                                    <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                        {{ is_string($schedule->destination) ? count(json_decode($schedule->destination, true)) : (is_array($schedule->destination) ? count($schedule->destination) : 0) }}
                                    </td>

                                    <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                        {{ $schedule->amount }}
                                    </td>
                                    <td
                                        class="px-4 py-4 whitespace-normal text-sm 
                                        @if ($schedule->status == 'sent') text-green-600 
                                        @elseif($schedule->status == 'failed') text-red-600 
                                        @elseif($schedule->status == 'pending') text-yellow-600 
                                        @elseif($schedule->status == 'cancel') text-gray-600 
                                        @else text-gray-600 @endif">
                                        {{ ucfirst($schedule->status) }}
                                    </td>

                                    <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                        {{ $schedule->created_at }}
                                    </td>

                                    @adminOrSuperAdmin
                                        <td class="px-4 py-4 whitespace-normal flex items-center gap-2">
                                            <button type="button" wire:click.prevent="viewSchedule({{ $schedule->id }})"
                                                class="bg-green-600 py-2 px-2 text-sm text-white rounded-lg cursor-pointer">
                                                View
                                            </button>

                                            @if ($schedule->status !== 'sent' && $schedule->status !== 'cancel')
                                                @if ($schedule->status !== 'pending')
                                                    <button type="button"
                                                        wire:click.prevent="PendSchedule({{ $schedule->id }})"
                                                        class="bg-blue py-2 px-2 text-sm text-white rounded-lg cursor-pointer">
                                                        Pending
                                                    </button>
                                                @endif

                                                <button type="button"
                                                    wire:click.prevent="CancelSchedule({{ $schedule->id }})"
                                                    class="bg-red-600 py-2 px-2 text-sm text-white rounded-lg cursor-pointer">
                                                    Cancel
                                                </button>
                                            @endif
                                        </td>
                                    @endadminOrSuperAdmin
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>

            <div class="py-8">
                {{ $allSchedule->links() }}
            </div>
        </div>
    </div>


    @if ($showModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 px-4">
            <div
                class="bg-white p-6 sm:p-8 rounded-lg shadow-lg w-screen sm:w-[600px] lg:w-[600px] xl:w-[1000px] max-w-6xl">
                <div class="flex justify-between items-center border-b-2 border-softGray pb-4">
                    <h3 class="text-2xl font-bold">Schedule Message Details</h3>
                    <button class="text-black text-2xl" wire:click="closeModal">
                        <i class="fas fa-times hover:text-red-600"></i>
                    </button>
                </div>
                <form class="mt-4 text-gray-700 space-y-6 pt-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Email -->
                        <div>
                            <label class="font-medium text-gray-700">Email</label>
                            <input type="text" value="{{ $email }}"
                                class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600" readonly>
                        </div>
                        <!-- Sender -->
                        <div>
                            <label class="font-medium text-gray-700">Sender</label>
                            <input type="text" value="{{ $sender }}"
                                class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600" readonly>
                        </div>
                        <!-- Description -->
                        <div>
                            <label class="font-medium text-gray-700">Description</label>
                            <input type="text" value="{{ $description }}"
                                class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600" readonly>
                        </div>
                        <!-- Page Number -->
                        <div>
                            <label class="font-medium text-gray-700">Page Number</label>
                            <input type="text" value="{{ $page_number }}"
                                class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600" readonly>
                        </div>
                        <!-- Page Rate -->
                        <div>
                            <label class="font-medium text-gray-700">Page Rate</label>
                            <input type="text" value="{{ $page_rate }}"
                                class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600" readonly>
                        </div>
                        <!-- Message -->
                        <div>
                            <label class="font-medium text-gray-700">Message</label>
                            <input type="text" value="{{ $message }}"
                                class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600" readonly>
                        </div>
                        <!-- Status -->
                        <div>
                            <label class="font-medium text-gray-700">Status</label>
                            <input type="text" value="{{ $status }}"
                                class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600" readonly>
                        </div>
                        <!-- Amount -->
                        <div>
                            <label class="font-medium text-gray-700">Amount</label>
                            <input type="text" value="{{ $amount }}"
                                class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600" readonly>
                        </div>
                        <!-- Destination Count -->


                        <div>
                            <label class="font-medium text-gray-700">Destination Count</label>
                            <input type="text"
                                value="{{ $destination ? count(array_filter(explode(', ', $destination))) : 0 }}"
                                class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600" readonly>
                        </div>




                        <div>
                            <label class="font-medium text-gray-700">Route</label>
                            <input type="text" value="{{ $route }}"
                                class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600" readonly>
                        </div>
                        <!-- Scheduled Time -->
                        <div>
                            <label class="font-medium text-gray-700">Scheduled Time</label>
                            <input type="text" value="{{ $scheduled_time }}"
                                class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600" readonly>
                        </div>
                        <!-- Created At -->
                        <div>
                            <label class="font-medium text-gray-700">Created At</label>
                            <input type="text" value="{{ $created_at }}"
                                class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600" readonly>
                        </div>
                    </div>



                    <div class="">
                        <label class="font-medium text-gray-700">Messages</label>
                        <textarea wire:model="message" readonly class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600"></textarea>
                    </div>



                    <div class="">
                        <label class="font-medium text-gray-700">Destination</label>
                        <textarea wire:model="destination" readonly class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600"></textarea>
                    </div>

                </form>
            </div>
        </div>
    @endif


</div>
