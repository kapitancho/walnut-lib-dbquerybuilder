<?php

namespace Walnut\Lib\DbQueryBuilder\Expression;

use Walnut\Lib\DbQueryBuilder\Quoter\SqlQuoter;

/**
 * @package Walnut\Lib\DbQueryBuilder
 */
final class OrExpression implements SqlExpression {
	/**
	 * @var SqlExpression[]
	 */
	private readonly array $expressions;
	public function __construct(SqlExpression ...$expressions) {
		$this->expressions = $expressions;
	}
	public function build(SqlQuoter $quoter): string {
		return '(' . (count($this->expressions) > 0 ?
			implode(' OR ', array_map(
				static fn(SqlExpression $expression): string =>
					$expression->build($quoter),
				$this->expressions
			))
		: '0') . ')';
	}
}
