<div x-data="{ showModal: <?php if ((object) ('showModal') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('showModal'->value()); ?>')<?php echo e('showModal'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('showModal'); ?>')<?php endif; ?> }">

    <div class="flex flex-col bg-white rounded-lg py-6 p-6 md:px-8">

        <div class="pt-4 pb-10 ">
            <h3 class="font-bold text-2xl ">Profile</h3>

        </div>


        <div class="font-std mb-10 w-full rounded-2xl bg-white p-10 font-normal leading-relaxed text-gray-900 shadow-xl">
            <div class="flex flex-col md:flex-row">
                <div class="md:w-1/3 text-center mb-8 md:mb-0">
                    



                    <form>
                        <!-- Profile Picture Upload -->
                        <div class="pt-6">
                            <img id="profilePreview"
                                src="<?php echo e($profile_picture ? asset('storage/' . $profile_picture) : ''); ?>"
                                alt="Profile Picture"
                                class="rounded-full w-48 h-48 mx-auto mb-4 border-4 border-blue transition-transform duration-300 hover:scale-105 ring ring-gray-300">

                            <input type="file" wire:model="image" accept="image/*" class="hidden" id="profileInput">
                            <!--[if BLOCK]><![endif]--><?php if(!$profile_picture): ?>
                                <button type="button" onclick="document.getElementById('profileInput').click()"
                                    class="mt-4 bg-blue text-white px-2 py-1 text-xs rounded-lg hover:bg-blue-900 transition-colors duration-300 ring ring-gray-300 hover:ring-indigo-300">
                                    Upload Profile Picture
                                </button>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>


                        <!--[if BLOCK]><![endif]--><?php if(!$current_valid_id): ?>
                            <!-- Valid ID Upload -->
                            <div class="pt-6">
                                <img id="validIDPreview"
                                    src="<?php echo e($current_valid_id ? asset('storage/' . $current_valid_id) : ''); ?>"
                                    alt="Valid ID"
                                    class="rounded-lg w-24 h-24 mx-auto mb-4 border-4 border-blue transition-transform duration-300 hover:scale-105 ring ring-gray-300">

                                <input type="file" wire:model="valid_id" accept="image/*" class="hidden"
                                    id="validIDInput">
                                <button type="button" onclick="document.getElementById('validIDInput').click()"
                                    class="mt-4 bg-blue text-white px-2 py-1 text-xs rounded-lg hover:bg-blue-900 transition-colors duration-300 ring ring-gray-300 hover:ring-indigo-300">
                                    Upload Valid ID
                                </button>
                            </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </form>


                </div>

                <div class="md:w-2/3 md:pl-8">
                    <div class="md:w-2/3 md:pl-8">
                        <h1 class="text-2xl font-bold text-blue mb-2"><?php echo e($first_name); ?> <?php echo e($last_name); ?></h1>
                        <p class="text-gray-600 mb-6 flex items-center">
                            <span class="mr-2">


                                <svg fill="#000000" width="20px" height="20px" viewBox="0 0 96 96"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <title />
                                    <path
                                        d="M69.3677,51.0059a30,30,0,1,0-42.7354,0A41.9971,41.9971,0,0,0,0,90a5.9966,5.9966,0,0,0,6,6H90a5.9966,5.9966,0,0,0,6-6A41.9971,41.9971,0,0,0,69.3677,51.0059ZM48,12A18,18,0,1,1,30,30,18.02,18.02,0,0,1,48,12ZM12.5977,84A30.0624,30.0624,0,0,1,42,60H54A30.0624,30.0624,0,0,1,83.4023,84Z" />
                                </svg>

                            </span>
                            <?php echo e($status); ?>

                        </p>

                        <!--[if BLOCK]><![endif]--><?php if(!empty($company_name)): ?>
                            <h2 class="text-xl font-semibold text-blue mb-4">Organization Information</h2>
                            <p class="text-gray-700 mb-6">
                                <?php echo e($company_name); ?>

                            </p>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                        <h2 class="text-xl font-semibold text-blue mb-4">Contact Information</h2>
                        <ul class="space-y-2 text-gray-700">
                            <li class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue "
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                </svg>
                                <?php echo e($email); ?>

                            </li>
                            <li class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path
                                        d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                </svg>
                                <?php echo e($phone); ?>

                            </li>

                            <!--[if BLOCK]><![endif]--><?php if(!empty($address)): ?>
                                <li class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue 0"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <?php echo e($address); ?>

                                </li>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                        </ul>



                    </div>
                </div>


            </div>

        </div>








    </div>
<?php /**PATH /home/victor/Documents/GGT/sms/resources/views/livewire/user/profile.blade.php ENDPATH**/ ?>