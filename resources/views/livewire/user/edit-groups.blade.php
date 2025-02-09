<div class="px-6">
    <div class="pt-4 pb-10 flex justify-between items-center">
        <h3 class="font-bold text-2xl ">Edit Group</h3>
    </div>

    <div class="">
        <div class="w-full max-w-lg bg-white shadow-lg rounded-lg p-8 relative">

            <form class="space-y-4">
                <div>
                    <label class="text-gray-800 text-sm mb-2 block">Name</label>
                    <input type="text" wire:model="name"
                        class="w-full px-3 py-2 border-2 border-softGray rounded-md focus:outline-none focus:ring-blue focus:border-blue"
                        placeholder="Enter group name">
                    @error('name')
                        <span class="text-sm text-red-600 block text-start italic pt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="text-textPrimary text-sm mb-2 block">Description</label>
                    <textarea wire:model="description"
                        class="w-full px-3 py-2 border-2 border-softGray rounded-md focus:outline-none focus:ring-blue focus:border-blue"
                        placeholder="Enter group description"></textarea>
                    @error('description')
                        <span class="text-sm text-red-600 block text-start italic pt-1">{{ $message }}</span>
                    @enderror
                </div>


                {{-- <div x-data="{ numbers: @entangle('numbers') }">
                    <label class="block text-start text-base font-light text-textPrimary">Phone Numbers</label>
                    <textarea x-model="numbers"
                        class="w-full lg:w-2/5 px-3 py-2 border-2 border-softGray rounded-md focus:outline-none focus:ring-blue focus:border-blue placeholder:text-sm"
                        placeholder="Enter phone numbers separated by a comma" cols="20" rows="3"
                        x-on:input="numbers = numbers.replace(/\D/g, '').replace(/(\d{11})(?=\d)/g, '$1, ').trim()"></textarea>

                    @error('numbers')
                        <span class="text-sm text-red-600 block text-start italic pt-1">{{ $message }}</span>
                    @enderror
                </div> --}}

                <div x-data="{ numbers: @entangle('numbers') }">
                    <label class="text-textPrimary text-sm mb-2 block">Numbers</label>
                    <textarea wire:model="numbers"
                        class="w-full px-3 py-2 border-2 border-softGray rounded-md focus:outline-none focus:ring-blue focus:border-blue"
                        placeholder="Enter group numbers" rows="5" cols="5"
                        x-on:input="numbers = numbers.replace(/\D/g, '').replace(/(\d{11})(?=\d)/g, '$1, ').trim()"></textarea>
                    @error('numbers')
                        <span class="text-sm text-red-600 block text-start italic pt-1">{{ $message }}</span>
                    @enderror
                </div>

                {{-- <div>
                    <label class="text-textPrimary text-sm mb-2 block">Numbers</label>
                    <textarea wire:model="numbers"
                        class="w-full px-3 py-2 border-2 border-softGray rounded-md focus:outline-none focus:ring-blue focus:border-blue"
                        placeholder="Enter group numbers" rows="5" cols="5"></textarea>
                    @error('numbers')
                        <span class="text-sm text-red-600 block text-start italic pt-1">{{ $message }}</span>
                    @enderror
                </div> --}}

                <div class="flex justify-end gap-4 !mt-8">
                    <a href="{{ route('groups') }}" wire:navigate.hover type="button"
                        class="px-6 py-3 rounded-lg text-blue text-sm border-2 border-blue outline-none tracking-wide bg-white transition-all duration-200 ease-in-out hover:bg-blue hover:text-white">Back</a>

                    <button type="button" wire:click.prevent="updateGroup"
                        class="px-6 py-3 rounded-lg text-white text-sm border-none outline-none tracking-wide bg-blue transition-all duration-200 ease-in-out hover:bg-opacity-90">
                        Update Group
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
