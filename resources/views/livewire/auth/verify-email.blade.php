<div>
    <div class="h-screen overflow-hidden bg-lightGray flex">
        <!-- Image Section -->
        <div class="hidden sm:block lg:block">
            <img class="h-screen" src="{{ asset('assets/images/login.png') }}" alt="">
        </div>

        <!-- Register Section -->
        <div class="flex-grow flex items-center justify-center">
            <div
                class="bg-white w-auto md:w-3/5 py-8 px-6 sm:px-12 md:px-24 rounded-lg shadow-sm text-center space-y-10">
                <div class="space-y-1">
                    <h1 class="text-4xl font-bold">Verify Email</h1>
                    <p class="text-softGray text-sm">Enter the OTP sent to your email to verify your account.</p>
                </div>


                <div>
                    <form>

                        <div class="pb-4">
                            <label class="block text-start text-sm font-medium text-gray">OTP</label>
                            <input type="text"
                                class="w-full px-3 py-2 border-2 border-softGray rounded-md focus:outline-none focus:ring-blue focus:border-blue"
                                placeholder="123456">
                        </div>



                        <div class="pt-6">
                            <button
                                class="w-full bg-blue py-3 px-6 rounded-lg text-white transition-all duration-200 hover:opacity-90">
                                Submit
                            </button>
                        </div>
                        <div class="pt-6">
                          
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
