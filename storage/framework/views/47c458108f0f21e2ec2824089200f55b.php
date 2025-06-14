<?php $__env->startSection('content'); ?>
  <h2>Create Tournament Archive</h2>

  <style>
    /* Full-screen bracket container */
    #matchups-container {
      display: flex;
      width: 100%;
      overflow-x: auto;
      padding-bottom: 2em;
      margin-bottom: 2em;
    }
    .bracket-round {
      display: flex;
      flex-direction: column;
      justify-content: space-around;
      flex: 0 0 auto;
      margin: 0 1em;
    }
    .matchup-block {
      border: 1px solid #ccc;
      border-radius: 0.5em;
      width: 200px;
      padding: 0.5em;
      position: relative;
      background: #fff;
      box-shadow: 0 0.5em 1em rgba(0,0,0,0.1);
    }
    .matchup-block input {
      width: 100%;
      box-sizing: border-box;
      margin-bottom: 0.25em;
      padding: 0.25em;
    }
    .matchup-block::after {
      content: '';
      position: absolute;
      right: -10px;
      top: 50%;
      width: 20px;
      height: 2px;
      background: #ccc;
    }
    /* Hide connector on last round */
    #matchups-container .bracket-round:last-child .matchup-block::after {
      display: none;
    }
  </style>

    <?php if($errors->any()): ?>
      <div class="alert error" style="margin-bottom:1em;">
        <strong>Whoops!</strong> There were some problems with your input:
        <ul>
          <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li><?php echo e($error); ?></li>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
      </div>
    <?php endif; ?>


  <form method="POST" action="<?php echo e(route('tournaments.store')); ?>">
    <?php echo csrf_field(); ?>

    <!-- Title -->
    <div class="field">
      <label for="title">Tournament Title</label>
      <input type="text" name="title" id="title" required />
    </div>

    <!-- Description -->
    <div class="field">
      <label for="description">Description</label>
      <textarea name="description" id="description" rows="4" required></textarea>
    </div>

    <!-- Prize Pool -->
    <div class="field half">
      <label for="prize_pool">Prize Pool</label>
      <input type="number" name="prize_pool" id="prize_pool" step="0.01" placeholder="e.g. 500.00" />
    </div>

    <!-- Tournament Type -->
    <div class="field half">
      <label for="tournament_type">Tournament Type</label>
      <select name="tournament_type" id="tournament_type" required>
        <option value="">Select type…</option>
        <option value="Online">Online</option>
        <option value="Offline">Offline</option>
        <option value="Hybrid">Hybrid</option>
      </select>
    </div>

    <!-- Location -->
    <div class="field">
      <label for="location">Location (optional)</label>
      <input type="text" name="location" id="location" placeholder="City, Country" />
    </div>       

    <!-- Bracket Size & Competition Type -->
    <div class="field half">
      <label for="bracket_size">Bracket Size</label>
      <select name="bracket_size" id="bracket_size">
        <option value="32">Round of 32</option>
        <option value="16">Round of 16</option>
        <option value="8">Quarterfinals</option>
        <option value="4">Semifinals</option>
        <option value="2">Final</option>
      </select>
    </div>
    <div class="field half">
      <label>Competition Type</label>
      <div>
        <label><input type="radio" name="competition_type" value="1v1"> 1v1</label>
        <label><input type="radio" name="competition_type" value="2v2"> 2v2</label>
        <label><input type="radio" name="competition_type" value="4v4"> 4v4</label>
      </div>
    </div>

    <!-- Dynamic Bracket -->
    <section class="box">
      <header><h3>Bracket</h3></header>
      <div id="matchups-container"></div>
    </section>

    <!-- Sources -->
    <section class="box">
      <header><h3>Sources</h3></header>
      <div class="field">
        <label for="stream_url">Stream URL</label>
        <input type="url" name="sources[0][stream_url]" id="stream_url" />
      </div>
      <div class="field">
        <label for="video_url">Video URL</label>
        <input type="url" name="sources[0][video_url]" id="video_url" />
      </div>
      <div class="field">
        <label for="forum_url">Forum URL</label>
        <input type="url" name="sources[0][forum_url]" id="forum_url" />
      </div>
    </section>

    <ul class="actions">
      <li><button type="submit" class="button big">Submit Tournament</button></li>
    </ul>
  </form>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const container = document.getElementById('matchups-container');
      const bracketSelect = document.getElementById('bracket_size');

      function renderBracket() {
        container.innerHTML = '';
        const size = parseInt(bracketSelect.value, 10);
        const rounds = Math.log2(size);

        for (let r = 0; r < rounds; r++) {
          const roundDiv = document.createElement('div');
          roundDiv.classList.add('bracket-round');
          const matchCount = size / Math.pow(2, r + 1);

          for (let m = 0; m < matchCount; m++) {
            const block = document.createElement('div');
            block.classList.add('matchup-block');
            block.innerHTML = `
              <input type="text" name="matchups[${r}][${m}][player1_name]" placeholder="Player 1" required />
              <input type="number" name="matchups[${r}][${m}][player1_score]" placeholder="Score" min="0" />
              <input type="text" name="matchups[${r}][${m}][player2_name]" placeholder="Player 2" required />
              <input type="number" name="matchups[${r}][${m}][player2_score]" placeholder="Score" min="0" />
            `;
            roundDiv.appendChild(block);
          }
          container.appendChild(roundDiv);
        }
      }

      bracketSelect.addEventListener('change', renderBracket);
      renderBracket();
    });
  </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/tournaments/create.blade.php ENDPATH**/ ?>