<div x-data>
    <div class="pt-4 pb-10 px-6 flex justify-between items-center">
        <h3 class="font-bold text-2xl ">Make Payment</h3>
    </div>

    <form
        class="bg-white w-full max-w-3xl mx-auto px-4 lg:px-6 py-8 shadow-md rounded-md flex flex-col justify-center gap-6 md:gap-0 items-center lg:flex-row">
        <div class="w-full lg:w-1/2 lg:pr-8 lg:border-r-2 lg:border-slate-300">
            <div class="mb-4">
                <label class="text-textPrimary font-semibold text-sm mb-2 block">Amount</label>
                <input id="cardNumber" type="text" wire:model.live="amount"
                    class="flex h-10 w-full rounded-md border-2 bg-background px-4 py-1.5 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:border-blue focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                    maxlength="19" placeholder="Enter Amount" />

                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="text-sm text-red-600 block text-start italic pt-1"><?php echo e($message); ?></span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
            </div>

            <div class="flex justify-end items-end">
                <button wire:click.prevent="makePayment" class="text-white bg-blue py-2 px-8 rounded-lg">
                    Pay
                </button>
            </div>
        </div>

        <div class="w-full lg:w-1/2 lg:pl-8">
            <div class="w-full max-w-sm h-56" style="perspective: 1000px">
                <div id="creditCard" class="relative crediCard cursor-pointer transition-transform duration-500"
                    style="transform-style: preserve-3d">
                    <div class="w-full h-56 m-auto rounded-xl text-white shadow-2xl absolute overflow-hidden"
                        style="backface-visibility: hidden">
                        <img src="https://i.ibb.co/LPLv5MD/Payment-Card-01.jpg"
                            class="relative object-cover w-full h-full rounded-xl" />
                        <div class="w-full px-8 absolute top-8">
                            <div class="flex justify-end">
                                <img class="w-28 h-10" src="<?php echo e(asset('assets/images/paystack.png')); ?>" alt="Paystack" />
                            </div>
                            <div class="pt-1">
                                <p class="font-light">Amount</p>
                                <p id="imageCardNumber" class="font-medium tracking-more-wider h-6">
                                    <?php echo e($formattedAmount); ?></p>
                            </div>
                            <div class="pt-6 flex justify-between">
                                <div>
                                    <p class="font-light">Name</p>
                                    <p id="imageCardName" class="font-medium tracking-widest h-6">
                                        <?php echo e(Auth::user()->first_name); ?></p>
                                </div>
                                <div class="pr-0 lg:pr-8">
                                    <p class="font-light">Units</p>
                                    <p id="imageExpDate" class="font-medium tracking-wider h-6 w-14">
                                        <?php echo e($formattedUnits); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    


    <script>
        window.addEventListener('paystackPayment', (event) => {
            const data = event.detail[0];

            const handler = PaystackPop.setup({
                key: '<?php echo e(env('PAYSTACK_PUBLIC_KEY')); ?>',
                email: data.email,
                first_name: data.first_name,
                last_name: data.last_name,
                phone: data.phone,
                amount: data.amount,
                currency: data.currency,
                callback: function(response) {
                    // After successful payment, redirect to the verifypayment route
                    window.location.href = `/payment/verify/${response.reference}`;
                    console.log(response);
                },
                onClose: function() {
                    alert('Payment process was closed.');
                },
            });
            handler.openIframe();
        });
    </script>


</div>
<?php /**PATH C:\Users\HP\Documents\GGT\sms\resources\views/livewire/user/paystack-payment.blade.php ENDPATH**/ ?>