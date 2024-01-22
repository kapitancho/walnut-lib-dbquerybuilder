<?php

use PHPUnit\Framework\TestCase;
use Walnut\Lib\DbQueryBuilder\Expression\RawExpression;
use Walnut\Lib\DbQueryBuilder\Query\DeleteQuery;
use Walnut\Lib\DbQueryBuilder\QueryPart\QueryFilter;
use Walnut\Lib\DbQueryBuilder\QueryValue\PreparedValue;
use Walnut\Lib\DbQueryBuilder\QueryValue\SqlValue;
use Walnut\Lib\DbQueryBuilder\Quoter\MysqlQuoter;
use Walnut\Lib\DbQueryBuilder\Quoter\SqliteQuoter;

final class QuoterTest extends TestCase {

	public function testMysqlOk(): void {
		$quoter = new MysqlQuoter;

		$this->assertEquals('`test`', $quoter->quoteIdentifier("test"));
		$this->assertEquals('`te``st`', $quoter->quoteIdentifier('te`st'));
		$this->assertEquals("'string'", $quoter->quoteValue("string"));
		$this->assertEquals("'str\\'ing'", $quoter->quoteValue("str'ing"));
		$this->assertEquals("'str\\\"ing'", $quoter->quoteValue("str\"ing"));
		$this->assertEquals("'str\\0ing'", $quoter->quoteValue("str\0ing"));
		$this->assertEquals("'str\\ning'", $quoter->quoteValue("str\ning"));
		$this->assertEquals("'str\\ring'", $quoter->quoteValue("str\ring"));
		$this->assertEquals("'str\\\\ing'", $quoter->quoteValue("str\\ing"));
		$this->assertEquals("3", $quoter->quoteValue(3));
		$this->assertEquals("3.14", $quoter->quoteValue(3.14));
		$this->assertEquals("NULL", $quoter->quoteValue(null));
		$this->assertEquals("0", $quoter->quoteValue(false));
		$this->assertEquals("1", $quoter->quoteValue(true));
	}

	public function testSqliteOk(): void {
		$quoter = new SqliteQuoter;

		$this->assertEquals('"test"', $quoter->quoteIdentifier("test"));
		$this->assertEquals('"te""st"', $quoter->quoteIdentifier('te"st'));
		$this->assertEquals("'string'", $quoter->quoteValue("string"));
		$this->assertEquals("'str''ing'", $quoter->quoteValue("str'ing"));
		$this->assertEquals("3", $quoter->quoteValue(3));
		$this->assertEquals("3.14", $quoter->quoteValue(3.14));
		$this->assertEquals("NULL", $quoter->quoteValue(null));
		$this->assertEquals("0", $quoter->quoteValue(false));
		$this->assertEquals("1", $quoter->quoteValue(true));
	}

}