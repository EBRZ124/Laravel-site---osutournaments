<?php $__env->startSection('content'); ?>
  <h2>Archived Tournaments</h2>

  
  <?php if(session('success')): ?>
    <div class="alert success"><?php echo e(session('success')); ?></div>
  <?php endif; ?>

  
  <?php $__empty_1 = true; $__currentLoopData = $tournaments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <article class="box post post-excerpt">
      <header>
        <h3>
          <a href="<?php echo e(route('tournaments.show', $t)); ?>">
            <?php echo e($t->title); ?>

          </a>
        </h3>
        <span class="date"><?php echo e($t->created_at->format('M j, Y')); ?></span>
      </header>
      <p><?php echo e(Str::limit($t->description, 150)); ?></p>
      <a href="<?php echo e(route('tournaments.show', $t)); ?>" class="button">
        View Details
      </a>
    </article>
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <p>No tournaments yet. Be the first to create one!</p>
  <?php endif; ?>

  
  <div class="pagination" style="margin-top: 2em;">
    <?php echo e($tournaments->links()); ?>

  </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/pages/archives.blade.php ENDPATH**/ ?>