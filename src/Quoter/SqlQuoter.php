<?php

namespace Walnut\Lib\DbQueryBuilder\Quoter;

/**
 * @package Walnut\Lib\DbQueryBuilder
 */
interface SqlQuoter {
	public function quoteIdentifier(string $identifier): string;
	public function quoteValue(string|int|float|bool|null $value): string;
}
