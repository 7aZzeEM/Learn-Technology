<?php $__env->startSection('content2'); ?>

<?php echo app('Illuminate\Foundation\Vite')('resources/js/JScomponents/courses.js'); ?>

<script>
    window.courses = <?php echo json_encode(json_decode($Courses), 15, 512) ?>;
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.web', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/brittany/Desktop/Courses/Programming/Full-Stack/APPs/viteApp/resources/views/courses.blade.php ENDPATH**/ ?>