<div class="flex flex-col bg-white rounded-lg pt-8 mt-8 px-6 space-y-2">
    <div class="flex justify-between items-center">
        <h3 class="font-bold text-2xl">All Payment</h3>

        <!-- Search Input Field -->
        <input type="text" wire:model.live.debounce.50ms="search" placeholder="Search by Amount, Tranx ID, Email"
            class="px-4 py-2 border rounded-md bg-gray-100 text-gray-600 w-64 placeholder:text-xs">


        <button wire:click.prevent="showDownload" type="button"
            class="text-sm text-white rounded-lg py-2 px-5 bg-blue">Download</button>
    </div>

    <div class="-m-1.5 overflow-x-auto">
        <div class="p-1.5 min-w-full inline-block align-middle">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 table-fixed">
                    <thead>
                        <tr class="bg-blue text-white">
                            <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-40">Tranx ID</th>
                            <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-60">Email</th>
                            <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-40">Payment Type</th>
                            <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-40">Amount</th>
                                                        <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-40">Reference</th>


                            <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-40">Status</th>
                            <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-60">Date</th>
                            @adminOrSuperAdmin
                                <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-40">Action</th>
                            @endadminOrSuperAdmin
                        </tr>
                    </thead>
                    <tbody>
                        @if ($payments->isEmpty())
                            <tr>
                                <td colspan="6" class="text-center py-4 text-gray-600">No Payment Found</td>
                            </tr>
                        @else
                            @foreach ($payments as $payment)
                                <tr>
                                    <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                        {{ Str::limit($payment['transaction_number'], 10, '') }}
                                    </td>
                                    <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                        {{-- {{ $payment['user']['email'] }} --}}

                                        @if ($payment->user)
                                            {{ $payment->user->email }}
                                        @else
                                            {{ $payment->admin->email }}
                                        @endif

                                    </td>
                                    <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                        {{ $payment['payment_type'] }}
                                    </td>
                                    <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                        {{ $payment['amount'] }}
                                    </td>
                                    <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                        {{ Str::limit($payment['reference'], 10, '..') }}
                                    </td>


                                    <td
                                        class="px-4 py-4 whitespace-normal text-sm 
                                        @if ($payment['status'] == 'success') text-green-600 
                                        @elseif($payment['status'] == 'failed') text-red-600 
                                        @elseif($payment['status'] == 'pending') text-yellow-600 
                                        @else text-gray-600 @endif">
                                        {{ ucfirst($payment['status']) }}
                                    </td>
                                    <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                        {{ $payment['created_at'] }}
                                    </td>
                                    @adminOrSuperAdmin
                                        <td class="px-4 py-4 whitespace-normal flex items-center gap-2">
                                            <button type="button" wire:click.prevent="viewPayment({{ $payment['id'] }})"
                                                class="bg-blue py-2 px-2 text-sm text-white rounded-lg cursor-pointer">
                                                View
                                            </button>
                                        </td>
                                    @endadminOrSuperAdmin
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <div class="py-8">
        {{ $payments->links() }}
    </div>

    @if ($editModel)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 px-4">
            <div
                class="bg-white p-6 sm:p-8 rounded-lg shadow-lg w-screen sm:w-[600px] lg:w-[600px] xl:w-[1000px] max-w-6xl">
                <div class="flex justify-between items-center border-b-2 border-softGray pb-4">
                    <h3 class="text-2xl font-bold">Payment Details</h3>
                    <button class="text-black text-2xl" wire:click="closeModal">
                        <i class="fas fa-times hover:text-red-600"></i>
                    </button>
                </div>

                <form class="mt-4 text-gray-700 space-y-6 pt-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                        @if ($email)
                            <div>
                                <label class="font-medium text-gray-700">Email</label>
                                <input type="text" wire:model="email"
                                    class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600" readonly>
                            </div>
                        @endif

                        @if ($amount)
                            <div>
                                <label class="font-medium text-gray-700">Amount</label>
                                <input type="text" wire:model="amount"
                                    class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600" readonly>
                            </div>
                        @endif

                        @if ($status)
                            <div>
                                <label class="font-medium text-gray-700">Status</label>
                                <input type="text" wire:model="status"
                                    class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600" readonly>
                            </div>
                        @endif

                        @if ($transaction_number)
                            <div>
                                <label class="font-medium text-gray-700">Transaction ID</label>
                                <input type="text" wire:model="transaction_number"
                                    class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600" readonly>
                            </div>
                        @endif

                        @if ($reference)
                            <div>
                                <label class="font-medium text-gray-700">Reference</label>
                                <input type="text" wire:model="reference"
                                    class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600" readonly>
                            </div>
                        @endif

                        @if ($bank_name)
                            <div>
                                <label class="font-medium text-gray-700">Bank Name</label>
                                <input type="text" wire:model="bank_name"
                                    class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600" readonly>
                            </div>
                        @endif

                        @if ($account_number)
                            <div>
                                <label class="font-medium text-gray-700">Account Number</label>
                                <input type="text" wire:model="account_number"
                                    class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600" readonly>
                            </div>
                        @endif

                        @if ($card_last_four)
                            <div>
                                <label class="font-medium text-gray-700">Card Last Four</label>
                                <input type="text" wire:model="card_last_four"
                                    class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600" readonly>
                            </div>
                        @endif

                        @if ($card_brand)
                            <div>
                                <label class="font-medium text-gray-700">Card Brand</label>
                                <input type="text" wire:model="card_brand"
                                    class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600" readonly>
                            </div>
                        @endif

                        @if ($description)
                            <div>
                                <label class="font-medium text-gray-700">Description</label>
                                <input type="text" wire:model="description"
                                    class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600" readonly>
                            </div>
                        @endif

                        @if ($payment_type)
                            <div>
                                <label class="font-medium text-gray-700">Payment Type</label>
                                <input type="text" wire:model="payment_type"
                                    class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600" readonly>
                            </div>
                        @endif


                          @if ($payment_method)
                            <div>
                                <label class="font-medium text-gray-700">Payment Method</label>
                                <input type="text" wire:model="payment_method"
                                    class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600" readonly>
                            </div>
                        @endif

                        @if ($account_type)
                            <div>
                                <label class="font-medium text-gray-700">Account Type</label>
                                <input type="text" wire:model="account_type"
                                    class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600" readonly>
                            </div>
                        @endif

                        @if ($created_at)
                            <div>
                                <label class="font-medium text-gray-700">Date</label>
                                <input type="text" wire:model="created_at"
                                    class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600" readonly>
                            </div>
                        @endif

                    </div>

                    <div class="mt-6 flex justify-start pt-4 space-x-4">
                        <button type="button" wire:click="closeModal"
                            class="px-8 py-3 bg-red-600 text-white rounded-lg hover:bg-opacity-90 transition text-sm">
                            Close
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif






    @if ($downloadModel)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 px-4">
            <div
                class="bg-white p-6 sm:p-8 rounded-lg shadow-lg w-screen sm:w-[600px] lg:w-[600px] xl:w-[1000px] max-w-2xl">
                <div class="flex justify-between items-center border-b-2 border-softGray pb-4">
                    <h3 class="text-2xl font-bold">Select Date</h3>
                    <button class="text-black text-2xl" wire:click="closeModal">
                        <i class="fas fa-times hover:text-red-600"></i>
                    </button>
                </div>


                <form class="mt-4 text-gray-700 space-y-6 pt-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="font-medium text-gray-700">Start Date</label>
                            <input type="datetime-local" wire:model="start_date"
                                class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600">
                            @error('start_date')
                                <span class="text-sm text-red-600 block text-start italic pt-1">{{ $message }}</span>
                            @enderror

                        </div>
                        <div>
                            <label class="font-medium text-gray-700">End Date</label>
                            <input type="datetime-local" wire:model="end_date"
                                class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600">
                            @error('end_date')
                                <span class="text-sm text-red-600 block text-start italic pt-1">{{ $message }}</span>
                            @enderror

                        </div>
                    </div>

                    <div class="mt-6 flex justify-start pt-4 space-x-4">
                        <button type="button" wire:loading.remove wire:click="DownloadPayments"
                            class="px-8 py-3 bg-blue text-white rounded-lg hover:bg-opacity-90 transition text-sm">
                            Download
                        </button>

                        <button type="button" wire:loading wire:target="DownloadPayments"
                            class="px-8 py-3 bg-blue text-white rounded-lg hover:bg-opacity-90 transition text-sm">
                            <i class="fa-solid fa-spinner animate-spin "></i> Loading...
                        </button>

                    </div>
                </form>


            </div>
        </div>
    @endif

</div>
