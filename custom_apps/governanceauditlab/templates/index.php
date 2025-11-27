<?php

declare(strict_types=1);

use OCP\Util;
use OCA\GovernanceAuditLab\AppInfo\Application;

/** @var array $_ */

Util::addScript(Application::APP_ID, Application::APP_ID . '-main');
Util::addStyle(Application::APP_ID, 'admin');

/** @var \OCA\GovernanceAuditLab\Db\Label[] $labels */
$labels = $_['labels'] ?? [];

/** @var \OCA\GovernanceAuditLab\Db\Label|null $editLabel */
$editLabel = $_['editLabel'] ?? null;

?>

<div id="governanceauditlab">
	<div class="gal-card">
		<header class="gal-header">
			<h1>Governance &amp; Audit Lab</h1>
			<p class="gal-subtitle">
				Configure and review classification labels for your files.
			</p>
		</header>

		<div class="gal-layout">
			<section class="gal-column gal-form">
				<h2>Create label</h2>
				<form method="post" action="/index.php/apps/governanceauditlab/labels/form">
					<div class="gal-field">
						<label for="label-name">Name</label>
						<input type="text" id="label-name" name="name" required maxlength="64">
						<p class="gal-help">Short, human-readable label. Example: <em>Confidential</em>, <em>Public</em>.</p>
					</div>

					<div class="gal-field">
						<label for="label-description">Description (optional)</label>
						<textarea id="label-description" name="description" rows="3"></textarea>
						<p class="gal-help">Describe how this label should be used.</p>
					</div>

					<div class="gal-actions">
						<button type="submit" class="primary">Create label</button>
					</div>
				</form>

				<?php if ($editLabel !== null): ?>
					<section class="gal-edit">
						<h2>Edit label</h2>
						<form method="post" action="/index.php/apps/governanceauditlab/labels/update">
							<input type="hidden" name="id" value="<?php p($editLabel->getId()); ?>">

							<div class="gal-field">
								<label for="edit-label-name">Name</label>
								<input type="text" id="edit-label-name" name="name"
								       value="<?php p($editLabel->getName()); ?>" required maxlength="64">
							</div>

							<div class="gal-field">
								<label for="edit-label-description">Description (optional)</label>
								<textarea id="edit-label-description" name="description" rows="3"><?php p($editLabel->getDescription()); ?></textarea>
							</div>

							<div class="gal-actions">
								<button type="submit" class="primary">Save changes</button>
								<a href="/index.php/apps/governanceauditlab/" class="button gal-small-btn">Cancel</a>
							</div>
						</form>
					</section>
				<?php endif; ?>
			</section>

			<section class="gal-column gal-table">
				<h2>Existing labels</h2>

				<?php if (empty($labels)): ?>
					<p class="gal-empty">No labels defined yet.</p>
				<?php else: ?>
					<table class="grid gal-label-table">
						<thead>
						<tr>
							<th>ID</th>
							<th>Name</th>
							<th>Description</th>
							<th class="gal-actions-cell">Actions</th>
						</tr>
						</thead>
						<tbody>
						<?php foreach ($labels as $label): ?>
							<tr>
								<td><?php p($label->getId()); ?></td>
								<td class="gal-label-name"><?php p($label->getName()); ?></td>
								<td><?php p($label->getDescription()); ?></td>
								<td class="gal-actions-cell">
									<a href="/index.php/apps/governanceauditlab/?editId=<?php p($label->getId()); ?>"
									   class="button gal-small-btn">Edit</a>

									<form method="post"
									      action="/index.php/apps/governanceauditlab/labels/delete"
									      class="gal-inline-form">
										<input type="hidden" name="id" value="<?php p($label->getId()); ?>">
										<button type="submit" class="button gal-small-btn gal-danger-btn">
											Delete
										</button>
									</form>
								</td>
							</tr>
						<?php endforeach; ?>
						</tbody>
					</table>
				<?php endif; ?>
			</section>
		</div>
	</div>
</div>
