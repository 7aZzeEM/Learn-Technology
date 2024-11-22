<?php $__env->startSection('container'); ?>

<?php echo app('Illuminate\Foundation\Vite')('resources/js/JScomponents/admin/admin.js'); ?>

<script>
    window.admins = <?php echo json_encode($Admins, 15, 512) ?>;
    window.admin = <?php echo json_encode($Admin, 15, 512) ?>;
    window.per = <?php echo e($Admin->powers); ?>;
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.web', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/brittany/Desktop/Courses/Programming/Full-Stack/APPs/viteApp/resources/views/admin/admins.blade.php ENDPATH**/ ?>