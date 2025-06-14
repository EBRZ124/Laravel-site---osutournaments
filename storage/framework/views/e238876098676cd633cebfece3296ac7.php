<nav id="nav">  
<ul>
    <?php if(auth()->guard()->check()): ?>
      <?php if(auth()->user()->role === 'verified'): ?>
        <li <?php if(request()->routeIs('tournaments.create')): ?> class="current" <?php endif; ?>>
          <a href="<?php echo e(route('tournaments.create')); ?>">Create Tournament</a>
        </li>
      <?php endif; ?>
    <?php endif; ?>
    <li class="<?php echo e(request()->routeIs('home')      ? 'current' : ''); ?>">
      <a href="<?php echo e(route('home')); ?>">Latest Post</a>
    </li>
    <li class="<?php echo e(request()->routeIs('archives')  ? 'current' : ''); ?>">
      <a href="<?php echo e(route('archives')); ?>">Archives</a>
    </li>
    <li class="<?php echo e(request()->routeIs('apply')     ? 'current' : ''); ?>">
      <a href="<?php echo e(route('apply')); ?>">Apply for verification</a>
    </li>
    <li class="<?php echo e(request()->routeIs('contact')   ? 'current' : ''); ?>">
      <a href="<?php echo e(route('contact')); ?>">Contact me</a>
    </li>
  </ul>
</nav>
<?php /**PATH /var/www/html/resources/views/partials/nav.blade.php ENDPATH**/ ?>