<?php

declare(strict_types=1);

namespace OCA\GovernanceAuditLab\Db;

use OCP\AppFramework\Db\QBMapper;
use OCP\DB\QueryBuilder\IQueryBuilder;
use OCP\IDBConnection;

/**
 * @extends QBMapper<Label>
 */
class LabelMapper extends QBMapper {

	public function __construct(IDBConnection $db) {
		// 'gal_labels' is the table name from our migration (without prefix)
		parent::__construct($db, 'gal_labels', Label::class);
	}

	/**
	 * @return Label[]
	 */
	public function findAll(): array {
		$qb = $this->db->getQueryBuilder();
		$qb->select('*')
			->from($this->getTableName())
			->orderBy('name', 'ASC');

		/** @var Label[] $labels */
		$labels = $this->findEntities($qb);
		return $labels;
	}

	public function findByName(string $name): ?Label {
		$qb = $this->db->getQueryBuilder();
		$qb->select('*')
			->from($this->getTableName())
			->where(
				$qb->expr()->eq('name', $qb->createNamedParameter($name))
			)
			->setMaxResults(1);

		/** @var Label[] $labels */
		$labels = $this->findEntities($qb);

		return $labels[0] ?? null;
	}

	public function findById(int $id): ?Label {
		$qb = $this->db->getQueryBuilder();
		$qb->select('*')
			->from($this->getTableName())
			->where(
				$qb->expr()->eq('id', $qb->createNamedParameter($id, IQueryBuilder::PARAM_INT))
			)
			->setMaxResults(1);
	
		/** @var Label[] $labels */
		$labels = $this->findEntities($qb);
		return $labels[0] ?? null;
	}
	
}
