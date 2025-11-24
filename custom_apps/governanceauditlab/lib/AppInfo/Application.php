<?php

declare(strict_types=1);

namespace OCA\GovernanceAuditLab\AppInfo;

use OCP\AppFramework\App;
use OCP\AppFramework\Bootstrap\IBootContext;
use OCP\AppFramework\Bootstrap\IBootstrap;
use OCP\AppFramework\Bootstrap\IRegistrationContext;
//our db connectors for labels
use OCA\GovernanceAuditLab\Db\LabelMapper;
use OCP\IDBConnection;


class Application extends App implements IBootstrap {
	public const APP_ID = 'governanceauditlab';

	/** @psalm-suppress PossiblyUnusedMethod */
	public function __construct() {
		parent::__construct(self::APP_ID);
		$container = $this->getContainer();
		$container->registerService(LabelMapper::class, function($c) {
			/** @var IDBConnection $db */
			$db = $c->getServer()->get(IDBConnection::class);
			return new LabelMapper($db);
		});
	}

	public function register(IRegistrationContext $context): void {
	}

	public function boot(IBootContext $context): void {
	}
}
