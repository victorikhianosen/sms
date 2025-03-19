<div>
    <div class="h-screen overflow-x-hidden md:overflow-hidden bg-lightGray grid grid-cols-2">
        <!-- Image Section -->
        <div class="hidden lg:block">
            <img class="h-screen" src="<?php echo e(asset('assets/images/login.jpg')); ?>" alt="">
        </div>

        <!-- Register Section -->

        <div class="">
            <di class="">
                <img class="p-6 w-52" src="<?php echo e(asset('assets/images/logo.png')); ?>" alt="" />
            </di>
            <div class="flex-grow  flex items-center justify-center">

                <div
                    class="bg-white w-auto md:w-4/5 py-8 px-6 sm:px-12 md:px-24 rounded-lg shadow-sm text-center space-y-10">
                    <div class="space-y-1">
                        <h1 class="text-4xl font-bold">Verify OTP</h1>
                        <p class="text-softGray text-sm">Please enter the OTP sent to your email to verify your account.
                        </p>
                    </div>
                    <div>

                        <form class="space-y-5" wire:submit.prevent="verifyEmail">

                            <div x-data="{ otp: '' }">
                                <label class="block text-start text-sm font-medium text-gray">OTP</label>
                                <input type="number" x-model="otp" wire:model="otp"
                                    @input="otp = otp.toString().slice(0, 6)" max="999999"
                                    class="w-full px-3 py-2 border-2 border-softGray rounded-md focus:outline-none focus:ring-blue focus:border-blue"
                                    placeholder="123456">
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['otp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span
                                        class="text-sm text-red-600 block text-start italic pt-1"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>


                            <!--[if BLOCK]><![endif]--><?php if($tokenExpired): ?>
                                <div class="flex justify-between items-center">
                                    <button wire:click.prevent="resendToken"
                                        class="text-blue block text-lg font-semibold text-start italic pt-1 transition-all duration-200 hover:font-semibold animate-pulse">
                                        Resend Token
                                    </button>
                                </div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->



                            <div class="pt-4">
                                <button type="submit" wire:loading.remove
                                    class="w-full bg-blue py-3 px-6 rounded-lg text-white transition-all duration-200 hover:opacity-90">
                                    Submit
                                </button>

                                <button type="submit" wire:loading wire:target="verifyEmail"
                                    class="w-full bg-blue py-3 px-6 rounded-lg text-white transition-all duration-200 hover:opacity-90">
                                    <i class="fa-solid fa-spinner animate-spin "></i> Loading...
                                </button>


                            </div>


                            <div class="">
                                <a href="<?php echo e(route('home')); ?>" wire:navigate.hover class="text-gray text-sm">Already
                                    have
                                    an account? <span class="font-semibold text-blue">Sign in</span></a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<?php /**PATH /home/victor/Documents/Ggt/sms/resources/views/livewire/user/auth/verify-email.blade.php ENDPATH**/ ?>