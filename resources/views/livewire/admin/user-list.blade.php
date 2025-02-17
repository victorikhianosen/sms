<div>
    <div class="flex flex-col bg-white rounded-lg pt-8 mt-8 px-6 space-y-2">
        <div class="flex justify-between items-center">
            <h3 class="font-bold text-2xl">All Users</h3>
            <input type="text" wire:model.live.debounce.500ms="search" placeholder="Search by Email, Phone Number, Status"
                class="px-4 py-2 border rounded-md bg-gray-100 text-gray-600 w-64 placeholder:text-xs">
        </div>
        <div class="-m-1.5 overflow-x-auto">
            <div class="p-1.5 min-w-full inline-block align-middle">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 table-fixed">
                        <thead>
                            <tr class="bg-blue text-white">
                                <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-40">First Name</th>
                                <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-40">Last Nme</th>
                                <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-40">Email</th>
                                <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-60">phone Number</th>
                                <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-12">Balance</th>
                                <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-24">Status</th>
                                <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-60">Account Number
                                </th>
                                <th class="px-4 py-3 text-start text-xs font-semibold uppercase">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @if ($users->isEmpty())
                                <tr>
                                    <td colspan="8" class="text-center py-4 text-lg text-gray-600">No users found
                                    </td>
                                </tr>
                            @else
                                @foreach ($users as $item)
                                    <tr class="odd:bg-white even:bg-gray-100">
                                        <td class="px-4 py-4 whitespace-normal text-sm font-medium text-gray">
                                            {{ $item->first_name }}</td>
                                        <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                            {{ $item->last_name }}
                                        </td>
                                        <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                            {{ $item->email }}
                                        </td>
                                        <td class="px-4 py-4 whitespace-normal text-sm text-gray break-words">
                                            {{ $item['phone'] }}</td>
                                        <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                            {{ $item->balance }}
                                        </td>
                                        <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                            {{ $item->status }}
                                        </td>
                                        <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                            {{ $item->account_number }}
                                        </td>
                                        <td class="px-4 py-4 whitespace-normal flex items-center gap-2">

                                            <a href="{{ route('admin.userdetails', $item->id) }}" wire:navigate.hover
                                                type="button"
                                                class="bg-blue py-2 px-2 text-white rounded-lg cursor-pointer">
                                                View
                                            </a>

                                            @adminOrSuperAdmin
                                                <button wire:click.prevent="deleteUser({{ $item->id }})"
                                                    class="bg-red-600 py-2 px-2 text-white rounded-lg cursor-pointer">
                                                    Delete
                                                </button>
                                            @endadminOrSuperAdmin

                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="py-8">
            {{ $users->links() }}
        </div>
    </div>
</div>
