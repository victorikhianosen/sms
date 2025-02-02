<div x-data="{ showAddModal: false, showEditModal: false }">

    <div class="pt-4 pb-10 px-6 flex justify-between items-center">
        <h3 class="font-bold text-2xl ">All Groups</h3>
        <button type="button"
            class="mt-6 px-5 py-2.5 rounded-lg text-white text-xs tracking-wider font-medium border-none outline-none bg-blue hover:opacity-90"
            @click="showAddModal = true">
            Add Group
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">


        @if ($allGroups->isEmpty())
            <div class="p-6 text-center bg-white rounded-lg shadow-sm">
                <p class="text-textPrimary font-light text-lg leading-relaxed">
                  You have no groups. Add one, upload a CV, or an Excel file.
                </p>
            </div>
        @else
            @foreach ($allGroups as $item)
                <div class="relative p-6 text-center shadow-sm bg-white space-y-3 rounded-lg">
                    <h3 class="text-lg font-medium">{{ $item['name'] }}</h3>
                    <p class="text-textPrimary font-light text-sm leading-relaxed">{{ $item['name'] }}</p>
                    <div class="pt-3">
                        <a href="{{ route('editgroups', $item['id']) }}" wire:navigate.hover type="button"
                            @click.prevent.stop
                            class="mt-6 px-5 py-2 w-full rounded-lg text-white text-xs tracking-wider font-light border-none outline-none bg-blue hover:opacity-90">View</a>
                    </div>
                    <span class="block absolute top-0 right-4 bg-blue text-white py-1 px-2 rounded-lg text-[12px]">
                        {{ count(json_decode($item['numbers'], true)) }}
                    </span>
                </div>
            @endforeach
        @endif


        {{-- @foreach ($allGroups as $item)
            <div class="relative p-6 text-center shadow-sm bg-white space-y-3 rounded-lg">
                <h3 class="text-lg font-medium">{{ $item['name'] }}</h3>
                <p class="text-textPrimary font-light text-sm leading-relaxed">{{ $item['name'] }}</p>
                <div class="pt-3">
                    <a href="{{ route('editgroups', $item['id']) }}" wire:navigate.hover type="button"
                        @click.prevent.stop
                        class="mt-6 px-5 py-2 w-full rounded-lg text-white text-xs tracking-wider font-light border-none outline-none bg-blue hover:opacity-90">View</a>
                </div>
                <span class="block absolute top-0 right-4 bg-blue text-white py-1 px-2 rounded-lg text-[12px]">
                    {{ count(json_decode($item['numbers'], true)) }}
                </span>
            </div>
        @endforeach --}}

        {{-- @foreach ($allGroups as $item)
            <div class="relative p-6 text-center shadow-sm bg-white space-y-3 rounded-lg">
                <h3 class="text-lg font-medium">{{ $item['name'] }}</h3>
                <p class="text-textPrimary font-light text-sm leading-relaxed">{{ $item['name'] }}</p>
                <div class="pt-3">
                    <a href="{{ route('editgroups', $item['id']) }}" wire:navigate.hover type="button"
                        @click.prevent.stop
                        class="mt-6 px-5 py-2 w-full rounded-lg text-white text-xs tracking-wider font-ligjt border-none outline-none bg-blue hover:opacity-90">View</a>
                </div>
                <span class="block absolute top-0 right-4 bg-blue text-white py-1 px-3 rounded-lg text-xs">
                    {{$item['numbers']}}
                </span>
            </div>
        @endforeach --}}
        <!-- Add pagination links here -->

    </div>

    <div class="mt-6">
        {{ $allGroups->links() }}
    </div>

    <!-- Add Modal -->
    <div x-show="showAddModal" x-transition
        class="fixed inset-0 p-4 flex flex-wrap justify-center items-center w-full h-full z-[1000] before:fixed before:inset-0 before:w-full before:h-full before:bg-[rgba(0,0,0,0.5)] overflow-auto font-[sans-serif]"
        @click.self="showAddModal = false">
        <div class="w-full max-w-lg bg-white shadow-lg rounded-lg p-8 relative">
            <div class="flex items-center">
                <h3 class="text-bg-blue text-xl font-bold flex-1">Add New Group</h3>
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="w-3 ml-2 cursor-pointer shrink-0 fill-gray-400 hover:fill-red-500"
                    @click="showAddModal = false" viewBox="0 0 320.591 320.591">
                    <!-- SVG path here -->
                </svg>
            </div>
            <form class="space-y-4 mt-8" x-data="{ files: [] }">

                <div>
                    <label class="text-gray-800 text-sm mb-2 block">Name</label>
                    <input type="text" autocomplete="off" wire:model="name"
                        class="w-full px-3 py-2 border-2 border-softGray rounded-md focus:outline-none focus:ring-blue focus:border-blue"
                        placeholder="Enter group name">
                    @error('name')
                        <span class="text-sm text-red-600 block text-start italic pt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="text-textPrimary text-sm mb-2 block">Descriptions</label>
                    <textarea wire:model="description" autocomplete="off"
                        class="w-full px-3 py-2 border-2 border-softGray rounded-md focus:outline-none focus:ring-blue focus:border-blue"
                        placeholder="Enter group description"></textarea>
                    @error('description')
                        <span class="text-sm text-red-600 block text-start italic pt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div x-show="files.length > 0" class="space-y-2">
                    <h3 class="text-sm font-medium">Preview:</h3>
                    <div class="flex space-x-2">
                        <template x-for="(file, index) in files" :key="index">
                            <div class="flex items-center space-x-2">
                                <template x-if="file.name.endsWith('.csv')">
                                    <i class="fas fa-file-csv text-yellow-600"></i> <!-- CSV Icon -->
                                </template>
                                <template x-if="file.name.endsWith('.xls')">
                                    <i class="fas fa-file-excel text-green-600"></i> <!-- XLS Icon -->
                                </template>
                                <template x-if="file.name.endsWith('.xlsx')">
                                    <i class="fas fa-file-excel text-green-600"></i> <!-- XLSX Icon -->
                                </template>
                                <span x-text="file.name" class="text-gray-700 text-sm"></span>
                            </div>
                        </template>
                    </div>
                </div>

                <div class="relative">
                    <label class="text-textPrimary text-sm mb-2 block">Upload Phones</label>
                    <input type="file" wire:model="numbers"
                        class="w-full px-3 py-2 border-2 border-softGray rounded-md focus:outline-none focus:ring-blue focus:border-blue opacity-0 absolute inset-0 z-10 cursor-pointer"
                        accept=".csv, .xls, .xlsx" x-on:change="files = Array.from($event.target.files)" />
                    <div
                        class="w-full px-3 py-2 border-2 border-softGray rounded-md text-gray-500 bg-white cursor-pointer">
                        <span>Select a file (CSV, .xls, or .xlsx format)</span>
                    </div>
                    @error('numbers')
                        <span class="text-sm text-red-600 block text-start italic pt-1">{{ $message }}</span>
                    @enderror
                </div>
                <!-- Form fields here -->
                <div class="flex justify-end gap-4 !mt-8">
                    <button type="button"
                        class="px-6 py-3 rounded-lg text-blue text-sm border-2 border-blue outline-none tracking-wide bg-white transition-all duration-200 ease-in-out hover:bg-blue hover:text-white"
                        @click="showAddModal = false">Cancel</button>
                    <button type="button" wire:click.prevent="addGroup" wire:loading.remove
                        class="px-6 py-3 rounded-lg text-white text-sm border-none outline-none tracking-wide bg-blue transition-all duration-200 ease-in-out hover:bg-opacity-90">Add</button>
                    <button type="button" wire:loading wire:target="addGroup"
                        class="px-6 py-3 rounded-lg text-white text-sm border-none outline-none tracking-wide bg-blue transition-all duration-200 ease-in-out hover:bg-opacity-90">
                        <i class="fa-solid fa-spinner animate-spin "></i> Loading...
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Modal -->

    {{-- <div x-show="showEditModal" x-transition
        class="fixed inset-0 p-4 flex flex-wrap justify-center items-center w-full h-full z-[1000] before:fixed before:inset-0 before:w-full before:h-full before:bg-[rgba(0,0,0,0.5)] overflow-auto font-[sans-serif]"
        @click.self="showEditModal = false">
        <div class="w-full max-w-lg bg-white shadow-lg rounded-lg p-8 relative">
            <div class="flex items-center">
                <h3 class="text-bg-blue text-xl font-bold flex-1">Edit Group</h3>
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="w-3 ml-2 cursor-pointer shrink-0 fill-gray-400 hover:fill-red-500"
                    @click="showEditModal = false" viewBox="0 0 320.591 320.591">
                    <path
                        d="M30.391 318.583a30.37 30.37 0 0 1-21.56-7.288c-11.774-11.844-11.774-30.973 0-42.817L266.643 10.665c12.246-11.459 31.462-10.822 42.921 1.424 10.362 11.074 10.966 28.095 1.414 39.875L51.647 311.295a30.366 30.366 0 0 1-21.256 7.288z"
                        data-original="#000000"></path>
                    <path
                        d="M287.9 318.583a30.37 30.37 0 0 1-21.257-8.806L8.83 51.963C-2.078 39.225-.595 20.055 12.143 9.146c11.369-9.736 28.136-9.736 39.504 0l259.331 257.813c12.243 11.462 12.876 30.679 1.414 42.922-.456.487-.927.958-1.414 1.414a30.368 30.368 0 0 1-23.078 7.288z"
                        data-original="#000000"></path>
                </svg>
            </div>

            <form class="space-y-4 mt-8">
                <div>
                    <label class="text-gray-800 text-sm mb-2 block">Name</label>
                    <input type="text" x-model="groupToEdit.name"
                        class="w-full px-3 py-2 border-2 border-softGray rounded-md focus:outline-none focus:ring-blue focus:border-blue"
                        placeholder="Enter group name">
                </div>

                <div>
                    <label class="text-textPrimary text-sm mb-2 block">Description</label>
                    <textarea x-model="groupToEdit.description"
                        class="w-full px-3 py-2 border-2 border-softGray rounded-md focus:outline-none focus:ring-blue focus:border-blue"
                        placeholder="Enter group description"></textarea>
                </div>


                   <div>
                    <label class="text-textPrimary text-sm mb-2 block">Numbers</label>
                    <textarea x-model="groupToEdit.description"
                        class="w-full px-3 py-2 border-2 border-softGray rounded-md focus:outline-none focus:ring-blue focus:border-blue"
                        placeholder="Enter group description"></textarea>
                </div>

                <div class="flex justify-end gap-4 !mt-8">
                    <button type="button"
                        class="px-6 py-3 rounded-lg text-blue text-sm border-2 border-blue outline-none tracking-wide bg-white transition-all duration-200 ease-in-out hover:bg-blue hover:text-white"
                        @click="showEditModal = false">Cancel</button>

                    <button type="button"
                        class="px-6 py-3 rounded-lg text-white text-sm border-none outline-none tracking-wide bg-blue transition-all duration-200 ease-in-out hover:bg-opacity-90">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div> --}}

</div>
