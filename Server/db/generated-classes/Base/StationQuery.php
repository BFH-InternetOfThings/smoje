<?php

namespace Base;

use \Station as ChildStation;
use \StationQuery as ChildStationQuery;
use \Exception;
use \PDO;
use Map\StationTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'station' table.
 *
 *
 *
 * @method     ChildStationQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildStationQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildStationQuery orderByDescription($order = Criteria::ASC) Order by the description column
 * @method     ChildStationQuery orderByUrlSensor($order = Criteria::ASC) Order by the url_sensor column
 * @method     ChildStationQuery orderByUrlNetmodule($order = Criteria::ASC) Order by the url_netmodule column
 * @method     ChildStationQuery orderByUrlTissan($order = Criteria::ASC) Order by the url_tissan column
 *
 * @method     ChildStationQuery groupById() Group by the id column
 * @method     ChildStationQuery groupByName() Group by the name column
 * @method     ChildStationQuery groupByDescription() Group by the description column
 * @method     ChildStationQuery groupByUrlSensor() Group by the url_sensor column
 * @method     ChildStationQuery groupByUrlNetmodule() Group by the url_netmodule column
 * @method     ChildStationQuery groupByUrlTissan() Group by the url_tissan column
 *
 * @method     ChildStationQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildStationQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildStationQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildStationQuery leftJoinMeasurement($relationAlias = null) Adds a LEFT JOIN clause to the query using the Measurement relation
 * @method     ChildStationQuery rightJoinMeasurement($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Measurement relation
 * @method     ChildStationQuery innerJoinMeasurement($relationAlias = null) Adds a INNER JOIN clause to the query using the Measurement relation
 *
 * @method     ChildStationQuery leftJoinSensorstation($relationAlias = null) Adds a LEFT JOIN clause to the query using the Sensorstation relation
 * @method     ChildStationQuery rightJoinSensorstation($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Sensorstation relation
 * @method     ChildStationQuery innerJoinSensorstation($relationAlias = null) Adds a INNER JOIN clause to the query using the Sensorstation relation
 *
 * @method     \MeasurementQuery|\SensorstationQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildStation findOne(ConnectionInterface $con = null) Return the first ChildStation matching the query
 * @method     ChildStation findOneOrCreate(ConnectionInterface $con = null) Return the first ChildStation matching the query, or a new ChildStation object populated from the query conditions when no match is found
 *
 * @method     ChildStation findOneById(int $id) Return the first ChildStation filtered by the id column
 * @method     ChildStation findOneByName(string $name) Return the first ChildStation filtered by the name column
 * @method     ChildStation findOneByDescription(string $description) Return the first ChildStation filtered by the description column
 * @method     ChildStation findOneByUrlSensor(string $url_sensor) Return the first ChildStation filtered by the url_sensor column
 * @method     ChildStation findOneByUrlNetmodule(string $url_netmodule) Return the first ChildStation filtered by the url_netmodule column
 * @method     ChildStation findOneByUrlTissan(string $url_tissan) Return the first ChildStation filtered by the url_tissan column
 *
 * @method     ChildStation[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildStation objects based on current ModelCriteria
 * @method     ChildStation[]|ObjectCollection findById(int $id) Return ChildStation objects filtered by the id column
 * @method     ChildStation[]|ObjectCollection findByName(string $name) Return ChildStation objects filtered by the name column
 * @method     ChildStation[]|ObjectCollection findByDescription(string $description) Return ChildStation objects filtered by the description column
 * @method     ChildStation[]|ObjectCollection findByUrlSensor(string $url_sensor) Return ChildStation objects filtered by the url_sensor column
 * @method     ChildStation[]|ObjectCollection findByUrlNetmodule(string $url_netmodule) Return ChildStation objects filtered by the url_netmodule column
 * @method     ChildStation[]|ObjectCollection findByUrlTissan(string $url_tissan) Return ChildStation objects filtered by the url_tissan column
 * @method     ChildStation[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class StationQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \Base\StationQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'smojedb', $modelName = '\\Station', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildStationQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildStationQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildStationQuery) {
            return $criteria;
        }
        $query = new ChildStationQuery();
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
     * @return ChildStation|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = StationTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(StationTableMap::DATABASE_NAME);
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
     * @return ChildStation A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, name, description, url_sensor, url_netmodule, url_tissan FROM station WHERE id = :p0';
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
            /** @var ChildStation $obj */
            $obj = new ChildStation();
            $obj->hydrate($row);
            StationTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildStation|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildStationQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(StationTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildStationQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(StationTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildStationQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(StationTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(StationTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StationTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%'); // WHERE name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildStationQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $name)) {
                $name = str_replace('*', '%', $name);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(StationTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query on the description column
     *
     * Example usage:
     * <code>
     * $query->filterByDescription('fooValue');   // WHERE description = 'fooValue'
     * $query->filterByDescription('%fooValue%'); // WHERE description LIKE '%fooValue%'
     * </code>
     *
     * @param     string $description The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildStationQuery The current query, for fluid interface
     */
    public function filterByDescription($description = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($description)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $description)) {
                $description = str_replace('*', '%', $description);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(StationTableMap::COL_DESCRIPTION, $description, $comparison);
    }

    /**
     * Filter the query on the url_sensor column
     *
     * Example usage:
     * <code>
     * $query->filterByUrlSensor('fooValue');   // WHERE url_sensor = 'fooValue'
     * $query->filterByUrlSensor('%fooValue%'); // WHERE url_sensor LIKE '%fooValue%'
     * </code>
     *
     * @param     string $urlSensor The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildStationQuery The current query, for fluid interface
     */
    public function filterByUrlSensor($urlSensor = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($urlSensor)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $urlSensor)) {
                $urlSensor = str_replace('*', '%', $urlSensor);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(StationTableMap::COL_URL_SENSOR, $urlSensor, $comparison);
    }

    /**
     * Filter the query on the url_netmodule column
     *
     * Example usage:
     * <code>
     * $query->filterByUrlNetmodule('fooValue');   // WHERE url_netmodule = 'fooValue'
     * $query->filterByUrlNetmodule('%fooValue%'); // WHERE url_netmodule LIKE '%fooValue%'
     * </code>
     *
     * @param     string $urlNetmodule The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildStationQuery The current query, for fluid interface
     */
    public function filterByUrlNetmodule($urlNetmodule = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($urlNetmodule)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $urlNetmodule)) {
                $urlNetmodule = str_replace('*', '%', $urlNetmodule);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(StationTableMap::COL_URL_NETMODULE, $urlNetmodule, $comparison);
    }

    /**
     * Filter the query on the url_tissan column
     *
     * Example usage:
     * <code>
     * $query->filterByUrlTissan('fooValue');   // WHERE url_tissan = 'fooValue'
     * $query->filterByUrlTissan('%fooValue%'); // WHERE url_tissan LIKE '%fooValue%'
     * </code>
     *
     * @param     string $urlTissan The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildStationQuery The current query, for fluid interface
     */
    public function filterByUrlTissan($urlTissan = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($urlTissan)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $urlTissan)) {
                $urlTissan = str_replace('*', '%', $urlTissan);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(StationTableMap::COL_URL_TISSAN, $urlTissan, $comparison);
    }

    /**
     * Filter the query by a related \Measurement object
     *
     * @param \Measurement|ObjectCollection $measurement  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildStationQuery The current query, for fluid interface
     */
    public function filterByMeasurement($measurement, $comparison = null)
    {
        if ($measurement instanceof \Measurement) {
            return $this
                ->addUsingAlias(StationTableMap::COL_ID, $measurement->getStationId(), $comparison);
        } elseif ($measurement instanceof ObjectCollection) {
            return $this
                ->useMeasurementQuery()
                ->filterByPrimaryKeys($measurement->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByMeasurement() only accepts arguments of type \Measurement or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Measurement relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildStationQuery The current query, for fluid interface
     */
    public function joinMeasurement($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Measurement');

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
            $this->addJoinObject($join, 'Measurement');
        }

        return $this;
    }

    /**
     * Use the Measurement relation Measurement object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \MeasurementQuery A secondary query class using the current class as primary query
     */
    public function useMeasurementQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinMeasurement($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Measurement', '\MeasurementQuery');
    }

    /**
     * Filter the query by a related \Sensorstation object
     *
     * @param \Sensorstation|ObjectCollection $sensorstation  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildStationQuery The current query, for fluid interface
     */
    public function filterBySensorstation($sensorstation, $comparison = null)
    {
        if ($sensorstation instanceof \Sensorstation) {
            return $this
                ->addUsingAlias(StationTableMap::COL_ID, $sensorstation->getStationId(), $comparison);
        } elseif ($sensorstation instanceof ObjectCollection) {
            return $this
                ->useSensorstationQuery()
                ->filterByPrimaryKeys($sensorstation->getPrimaryKeys())
                ->endUse();
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
     * @return $this|ChildStationQuery The current query, for fluid interface
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
     * @param   ChildStation $station Object to remove from the list of results
     *
     * @return $this|ChildStationQuery The current query, for fluid interface
     */
    public function prune($station = null)
    {
        if ($station) {
            $this->addUsingAlias(StationTableMap::COL_ID, $station->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the station table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(StationTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            StationTableMap::clearInstancePool();
            StationTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(StationTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(StationTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            StationTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            StationTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // StationQuery
