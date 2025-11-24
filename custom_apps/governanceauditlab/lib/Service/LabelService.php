<?php

declare(strict_types=1);

namespace OCA\GovernanceAuditLab\Service;

use OCA\GovernanceAuditLab\Db\Label;
use OCA\GovernanceAuditLab\Db\LabelMapper;
use OCP\IUserSession;
use Psr\Clock\ClockInterface;

class LabelService {

	public function __construct(
		private LabelMapper $mapper,
		private ClockInterface $clock,
		private IUserSession $userSession,
	) {
	}

	/**
	 * @return Label[]
	 */
	public function getAll(): array {
		return $this->mapper->findAll();
	}

	/**
	 * @throws \InvalidArgumentException on validation error
	 */
	public function create(string $name, ?string $description = null): Label {
		$name = trim($name);

		if ($name === '') {
			throw new \InvalidArgumentException('Label name must not be empty.');
		}

		if (mb_strlen($name) > 64) {
			throw new \InvalidArgumentException('Label name must be at most 64 characters.');
		}

		// enforce uniqueness on name
		$existing = $this->mapper->findByName($name);
		if ($existing !== null) {
			throw new \InvalidArgumentException('A label with this name already exists.');
		}

		$user = $this->userSession->getUser();
		$userId = $user ? $user->getUID() : null;

		$label = new Label();
		$label->setName($name);
		$label->setDescription($description);
		$label->setCreatedBy($userId);
		$label->setCreatedAt($this->clock->now()); // DateTimeImmutable

		return $this->mapper->insert($label);
	}
}
