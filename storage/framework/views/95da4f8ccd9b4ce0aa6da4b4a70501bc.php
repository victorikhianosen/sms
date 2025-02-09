<!DOCTYPE html>
<html lang="en">

<head>


    <?php echo $__env->make('includes.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

</head>

<body>

    <main>
        <?php echo $__env->yieldContent('guest-section'); ?>
    </main>


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

</body>

</html>
<?php /**PATH C:\Users\HP\Documents\GGT\sms\resources\views/layouts/guest_layout.blade.php ENDPATH**/ ?>