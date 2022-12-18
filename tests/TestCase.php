<?php

namespace Tests;

use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\Grammars\SQLiteGrammar as QueryGrammar;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use \Illuminate\Database\SQLiteConnection;
use Illuminate\Support\Str;
use \Illuminate\Database\Schema\{SQLiteBuilder, Blueprint};
use \Illuminate\Support\Fluent;
use Illuminate\Database\Connection;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed('TestDatabaseSeeder');
    }

    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->hotfixSqlite();
    }

    public function hotfixSqlite()
    {
        Connection::resolverFor('sqlite', function ($connection, $database, $prefix, $config) {
            return new class($connection, $database, $prefix, $config) extends SQLiteConnection {
                /**
                 * Нашел такой костыль. Пробелма была в том, что:
                 *
                 * BadMethodCallException: SQLite doesn't support dropping foreign keys (you would need to re-create the table).
                 */
                public function getSchemaBuilder()
                {
                    if ($this->schemaGrammar === null) {
                        $this->useDefaultSchemaGrammar();
                    }

                    return new class($this) extends SQLiteBuilder {
                        protected function createBlueprint($table, \Closure $callback = null)
                        {
                            return new class($table, $callback) extends Blueprint {
                                public function dropForeign($index)
                                {
                                    return new Fluent();
                                }
                            };
                        }
                    };
                }

                /**
                 * Расширение SQLite для возможности поиска без учета регистра.
                 * ilike, т.к. основная БД PostgresSQL, а в ней это стандартный метод.
                 *
                 * @return \Illuminate\Database\Grammar|QueryGrammar
                 */
                public function getDefaultQueryGrammar()
                {
                    $grammarClass = new class() extends QueryGrammar {
                        /**
                         * @param Builder $query
                         * @param array $where
                         * @return string
                         */
                        protected function whereBasic(Builder $query, $where): string
                        {
                            if (Str::contains(strtolower($where['operator']), 'ilike') === true) {
                                $format = 'lower(%s) %s %s';
                                $wrap = $this->wrap($where['column']);
                                $operator = 'like';
                                $value = $this->parameter($where['value']);

                                return sprintf($format, $wrap, $operator, $value);
                            }

                            return parent::whereBasic($query, $where);
                        }
                    };

                    return $this->withTablePrefix($grammarClass);
                }
            };
        });
    }
}
