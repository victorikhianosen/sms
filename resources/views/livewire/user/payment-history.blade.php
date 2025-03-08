<div>
    <div class="flex flex-col bg-white rounded-lg">
    
        <div class="flex justify-between items-center px-6 py-6">
            <h3 class="font-bold text-2xl">All Payment</h3>
            <input type="text" wire:model.live.debounce.50ms="search" placeholder="Search by Amount, Tranx ID, Email"
                class="px-4 py-2 border rounded-md bg-gray-100 text-gray-600 w-64 placeholder:text-xs">
        </div>

        <div class="-m-1.5 overflow-x-auto">
            <div class="p-1.5 min-w-full inline-block align-middle">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 table-fixed">
                        <thead>
                            <tr class="bg-blue text-white">
                                <th scope="col" class="px-4 py-3 text-start text-xs font-semibold uppercase w-28">
                                    Tranx ID
                                </th>
                                <th scope="col" class="px-4 py-3 text-start text-xs font-semibold uppercase w-40">
                                    Reference
                                </th>
                                <th scope="col" class="px-4 py-3 text-start text-xs font-semibold uppercase w-40">
                                    Amount
                                </th>
                                <th scope="col" class="px-4 py-3 text-start text-xs font-semibold uppercase w-36">
                                    Payment type
                                </th>
                                <th scope="col" class="px-4 py-3 text-start text-xs font-semibold uppercase w-40">
                                    Status
                                </th>
                                <th scope="col" class="px-4 py-3 text-start text-xs font-semibold uppercase w-60">
                                    Date
                                </th>
                                <th scope="col" class="px-4 py-3 text-start text-xs font-semibold uppercase w-24">
                                    Currency
                                </th>
                            </tr>
                        </thead>

                        {{-- Show a loading indicator below the table head --}}
                        @if (!$allPayment)
                            <tbody>
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <i class="fa-solid fa-spinner animate-spin text-4xl text-blue-500"></i>
                                        <p class="text-lg text-gray-600 mt-2 animate-pulse">Loading...</p>
                                    </td>
                                </tr>
                            </tbody>
                        @else
                            <tbody>
                                @foreach ($allPayment as $payment)
                                    <tr class="odd:bg-white even:bg-gray-100">
                                        <td class="px-4 py-4 whitespace-normal text-sm font-medium text-gray">
                                            {{ substr($payment->transaction_id, 0, 10) }}
                                        </td>
                                        <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                            {{ $payment->reference }}
                                        </td>
                                        <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                            {{ $payment->amount }}
                                        </td>
                                        <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                            {{ $payment->payment_type }}
                                        </td>
                                        <td
                                            class="px-4 py-4 whitespace-normal text-sm
                                    @if ($payment->status == 'success') text-green-600
                                    @elseif($payment->status == 'failed') text-red-600
                                    @else text-gray-600 @endif">
                                            {{ $payment->status }}
                                        </td>
                                        <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                            {{ $payment->created_at }}
                                        </td>
                                        <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                            ({{ $payment->currency }})
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        @endif
                    </table>
                </div>
            </div>
        </div>


        <div class="mt-4 py-4 px-4">
            {{ $allPayment->links() }}
        </div>


    </div>



</div>
