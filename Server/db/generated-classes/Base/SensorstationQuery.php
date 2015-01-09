<?php

namespace Base;

use \Sensorstation as ChildSensorstation;
use \SensorstationQuery as ChildSensorstationQuery;
use \Exception;
use \PDO;
use Map\SensorstationTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'sensorstation' table.
 *
 *
 *
 * @method     ChildSensorstationQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildSensorstationQuery orderBySensorId($order = Criteria::ASC) Order by the sensor_id column
 * @method     ChildSensorstationQuery orderByStationId($order = Criteria::ASC) Order by the station_id column
 * @method     ChildSensorstationQuery orderByActive($order = Criteria::ASC) Order by the active column
 * @method     ChildSensorstationQuery orderByDelay($order = Criteria::ASC) Order by the delay column
 *
 * @method     ChildSensorstationQuery groupById() Group by the id column
 * @method     ChildSensorstationQuery groupBySensorId() Group by the sensor_id column
 * @method     ChildSensorstationQuery groupByStationId() Group by the station_id column
 * @method     ChildSensorstationQuery groupByActive() Group by the active column
 * @method     ChildSensorstationQuery groupByDelay() Group by the delay column
 *
 * @method     ChildSensorstationQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildSensorstationQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildSensorstationQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildSensorstationQuery leftJoinSensor($relationAlias = null) Adds a LEFT JOIN clause to the query using the Sensor relation
 * @method     ChildSensorstationQuery rightJoinSensor($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Sensor relation
 * @method     ChildSensorstationQuery innerJoinSensor($relationAlias = null) Adds a INNER JOIN clause to the query using the Sensor relation
 *
 * @method     ChildSensorstationQuery leftJoinStation($relationAlias = null) Adds a LEFT JOIN clause to the query using the Station relation
 * @method     ChildSensorstationQuery rightJoinStation($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Station relation
 * @method     ChildSensorstationQuery innerJoinStation($relationAlias = null) Adds a INNER JOIN clause to the query using the Station relation
 *
 * @method     ChildSensorstationQuery leftJoinAlert($relationAlias = null) Adds a LEFT JOIN clause to the query using the Alert relation
 * @method     ChildSensorstationQuery rightJoinAlert($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Alert relation
 * @method     ChildSensorstationQuery innerJoinAlert($relationAlias = null) Adds a INNER JOIN clause to the query using the Alert relation
 *
 * @method     \SensorQuery|\StationQuery|\AlertQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildSensorstation findOne(ConnectionInterface $con = null) Return the first ChildSensorstation matching the query
 * @method     ChildSensorstation findOneOrCreate(ConnectionInterface $con = null) Return the first ChildSensorstation matching the query, or a new ChildSensorstation object populated from the query conditions when no match is found
 *
 * @method     ChildSensorstation findOneById(int $id) Return the first ChildSensorstation filtered by the id column
 * @method     ChildSensorstation findOneBySensorId(int $sensor_id) Return the first ChildSensorstation filtered by the sensor_id column
 * @method     ChildSensorstation findOneByStationId(int $station_id) Return the first ChildSensorstation filtered by the station_id column
 * @method     ChildSensorstation findOneByActive(int $active) Return the first ChildSensorstation filtered by the active column
 * @method     ChildSensorstation findOneByDelay(int $delay) Return the first ChildSensorstation filtered by the delay column
 *
 * @method     ChildSensorstation[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildSensorstation objects based on current ModelCriteria
 * @method     ChildSensorstation[]|ObjectCollection findById(int $id) Return ChildSensorstation objects filtered by the id column
 * @method     ChildSensorstation[]|ObjectCollection findBySensorId(int $sensor_id) Return ChildSensorstation objects filtered by the sensor_id column
 * @method     ChildSensorstation[]|ObjectCollection findByStationId(int $station_id) Return ChildSensorstation objects filtered by the station_id column
 * @method     ChildSensorstation[]|ObjectCollection findByActive(int $active) Return ChildSensorstation objects filtered by the active column
 * @method     ChildSensorstation[]|ObjectCollection findByDelay(int $delay) Return ChildSensorstation objects filtered by the delay column
 * @method     ChildSensorstation[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class SensorstationQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \Base\SensorstationQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'smojedb', $modelName = '\\Sensorstation', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildSensorstationQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildSensorstationQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildSensorstationQuery) {
            return $criteria;
        }
        $query = new ChildSensorstationQuery();
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
     * @return ChildSensorstation|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = SensorstationTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SensorstationTableMap::DATABASE_NAME);
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
     * @return ChildSensorstation A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, sensor_id, station_id, active, delay FROM sensorstation WHERE id = :p0';
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
            /** @var ChildSensorstation $obj */
            $obj = new ChildSensorstation();
            $obj->hydrate($row);
            SensorstationTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildSensorstation|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildSensorstationQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(SensorstationTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildSensorstationQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(SensorstationTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildSensorstationQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(SensorstationTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(SensorstationTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SensorstationTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildSensorstationQuery The current query, for fluid interface
     */
    public function filterBySensorId($sensorId = null, $comparison = null)
    {
        if (is_array($sensorId)) {
            $useMinMax = false;
            if (isset($sensorId['min'])) {
                $this->addUsingAlias(SensorstationTableMap::COL_SENSOR_ID, $sensorId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($sensorId['max'])) {
                $this->addUsingAlias(SensorstationTableMap::COL_SENSOR_ID, $sensorId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SensorstationTableMap::COL_SENSOR_ID, $sensorId, $comparison);
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
     * @return $this|ChildSensorstationQuery The current query, for fluid interface
     */
    public function filterByStationId($stationId = null, $comparison = null)
    {
        if (is_array($stationId)) {
            $useMinMax = false;
            if (isset($stationId['min'])) {
                $this->addUsingAlias(SensorstationTableMap::COL_STATION_ID, $stationId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($stationId['max'])) {
                $this->addUsingAlias(SensorstationTableMap::COL_STATION_ID, $stationId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SensorstationTableMap::COL_STATION_ID, $stationId, $comparison);
    }

    /**
     * Filter the query on the active column
     *
     * Example usage:
     * <code>
     * $query->filterByActive(1234); // WHERE active = 1234
     * $query->filterByActive(array(12, 34)); // WHERE active IN (12, 34)
     * $query->filterByActive(array('min' => 12)); // WHERE active > 12
     * </code>
     *
     * @param     mixed $active The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSensorstationQuery The current query, for fluid interface
     */
    public function filterByActive($active = null, $comparison = null)
    {
        if (is_array($active)) {
            $useMinMax = false;
            if (isset($active['min'])) {
                $this->addUsingAlias(SensorstationTableMap::COL_ACTIVE, $active['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($active['max'])) {
                $this->addUsingAlias(SensorstationTableMap::COL_ACTIVE, $active['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SensorstationTableMap::COL_ACTIVE, $active, $comparison);
    }

    /**
     * Filter the query on the delay column
     *
     * Example usage:
     * <code>
     * $query->filterByDelay(1234); // WHERE delay = 1234
     * $query->filterByDelay(array(12, 34)); // WHERE delay IN (12, 34)
     * $query->filterByDelay(array('min' => 12)); // WHERE delay > 12
     * </code>
     *
     * @param     mixed $delay The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSensorstationQuery The current query, for fluid interface
     */
    public function filterByDelay($delay = null, $comparison = null)
    {
        if (is_array($delay)) {
            $useMinMax = false;
            if (isset($delay['min'])) {
                $this->addUsingAlias(SensorstationTableMap::COL_DELAY, $delay['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($delay['max'])) {
                $this->addUsingAlias(SensorstationTableMap::COL_DELAY, $delay['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SensorstationTableMap::COL_DELAY, $delay, $comparison);
    }

    /**
     * Filter the query by a related \Sensor object
     *
     * @param \Sensor|ObjectCollection $sensor The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSensorstationQuery The current query, for fluid interface
     */
    public function filterBySensor($sensor, $comparison = null)
    {
        if ($sensor instanceof \Sensor) {
            return $this
                ->addUsingAlias(SensorstationTableMap::COL_SENSOR_ID, $sensor->getId(), $comparison);
        } elseif ($sensor instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SensorstationTableMap::COL_SENSOR_ID, $sensor->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildSensorstationQuery The current query, for fluid interface
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
     * @return ChildSensorstationQuery The current query, for fluid interface
     */
    public function filterByStation($station, $comparison = null)
    {
        if ($station instanceof \Station) {
            return $this
                ->addUsingAlias(SensorstationTableMap::COL_STATION_ID, $station->getId(), $comparison);
        } elseif ($station instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SensorstationTableMap::COL_STATION_ID, $station->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildSensorstationQuery The current query, for fluid interface
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
     * Filter the query by a related \Alert object
     *
     * @param \Alert|ObjectCollection $alert  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSensorstationQuery The current query, for fluid interface
     */
    public function filterByAlert($alert, $comparison = null)
    {
        if ($alert instanceof \Alert) {
            return $this
                ->addUsingAlias(SensorstationTableMap::COL_ID, $alert->getSensorstationId(), $comparison);
        } elseif ($alert instanceof ObjectCollection) {
            return $this
                ->useAlertQuery()
                ->filterByPrimaryKeys($alert->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAlert() only accepts arguments of type \Alert or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Alert relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSensorstationQuery The current query, for fluid interface
     */
    public function joinAlert($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Alert');

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
            $this->addJoinObject($join, 'Alert');
        }

        return $this;
    }

    /**
     * Use the Alert relation Alert object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \AlertQuery A secondary query class using the current class as primary query
     */
    public function useAlertQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAlert($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Alert', '\AlertQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildSensorstation $sensorstation Object to remove from the list of results
     *
     * @return $this|ChildSensorstationQuery The current query, for fluid interface
     */
    public function prune($sensorstation = null)
    {
        if ($sensorstation) {
            $this->addUsingAlias(SensorstationTableMap::COL_ID, $sensorstation->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the sensorstation table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SensorstationTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            SensorstationTableMap::clearInstancePool();
            SensorstationTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(SensorstationTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(SensorstationTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            SensorstationTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            SensorstationTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // SensorstationQuery
