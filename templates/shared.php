<div class="shared shared-bar is-hidden">
	<div class="shared-body">
		<div class="shared-content">
			<?php foreach ($services as $service => $url): ?>
				<div class="shared-item">
	        <a class="shared-link" href="<?= $url; ?>" target="_blank">
						<?= shared_icon($service); ?>
					</a>
	      </div>
			<?php endforeach; ?>
		</div>
		<div class="shared-toggler">
      <i class="fas fa-share-alt"></i>
    </div>
	</div>
</div>
