<?php $__env->startSection('container'); ?>

<?php echo app('Illuminate\Foundation\Vite')('resources/js/JScomponents/admin/courses.js'); ?>

<script>
    window.courses = <?php echo json_encode(json_encode($courses), 15, 512) ?>;
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.web', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/brittany/Desktop/Courses/Programming/Full-Stack/APPs/viteApp/resources/views/admin/courses.blade.php ENDPATH**/ ?>