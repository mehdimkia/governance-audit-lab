<?php

declare(strict_types=1);

/**
 * SPDX-FileCopyrightText: 2025 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */

namespace OCA\GovernanceAuditLab\Migration;

use Closure;
use OCP\DB\ISchemaWrapper;
use OCP\Migration\IOutput;
use OCP\Migration\SimpleMigrationStep;

/**
 * FIXME Auto-generated migration step: Please modify to your needs!
 */
class Version1000Date20251122114219 extends SimpleMigrationStep {

	/**
	 * @param IOutput $output
	 * @param Closure(): ISchemaWrapper $schemaClosure
	 * @param array $options
	 */
	public function preSchemaChange(IOutput $output, Closure $schemaClosure, array $options): void {
	}

	/**
	 * @param IOutput $output
	 * @param Closure(): ISchemaWrapper $schemaClosure
	 * @param array $options
	 * @return null|ISchemaWrapper
	 */
	public function changeSchema(IOutput $output, Closure $schemaClosure, array $options): ?ISchemaWrapper {
		 /** @var ISchemaWrapper $schema */
		 $schema = $schemaClosure();

		 // If the table already exists (e.g. reinstall), do nothing
		 if ($schema->hasTable('gal_labels')) {
			 return null;
		 }
	 
		 $table = $schema->createTable('gal_labels');
	 
		 $table->addColumn('id', 'integer', [
			 'autoincrement' => true,
			 'notnull'       => true,
		 ]);
	 
		 $table->addColumn('name', 'string', [
			 'length'  => 64,
			 'notnull' => true,
		 ]);
	 
		 $table->addColumn('description', 'text', [
			 'notnull' => false,
		 ]);
	 
		 $table->addColumn('created_by', 'string', [
			 'length'  => 64,
			 'notnull' => false,
		 ]);
	 
		 $table->addColumn('created_at', 'datetime', [
			 'notnull' => false,
		 ]);
	 
		 $table->setPrimaryKey(['id']);
		 $table->addUniqueIndex(['name'], 'gal_label_name_idx');
	 
		 return $schema;
	}

	/**
	 * @param IOutput $output
	 * @param Closure(): ISchemaWrapper $schemaClosure
	 * @param array $options
	 */
	public function postSchemaChange(IOutput $output, Closure $schemaClosure, array $options): void {
	}
}
