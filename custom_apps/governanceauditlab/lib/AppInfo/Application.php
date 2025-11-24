<?php

declare(strict_types=1);

namespace OCA\GovernanceAuditLab\AppInfo;

use OCP\AppFramework\App;
use OCP\AppFramework\Bootstrap\IBootContext;
use OCP\AppFramework\Bootstrap\IBootstrap;
use OCP\AppFramework\Bootstrap\IRegistrationContext;

// our db connectors for labels
use OCA\GovernanceAuditLab\Db\LabelMapper;
use OCP\IDBConnection;

use OCA\GovernanceAuditLab\Service\LabelService;
use OCP\IUserSession;
use Psr\Clock\ClockInterface;

/**
 * @psalm-suppress UnusedClass
 */
class Application extends App implements IBootstrap {
	public const APP_ID = 'governanceauditlab';

	/** @psalm-suppress PossiblyUnusedMethod */
	public function __construct() {
		parent::__construct(self::APP_ID);

		$container = $this->getContainer();

		// Register LabelMapper
		$container->registerService(LabelMapper::class, function ($c) {
			/** @var IDBConnection $db */
			$db = $c->getServer()->get(IDBConnection::class);
			return new LabelMapper($db);
		});

		// Register LabelService
		$container->registerService(LabelService::class, function ($c) {
			/** @var ClockInterface $clock */
			$clock = $c->getServer()->get(ClockInterface::class);
			/** @var IUserSession $userSession */
			$userSession = $c->getServer()->get(IUserSession::class);

			return new LabelService(
				$c->get(LabelMapper::class),
				$clock,
				$userSession,
			);
		});
	}

	public function register(IRegistrationContext $context): void {
		// You can register event listeners, middlewares, etc. here later if needed.
	}

	public function boot(IBootContext $context): void {
		// Runtime boot logic can go here if needed.
	}
}
