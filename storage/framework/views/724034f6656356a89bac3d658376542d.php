<?php $__env->startSection('content'); ?>

  
  <article class="box post">
    <header><h2><?php echo e($tournament->title); ?></h2></header>
    <p><?php echo e($tournament->description); ?></p>
  </article>

  
  <section class="box post">
    <header><h3>Participants</h3></header>
    <ul>
      <?php $__currentLoopData = $tournament->players; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $player): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li>
          <?php echo e($player->name); ?>

          <?php if($player->country): ?>
            (<?php echo e($player->country); ?>)
          <?php endif; ?>
        </li>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
  </section>

  
  <section class="box post">
    <header><h3>Bracket</h3></header>

    <style>
      .round-row { margin-bottom: 2em; }
      .round-title { margin-bottom: 0.5em; font-size: 1.1em; }
      .matches-row { display: flex; gap: 1em; overflow-x: auto; }
      .matchup-block {
        border: 1px solid #ccc;
        border-radius: 0.4em;
        padding: 0.75em;
        background: #fff;
        box-shadow: 0 0.5em 1em rgba(0,0,0,0.1);
        min-width: 180px;
      }
      .matchup-block .player { font-weight: 500; }
      .matchup-block .vs { text-align: center; margin: 0.5em 0; font-weight: bold; }
    </style>

    <?php
      // Total participants at start
      $initialPlayers = $tournament->players->count();
      // Group and sort matchups by their round index
      $groups = $tournament->matchUps->groupBy('round')->sortKeys();
      // Stage labels by number of participants
      $stageLabels = [
        64 => 'Round of 64',
        32 => 'Round of 32',
        16 => 'Round of 16',
         8 => 'Quarterfinals',
         4 => 'Semifinals',
         2 => 'Grand Final',
      ];
      // Max round index
      $maxRound = $groups->keys()->max();
    ?>

    <div class="bracket-rows">
      <?php for($round = 0; $round <= $maxRound; $round++): ?>
        <?php if(isset($groups[$round])): ?>
          <?php
            $playersThisRound = (int) max(2, $initialPlayers / (2 ** $round));
            $stageName = $stageLabels[$playersThisRound] ?? "Round of {$playersThisRound}";
          ?>

          <div class="round-row">
            <div class="round-title"><?php echo e($stageName); ?></div>
            <div class="matches-row">
              <?php $__currentLoopData = $groups[$round]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $match): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="matchup-block">
                  <div class="player">
                    <?php echo e($match->player1->name); ?> – <?php echo e($match->player1_score ?? '–'); ?>

                  </div>
                  <div class="vs">vs</div>
                  <div class="player">
                    <?php echo e($match->player2->name); ?> – <?php echo e($match->player2_score ?? '–'); ?>

                  </div>
                </div>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
          </div>
        <?php endif; ?>
      <?php endfor; ?>
    </div>
  </section>

  
  <section class="box post">
    <header><h3>Sources</h3></header>
    <ul>
      <?php $__currentLoopData = $tournament->sources; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if($s->stream_url): ?>
          <li><a href="<?php echo e($s->stream_url); ?>">Stream</a></li>
        <?php endif; ?>
        <?php if($s->video_url): ?>
          <li><a href="<?php echo e($s->video_url); ?>">Video Archive</a></li>
        <?php endif; ?>
        <?php if($s->forum_url): ?>
          <li><a href="<?php echo e($s->forum_url); ?>">Forum Thread</a></li>
        <?php endif; ?>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
  </section>

  
  <section class="box post">
    <header><h3>Comments</h3></header>
    <?php $__empty_1 = true; $__currentLoopData = $tournament->comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
      <div class="comment">
        <strong><?php echo e($c->user->name); ?></strong> says:
        <p><?php echo e($c->body); ?></p>
      </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
      <p>No comments yet. Be the first to comment!</p>
    <?php endif; ?>
  </section>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/tournaments/show.blade.php ENDPATH**/ ?>