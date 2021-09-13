<?php

use PHPUnit\Framework\TestCase;
use Walnut\Lib\DbQueryBuilder\Expression\AndExpression;
use Walnut\Lib\DbQueryBuilder\Expression\FieldExpression;
use Walnut\Lib\DbQueryBuilder\Expression\NotExpression;
use Walnut\Lib\DbQueryBuilder\Expression\OrExpression;
use Walnut\Lib\DbQueryBuilder\Expression\RawExpression;
use Walnut\Lib\DbQueryBuilder\Query\SelectQuery;
use Walnut\Lib\DbQueryBuilder\QueryPart\OrderByAscending;
use Walnut\Lib\DbQueryBuilder\QueryPart\OrderByDescending;
use Walnut\Lib\DbQueryBuilder\QueryPart\QueryFilter;
use Walnut\Lib\DbQueryBuilder\QueryPart\SelectLimit;
use Walnut\Lib\DbQueryBuilder\QueryPart\TableField;
use Walnut\Lib\DbQueryBuilder\QueryPart\TableJoin;
use Walnut\Lib\DbQueryBuilder\QueryValue\PlaceholderValue;
use Walnut\Lib\DbQueryBuilder\QueryValue\PreparedValue;
use Walnut\Lib\DbQueryBuilder\QueryValue\SqlQueryValue;
use Walnut\Lib\DbQueryBuilder\QueryValue\SqlValue;
use Walnut\Lib\DbQueryBuilder\Quoter\MysqlQuoter;

final class SelectQueryTest extends TestCase {

	public function testOk(): void {
		$sqb = new SelectQuery(
			"clients", [
				"id" => "id",
				"clientName" => "name",
				"special" => new SqlValue("SPECIAL")
			],
			[
				new TableJoin("p", "projects", new QueryFilter(
					new FieldExpression(
						new TableField("_", "id"),
						'=',
						new TableField("p", "client_id"),
					)
				))
			],
			new QueryFilter(
				new AndExpression(
					new OrExpression(
						new NotExpression(
							new FieldExpression('name', 'LIKE',
								new SqlValue("%test%"))
						),
						new FieldExpression('id', '>', new SqlValue(3))
					),
					new RawExpression("`name` NOT IN ('admin', 'dev')"),
					new FieldExpression('name', '!=', 'id'),
					new FieldExpression('name', 'NOT LIKE',
						new PlaceholderValue('blacklist'))
				)
			),
			[
				new OrderByAscending('id'),
				new OrderByDescending('name')
			],
			SelectLimit::forPage(3, 20)
		);
		$this->assertEquals(
			"SELECT _.`id`, _.`name` AS `clientName`, 'SPECIAL' AS `special` FROM `clients` AS _  JOIN `projects` `p` ON `_`.`id` = `p`.`client_id` WHERE ((NOT (`name` LIKE '%test%') OR `id` > 3) AND `name` NOT IN ('admin', 'dev') AND `name` != `id` AND `name` NOT LIKE **__blacklist__**) ORDER BY `id` ASC, `name` DESC LIMIT 40, 20",
			$sqb->build(new MysqlQuoter)
		);
	}

	public function testNoFields(): void {
		$this->expectException(InvalidArgumentException::class);
		new SelectQuery("clients", [], [],
			new QueryFilter(new RawExpression("1")));
	}

	public function testInvalidOp(): void {
		$this->expectException(InvalidArgumentException::class);
		new SelectQuery("clients", [], [],
			new QueryFilter(new FieldExpression("a", "INV", "b")));
	}

}