<?php

namespace Walnut\Lib\DbQueryBuilder\QueryValue;

use Walnut\Lib\DbQueryBuilder\Quoter\SqlQuoter;

/**
 * @package Walnut\Lib\DbQueryBuilder
 */
final class SqlValue implements SqlQueryValue {
	public function __construct(private /*readonly*/ int|float|string|bool|null $value) {}

	public function build(SqlQuoter $quoter): string {
		return $quoter->quoteValue($this->value);
	}
}
