<?php

namespace Base;

use \Alert as ChildAlert;
use \AlertQuery as ChildAlertQuery;
use \Exception;
use \PDO;
use Map\AlertTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'alert' table.
 *
 *
 *
 * @method     ChildAlertQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildAlertQuery orderByMessage($order = Criteria::ASC) Order by the message column
 * @method     ChildAlertQuery orderByTimestamp($order = Criteria::ASC) Order by the timestamp column
 * @method     ChildAlertQuery orderBySensorstationId($order = Criteria::ASC) Order by the sensorstation_id column
 *
 * @method     ChildAlertQuery groupById() Group by the id column
 * @method     ChildAlertQuery groupByMessage() Group by the message column
 * @method     ChildAlertQuery groupByTimestamp() Group by the timestamp column
 * @method     ChildAlertQuery groupBySensorstationId() Group by the sensorstation_id column
 *
 * @method     ChildAlertQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildAlertQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildAlertQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildAlertQuery leftJoinSensorstation($relationAlias = null) Adds a LEFT JOIN clause to the query using the Sensorstation relation
 * @method     ChildAlertQuery rightJoinSensorstation($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Sensorstation relation
 * @method     ChildAlertQuery innerJoinSensorstation($relationAlias = null) Adds a INNER JOIN clause to the query using the Sensorstation relation
 *
 * @method     \SensorstationQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildAlert findOne(ConnectionInterface $con = null) Return the first ChildAlert matching the query
 * @method     ChildAlert findOneOrCreate(ConnectionInterface $con = null) Return the first ChildAlert matching the query, or a new ChildAlert object populated from the query conditions when no match is found
 *
 * @method     ChildAlert findOneById(int $id) Return the first ChildAlert filtered by the id column
 * @method     ChildAlert findOneByMessage(string $message) Return the first ChildAlert filtered by the message column
 * @method     ChildAlert findOneByTimestamp(string $timestamp) Return the first ChildAlert filtered by the timestamp column
 * @method     ChildAlert findOneBySensorstationId(int $sensorstation_id) Return the first ChildAlert filtered by the sensorstation_id column
 *
 * @method     ChildAlert[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildAlert objects based on current ModelCriteria
 * @method     ChildAlert[]|ObjectCollection findById(int $id) Return ChildAlert objects filtered by the id column
 * @method     ChildAlert[]|ObjectCollection findByMessage(string $message) Return ChildAlert objects filtered by the message column
 * @method     ChildAlert[]|ObjectCollection findByTimestamp(string $timestamp) Return ChildAlert objects filtered by the timestamp column
 * @method     ChildAlert[]|ObjectCollection findBySensorstationId(int $sensorstation_id) Return ChildAlert objects filtered by the sensorstation_id column
 * @method     ChildAlert[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class AlertQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \Base\AlertQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'smojedb', $modelName = '\\Alert', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildAlertQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildAlertQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildAlertQuery) {
            return $criteria;
        }
        $query = new ChildAlertQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildAlert|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = AlertTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(AlertTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildAlert A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, message, timestamp, sensorstation_id FROM alert WHERE id = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildAlert $obj */
            $obj = new ChildAlert();
            $obj->hydrate($row);
            AlertTableMap::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildAlert|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildAlertQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(AlertTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildAlertQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(AlertTableMap::COL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAlertQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(AlertTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(AlertTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AlertTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the message column
     *
     * Example usage:
     * <code>
     * $query->filterByMessage('fooValue');   // WHERE message = 'fooValue'
     * $query->filterByMessage('%fooValue%'); // WHERE message LIKE '%fooValue%'
     * </code>
     *
     * @param     string $message The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAlertQuery The current query, for fluid interface
     */
    public function filterByMessage($message = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($message)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $message)) {
                $message = str_replace('*', '%', $message);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AlertTableMap::COL_MESSAGE, $message, $comparison);
    }

    /**
     * Filter the query on the timestamp column
     *
     * Example usage:
     * <code>
     * $query->filterByTimestamp('2011-03-14'); // WHERE timestamp = '2011-03-14'
     * $query->filterByTimestamp('now'); // WHERE timestamp = '2011-03-14'
     * $query->filterByTimestamp(array('max' => 'yesterday')); // WHERE timestamp > '2011-03-13'
     * </code>
     *
     * @param     mixed $timestamp The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAlertQuery The current query, for fluid interface
     */
    public function filterByTimestamp($timestamp = null, $comparison = null)
    {
        if (is_array($timestamp)) {
            $useMinMax = false;
            if (isset($timestamp['min'])) {
                $this->addUsingAlias(AlertTableMap::COL_TIMESTAMP, $timestamp['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($timestamp['max'])) {
                $this->addUsingAlias(AlertTableMap::COL_TIMESTAMP, $timestamp['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AlertTableMap::COL_TIMESTAMP, $timestamp, $comparison);
    }

    /**
     * Filter the query on the sensorstation_id column
     *
     * Example usage:
     * <code>
     * $query->filterBySensorstationId(1234); // WHERE sensorstation_id = 1234
     * $query->filterBySensorstationId(array(12, 34)); // WHERE sensorstation_id IN (12, 34)
     * $query->filterBySensorstationId(array('min' => 12)); // WHERE sensorstation_id > 12
     * </code>
     *
     * @see       filterBySensorstation()
     *
     * @param     mixed $sensorstationId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAlertQuery The current query, for fluid interface
     */
    public function filterBySensorstationId($sensorstationId = null, $comparison = null)
    {
        if (is_array($sensorstationId)) {
            $useMinMax = false;
            if (isset($sensorstationId['min'])) {
                $this->addUsingAlias(AlertTableMap::COL_SENSORSTATION_ID, $sensorstationId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($sensorstationId['max'])) {
                $this->addUsingAlias(AlertTableMap::COL_SENSORSTATION_ID, $sensorstationId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AlertTableMap::COL_SENSORSTATION_ID, $sensorstationId, $comparison);
    }

    /**
     * Filter the query by a related \Sensorstation object
     *
     * @param \Sensorstation|ObjectCollection $sensorstation The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildAlertQuery The current query, for fluid interface
     */
    public function filterBySensorstation($sensorstation, $comparison = null)
    {
        if ($sensorstation instanceof \Sensorstation) {
            return $this
                ->addUsingAlias(AlertTableMap::COL_SENSORSTATION_ID, $sensorstation->getId(), $comparison);
        } elseif ($sensorstation instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AlertTableMap::COL_SENSORSTATION_ID, $sensorstation->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterBySensorstation() only accepts arguments of type \Sensorstation or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Sensorstation relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildAlertQuery The current query, for fluid interface
     */
    public function joinSensorstation($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Sensorstation');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Sensorstation');
        }

        return $this;
    }

    /**
     * Use the Sensorstation relation Sensorstation object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \SensorstationQuery A secondary query class using the current class as primary query
     */
    public function useSensorstationQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSensorstation($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Sensorstation', '\SensorstationQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildAlert $alert Object to remove from the list of results
     *
     * @return $this|ChildAlertQuery The current query, for fluid interface
     */
    public function prune($alert = null)
    {
        if ($alert) {
            $this->addUsingAlias(AlertTableMap::COL_ID, $alert->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the alert table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AlertTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            AlertTableMap::clearInstancePool();
            AlertTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AlertTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(AlertTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            AlertTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            AlertTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // AlertQuery
