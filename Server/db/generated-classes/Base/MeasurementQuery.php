<?php

namespace Base;

use \Measurement as ChildMeasurement;
use \MeasurementQuery as ChildMeasurementQuery;
use \Exception;
use \PDO;
use Map\MeasurementTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'measurement' table.
 *
 *
 *
 * @method     ChildMeasurementQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildMeasurementQuery orderByTimestamp($order = Criteria::ASC) Order by the timestamp column
 * @method     ChildMeasurementQuery orderByValue($order = Criteria::ASC) Order by the value column
 * @method     ChildMeasurementQuery orderBySensorId($order = Criteria::ASC) Order by the sensor_id column
 * @method     ChildMeasurementQuery orderByStationId($order = Criteria::ASC) Order by the station_id column
 *
 * @method     ChildMeasurementQuery groupById() Group by the id column
 * @method     ChildMeasurementQuery groupByTimestamp() Group by the timestamp column
 * @method     ChildMeasurementQuery groupByValue() Group by the value column
 * @method     ChildMeasurementQuery groupBySensorId() Group by the sensor_id column
 * @method     ChildMeasurementQuery groupByStationId() Group by the station_id column
 *
 * @method     ChildMeasurementQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildMeasurementQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildMeasurementQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildMeasurementQuery leftJoinSensor($relationAlias = null) Adds a LEFT JOIN clause to the query using the Sensor relation
 * @method     ChildMeasurementQuery rightJoinSensor($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Sensor relation
 * @method     ChildMeasurementQuery innerJoinSensor($relationAlias = null) Adds a INNER JOIN clause to the query using the Sensor relation
 *
 * @method     ChildMeasurementQuery leftJoinStation($relationAlias = null) Adds a LEFT JOIN clause to the query using the Station relation
 * @method     ChildMeasurementQuery rightJoinStation($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Station relation
 * @method     ChildMeasurementQuery innerJoinStation($relationAlias = null) Adds a INNER JOIN clause to the query using the Station relation
 *
 * @method     \SensorQuery|\StationQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildMeasurement findOne(ConnectionInterface $con = null) Return the first ChildMeasurement matching the query
 * @method     ChildMeasurement findOneOrCreate(ConnectionInterface $con = null) Return the first ChildMeasurement matching the query, or a new ChildMeasurement object populated from the query conditions when no match is found
 *
 * @method     ChildMeasurement findOneById(int $id) Return the first ChildMeasurement filtered by the id column
 * @method     ChildMeasurement findOneByTimestamp(string $timestamp) Return the first ChildMeasurement filtered by the timestamp column
 * @method     ChildMeasurement findOneByValue(string $value) Return the first ChildMeasurement filtered by the value column
 * @method     ChildMeasurement findOneBySensorId(int $sensor_id) Return the first ChildMeasurement filtered by the sensor_id column
 * @method     ChildMeasurement findOneByStationId(int $station_id) Return the first ChildMeasurement filtered by the station_id column
 *
 * @method     ChildMeasurement[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildMeasurement objects based on current ModelCriteria
 * @method     ChildMeasurement[]|ObjectCollection findById(int $id) Return ChildMeasurement objects filtered by the id column
 * @method     ChildMeasurement[]|ObjectCollection findByTimestamp(string $timestamp) Return ChildMeasurement objects filtered by the timestamp column
 * @method     ChildMeasurement[]|ObjectCollection findByValue(string $value) Return ChildMeasurement objects filtered by the value column
 * @method     ChildMeasurement[]|ObjectCollection findBySensorId(int $sensor_id) Return ChildMeasurement objects filtered by the sensor_id column
 * @method     ChildMeasurement[]|ObjectCollection findByStationId(int $station_id) Return ChildMeasurement objects filtered by the station_id column
 * @method     ChildMeasurement[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class MeasurementQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \Base\MeasurementQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'smojedb', $modelName = '\\Measurement', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildMeasurementQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildMeasurementQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildMeasurementQuery) {
            return $criteria;
        }
        $query = new ChildMeasurementQuery();
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
     * @return ChildMeasurement|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = MeasurementTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(MeasurementTableMap::DATABASE_NAME);
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
     * @return ChildMeasurement A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, timestamp, value, sensor_id, station_id FROM measurement WHERE id = :p0';
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
            /** @var ChildMeasurement $obj */
            $obj = new ChildMeasurement();
            $obj->hydrate($row);
            MeasurementTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildMeasurement|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildMeasurementQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(MeasurementTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildMeasurementQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(MeasurementTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildMeasurementQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(MeasurementTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(MeasurementTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MeasurementTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildMeasurementQuery The current query, for fluid interface
     */
    public function filterByTimestamp($timestamp = null, $comparison = null)
    {
        if (is_array($timestamp)) {
            $useMinMax = false;
            if (isset($timestamp['min'])) {
                $this->addUsingAlias(MeasurementTableMap::COL_TIMESTAMP, $timestamp['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($timestamp['max'])) {
                $this->addUsingAlias(MeasurementTableMap::COL_TIMESTAMP, $timestamp['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MeasurementTableMap::COL_TIMESTAMP, $timestamp, $comparison);
    }

    /**
     * Filter the query on the value column
     *
     * Example usage:
     * <code>
     * $query->filterByValue('fooValue');   // WHERE value = 'fooValue'
     * $query->filterByValue('%fooValue%'); // WHERE value LIKE '%fooValue%'
     * </code>
     *
     * @param     string $value The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMeasurementQuery The current query, for fluid interface
     */
    public function filterByValue($value = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($value)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $value)) {
                $value = str_replace('*', '%', $value);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(MeasurementTableMap::COL_VALUE, $value, $comparison);
    }

    /**
     * Filter the query on the sensor_id column
     *
     * Example usage:
     * <code>
     * $query->filterBySensorId(1234); // WHERE sensor_id = 1234
     * $query->filterBySensorId(array(12, 34)); // WHERE sensor_id IN (12, 34)
     * $query->filterBySensorId(array('min' => 12)); // WHERE sensor_id > 12
     * </code>
     *
     * @see       filterBySensor()
     *
     * @param     mixed $sensorId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMeasurementQuery The current query, for fluid interface
     */
    public function filterBySensorId($sensorId = null, $comparison = null)
    {
        if (is_array($sensorId)) {
            $useMinMax = false;
            if (isset($sensorId['min'])) {
                $this->addUsingAlias(MeasurementTableMap::COL_SENSOR_ID, $sensorId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($sensorId['max'])) {
                $this->addUsingAlias(MeasurementTableMap::COL_SENSOR_ID, $sensorId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MeasurementTableMap::COL_SENSOR_ID, $sensorId, $comparison);
    }

    /**
     * Filter the query on the station_id column
     *
     * Example usage:
     * <code>
     * $query->filterByStationId(1234); // WHERE station_id = 1234
     * $query->filterByStationId(array(12, 34)); // WHERE station_id IN (12, 34)
     * $query->filterByStationId(array('min' => 12)); // WHERE station_id > 12
     * </code>
     *
     * @see       filterByStation()
     *
     * @param     mixed $stationId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMeasurementQuery The current query, for fluid interface
     */
    public function filterByStationId($stationId = null, $comparison = null)
    {
        if (is_array($stationId)) {
            $useMinMax = false;
            if (isset($stationId['min'])) {
                $this->addUsingAlias(MeasurementTableMap::COL_STATION_ID, $stationId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($stationId['max'])) {
                $this->addUsingAlias(MeasurementTableMap::COL_STATION_ID, $stationId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MeasurementTableMap::COL_STATION_ID, $stationId, $comparison);
    }

    /**
     * Filter the query by a related \Sensor object
     *
     * @param \Sensor|ObjectCollection $sensor The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildMeasurementQuery The current query, for fluid interface
     */
    public function filterBySensor($sensor, $comparison = null)
    {
        if ($sensor instanceof \Sensor) {
            return $this
                ->addUsingAlias(MeasurementTableMap::COL_SENSOR_ID, $sensor->getId(), $comparison);
        } elseif ($sensor instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(MeasurementTableMap::COL_SENSOR_ID, $sensor->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterBySensor() only accepts arguments of type \Sensor or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Sensor relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildMeasurementQuery The current query, for fluid interface
     */
    public function joinSensor($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Sensor');

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
            $this->addJoinObject($join, 'Sensor');
        }

        return $this;
    }

    /**
     * Use the Sensor relation Sensor object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \SensorQuery A secondary query class using the current class as primary query
     */
    public function useSensorQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSensor($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Sensor', '\SensorQuery');
    }

    /**
     * Filter the query by a related \Station object
     *
     * @param \Station|ObjectCollection $station The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildMeasurementQuery The current query, for fluid interface
     */
    public function filterByStation($station, $comparison = null)
    {
        if ($station instanceof \Station) {
            return $this
                ->addUsingAlias(MeasurementTableMap::COL_STATION_ID, $station->getId(), $comparison);
        } elseif ($station instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(MeasurementTableMap::COL_STATION_ID, $station->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByStation() only accepts arguments of type \Station or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Station relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildMeasurementQuery The current query, for fluid interface
     */
    public function joinStation($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Station');

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
            $this->addJoinObject($join, 'Station');
        }

        return $this;
    }

    /**
     * Use the Station relation Station object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \StationQuery A secondary query class using the current class as primary query
     */
    public function useStationQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinStation($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Station', '\StationQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildMeasurement $measurement Object to remove from the list of results
     *
     * @return $this|ChildMeasurementQuery The current query, for fluid interface
     */
    public function prune($measurement = null)
    {
        if ($measurement) {
            $this->addUsingAlias(MeasurementTableMap::COL_ID, $measurement->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the measurement table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(MeasurementTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            MeasurementTableMap::clearInstancePool();
            MeasurementTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(MeasurementTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(MeasurementTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            MeasurementTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            MeasurementTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // MeasurementQuery
