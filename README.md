# Query Builder
Lightweight Select, Insert, Update and Delete query builders.

## Examples

### Some common objects:
```php
$quoter = new MysqlQuoter;

$queryFilter = new QueryFilter(
    new AndExpression(
        new OrExpression(
            new NotExpression(
                new FieldExpression('name', 'LIKE',
                    new SqlValue("%test%"))
            ),
            new FieldExpression('id', '>', new SqlValue(3))
        ),
        new RawExpression("`name` NOT IN ('admin', 'dev')"),
        new FieldExpression('name', '!=', 'id')
    )
);
```

Insert Query:
```php
$iqb = new InsertQuery(
    "clients", [
        "id" => new SqlValue(7),
        "name" => new SqlValue('Client 7')
    ]
);
echo $iqb->build($quoter), PHP_EOL;
```

Update Query
```php
$uqb = new UpdateQuery(
    "clients", [
        "id" => new PreparedValue('id'),
        "name" => new SqlValue('Client 7')
    ],
    $queryFilter
);
echo $uqb->build($quoter), PHP_EOL;
```

Select Query
```php
$sqb = new SelectQuery(
    "clients", [
        "id" => "id",
        "clientName" => "name"
    ],
    [
        new TableJoin("p", "projects", new QueryFilter(
            FieldExpression::equals(
                new TableField("_", "id"),
                new TableField("p", "client_id"),
            )
        ))
    ],
    $queryFilter,
    [
        OrderBy::ascending('id'),
        OrderBy::descending('name')
    ],
    SelectLimit::forPage(3, 20)
);
echo $sqb->build($quoter), PHP_EOL;
```

Delete Query
```php
$dqb = new DeleteQuery(
    "clients", $qf
);
echo $dqb->build($quoter), PHP_EOL;
```