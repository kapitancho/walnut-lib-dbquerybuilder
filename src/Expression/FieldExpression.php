<?php

namespace Walnut\Lib\DbQueryBuilder\Expression;

use Walnut\Lib\DbQueryBuilder\QueryPart\TableField;
use Walnut\Lib\DbQueryBuilder\QueryValue\SqlQueryValue;
use Walnut\Lib\DbQueryBuilder\Quoter\SqlQuoter;

/**
 * @package Walnut\Lib\DbQueryBuilder
 */
final class FieldExpression implements SqlExpression {
	private const SQL_TEMPLATE = '%s %s %s';
	public function __construct(
		private readonly string|TableField $fieldName,
		private readonly FieldExpressionOperation $op,
		private readonly string|TableField|SqlQueryValue $value
	) {}

	public function build(SqlQuoter $quoter): string {
		return sprintf(self::SQL_TEMPLATE,
			is_string($this->fieldName) ?
				$quoter->quoteIdentifier($this->fieldName) :
				$this->fieldName->build($quoter),
			$this->op->value,
			is_string($this->value) ? $quoter->quoteIdentifier($this->value) :
				$this->value->build($quoter)
		);
	}

	public static function equals(
		string|TableField $fieldName,
		string|TableField|SqlQueryValue $value
	): self {
		return new self($fieldName, FieldExpressionOperation::equals, $value);
	}
}
