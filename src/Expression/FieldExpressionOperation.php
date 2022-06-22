<?php

namespace Walnut\Lib\DbQueryBuilder\Expression;

/**
 * @package Walnut\Lib\DbQueryBuilder
 */
enum FieldExpressionOperation: string {
	case equals = '=';
	case nullSafeEquals = '<=>';
	case notEquals = '!=';
	case lessThan = '<';
	case lessOrEquals = '<=';
	case greaterThan = '>';
	case greaterOrEquals = '>=';
	case like = 'LIKE';
	case notLike = 'NOT LIKE';
	case regexp = 'REGEXP';
}
