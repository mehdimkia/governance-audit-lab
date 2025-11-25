<?php

declare(strict_types=1);

use OCP\Util;

/** @var array $_ */

Util::addScript(OCA\GovernanceAuditLab\AppInfo\Application::APP_ID, OCA\GovernanceAuditLab\AppInfo\Application::APP_ID . '-main');
Util::addStyle(OCA\GovernanceAuditLab\AppInfo\Application::APP_ID, OCA\GovernanceAuditLab\AppInfo\Application::APP_ID . '-main');

/** @var \OCA\GovernanceAuditLab\Db\Label[] $labels */
$labels = $_['labels'] ?? [];

?>

<div id="governanceauditlab">
	<div class="section">
		<h1>Governance &amp; Audit Lab – Label Admin</h1>

		<h2>Create label</h2>
		<form method="post" action="/index.php/apps/governanceauditlab/labels/form">
			<p>
				<label for="label-name">Name</label><br>
				<input type="text" id="label-name" name="name" required maxlength="64">
			</p>
			<p>
				<label for="label-description">Description (optional)</label><br>
				<textarea id="label-description" name="description" rows="3"></textarea>
			</p>
			<p>
				<button type="submit" class="primary">Create label</button>
			</p>
		</form>

		<h2>Existing labels</h2>
		<?php if (empty($labels)): ?>
			<p>No labels defined yet.</p>
		<?php else: ?>
			<table class="grid">
				<thead>
					<tr>
						<th>ID</th>
						<th>Name</th>
						<th>Description</th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($labels as $label): ?>
					<tr>
						<td><?php p($label->getId()); ?></td>
						<td><?php p($label->getName()); ?></td>
						<td><?php p($label->getDescription()); ?></td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		<?php endif; ?>
	</div>
</div>
