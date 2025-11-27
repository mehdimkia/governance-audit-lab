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

	public function find(int $id): ?Label {
		return $this->mapper->findById($id);
	}

	/**
	 * @throws \InvalidArgumentException
	 */
	public function create(string $name, ?string $description = null): Label {
		$name = $this->normalizeName($name);
		$this->assertNameValid($name);
		$this->assertNameUnique($name, null);

		$user = $this->userSession->getUser();
		$userId = $user ? $user->getUID() : null;

		$label = new Label();
		$label->setName($name);
		$label->setDescription($description);
		$label->setCreatedBy($userId);
		$label->setCreatedAt($this->clock->now());

		return $this->mapper->insert($label);
	}

	/**
	 * @throws \InvalidArgumentException
	 */
	public function update(int $id, string $name, ?string $description = null): Label {
		$name = $this->normalizeName($name);
		$this->assertNameValid($name);
		$this->assertNameUnique($name, $id);

		$label = $this->mapper->findById($id);
		if ($label === null) {
			throw new \InvalidArgumentException('Label not found.');
		}

		$label->setName($name);
		$label->setDescription($description);

		return $this->mapper->update($label);
	}

	public function delete(int $id): void {
		$label = $this->mapper->findById($id);
		if ($label === null) {
			return; // nothing to delete
		}
		$this->mapper->delete($label);
	}

	private function normalizeName(string $name): string {
		return trim($name);
	}

	/**
	 * @throws \InvalidArgumentException
	 */
	private function assertNameValid(string $name): void {
		if ($name === '') {
			throw new \InvalidArgumentException('Label name must not be empty.');
		}
		if (mb_strlen($name) > 64) {
			throw new \InvalidArgumentException('Label name must be at most 64 characters.');
		}
	}

	/**
	 * @param int|null $ignoreId label ID to ignore when checking uniqueness (for updates)
	 * @throws \InvalidArgumentException
	 */
	private function assertNameUnique(string $name, ?int $ignoreId): void {
		$existing = $this->mapper->findByName($name);
		if ($existing !== null && ($ignoreId === null || $existing->getId() !== $ignoreId)) {
			throw new \InvalidArgumentException('A label with this name already exists.');
		}
	}
}

