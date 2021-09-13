<?php

namespace Walnut\Lib\DbQueryBuilder\Expression;

use Walnut\Lib\DbQueryBuilder\QueryPart\TableField;
use Walnut\Lib\DbQueryBuilder\QueryValue\SqlQueryValue;
use Walnut\Lib\DbQueryBuilder\Quoter\SqlQuoter;

/**
 * @package Walnut\Lib\DbQueryBuilder
 */
final class FieldExpression implements SqlExpression {
	public const VALID_OPS = ['=', '<=>', '!=', '<>', '<', '>', 'LIKE', 'NOT LIKE', 'REGEXP']; //TODO: 8.1 ENUM
	private const SQL_TEMPLATE = '%s %s %s';
	public function __construct(
		private /*readonly*/ string|TableField $fieldName,
		private /*readonly*/ string $op,
		private /*readonly*/ string|TableField|SqlQueryValue $value
	) {
		if (!in_array($this->op, self::VALID_OPS)) {
			throw new \InvalidArgumentException("Invalid expression operation: $this->op");
		}
	}

	public function build(SqlQuoter $quoter): string {
		return sprintf(self::SQL_TEMPLATE,
			is_string($this->fieldName) ?
				$quoter->quoteIdentifier($this->fieldName) :
				$this->fieldName->build($quoter),
			$this->op,
			is_string($this->value) ? $quoter->quoteIdentifier($this->value) :
				$this->value->build($quoter)
		);
	}
}
