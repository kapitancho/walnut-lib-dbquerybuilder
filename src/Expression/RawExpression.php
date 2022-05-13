<?php

namespace Walnut\Lib\DbQueryBuilder\Expression;

use Walnut\Lib\DbQueryBuilder\Quoter\SqlQuoter;

/**
 * @package Walnut\Lib\DbQueryBuilder
 */
final class RawExpression implements SqlExpression {
	public function __construct(private readonly string $rawValue) {}
	public function build(SqlQuoter $quoter): string {
		return $this->rawValue;
	}
}
