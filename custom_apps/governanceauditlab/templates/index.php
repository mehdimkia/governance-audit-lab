<?php

declare(strict_types=1);

use OCP\Util;

Util::addScript(OCA\GovernanceAuditLab\AppInfo\Application::APP_ID, OCA\GovernanceAuditLab\AppInfo\Application::APP_ID . '-main');
Util::addStyle(OCA\GovernanceAuditLab\AppInfo\Application::APP_ID, OCA\GovernanceAuditLab\AppInfo\Application::APP_ID . '-main');

?>

<div id="governanceauditlab"></div>
