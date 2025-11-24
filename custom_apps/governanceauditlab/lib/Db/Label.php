<?php

declare(strict_types=1);

namespace OCA\GovernanceAuditLab\Db;

use OCP\AppFramework\Db\Entity;
use OCP\DB\Types;

/**
 * @method int getId()
 * @method void setId(int $id)
 * @method string getName()
 * @method void setName(string $name)
 * @method string|null getDescription()
 * @method void setDescription(?string $description)
 * @method string|null getCreatedBy()
 * @method void setCreatedBy(?string $createdBy)
 * @method \DateTimeImmutable|null getCreatedAt()
 * @method void setCreatedAt(?\DateTimeImmutable $createdAt)
 */
class Label extends Entity {
    protected string $name;
    protected ?string $description = null;
    protected ?string $createdBy = null;
    protected ?\DateTimeImmutable $createdAt = null;

    public function __construct() {
        $this->addType('id', Types::INTEGER);
        $this->addType('name', Types::STRING);
        $this->addType('description', Types::STRING);
        $this->addType('createdBy', Types::STRING);
        $this->addType('createdAt', Types::DATETIME_IMMUTABLE);
    }
}
