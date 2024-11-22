<?php $__env->startSection('content'); ?>

<?php echo app('Illuminate\Foundation\Vite')('resources/js/JScomponents/admin/login.js'); ?>


<script>
    window.token = '<?php echo e(csrf_token()); ?>';
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/brittany/Desktop/Courses/Programming/Full-Stack/APPs/viteApp/resources/views/admin/login.blade.php ENDPATH**/ ?>