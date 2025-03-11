<!DOCTYPE html>
<html lang="en">

<head>


    <?php echo $__env->make('includes.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

</head>

<body>

    


    <div class="relative h-screen">
        <!-- Fixed Sidebar -->

        <?php echo $__env->make('includes.admin.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <!-- Fixed Navbar -->

        <?php echo $__env->make('includes.admin.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>




        <?php echo $__env->make('includes.admin.mobile_menu', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>




    



        


        

        <div
            class="relative bg-[#f2f2f2] ml-0 lg:ml-[240px] mt-0 lg:mt-[50px] h-full overflow-y-auto lg:pt-6 pb-6 px-6">

            <?php echo $__env->yieldContent('admin-section'); ?>
        </div>





    </div>

    <script src="<?php echo e(asset('assets/js/sweet-alart2.js')); ?>"></script>
    <script>
        window.addEventListener('alert', (event) => {
            const data = event.detail;

            Swal.fire({
                icon: data.type,
                text: data.text,
                position: data.position,
                timer: data.timer,
                buttons: data.button,
            });
        });
    </script>
    <script>
        <?php if(session('alert')): ?>
            window.dispatchEvent(new CustomEvent('alert', {
                detail: {
                    type: '<?php echo e(session('alert.type')); ?>',
                    text: '<?php echo e(session('alert.text')); ?>',
                    position: '<?php echo e(session('alert.position')); ?>',
                    timer: <?php echo e(session('alert.timer')); ?>,
                    button: <?php echo e(session('alert.button') ? 'true' : 'false'); ?>

                }
            }));
        <?php endif; ?>
    </script>

    <script src="https://js.paystack.co/v1/inline.js"></script>
    


</body>

</html>
<?php /**PATH /home/victor/Documents/GGT/sms/resources/views/layouts/admin_layout.blade.php ENDPATH**/ ?>