<?php

namespace Base;

use \Sensor as ChildSensor;
use \SensorQuery as ChildSensorQuery;
use \Exception;
use \PDO;
use Map\SensorTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'sensor' table.
 *
 *
 *
 * @method     ChildSensorQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildSensorQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildSensorQuery orderByDescription($order = Criteria::ASC) Order by the description column
 * @method     ChildSensorQuery orderByUnit($order = Criteria::ASC) Order by the unit column
 * @method     ChildSensorQuery orderByDisplaytypeId($order = Criteria::ASC) Order by the displaytype_id column
 * @method     ChildSensorQuery orderByTitle($order = Criteria::ASC) Order by the title column
 * @method     ChildSensorQuery orderBySortorder($order = Criteria::ASC) Order by the sortorder column
 *
 * @method     ChildSensorQuery groupById() Group by the id column
 * @method     ChildSensorQuery groupByName() Group by the name column
 * @method     ChildSensorQuery groupByDescription() Group by the description column
 * @method     ChildSensorQuery groupByUnit() Group by the unit column
 * @method     ChildSensorQuery groupByDisplaytypeId() Group by the displaytype_id column
 * @method     ChildSensorQuery groupByTitle() Group by the title column
 * @method     ChildSensorQuery groupBySortorder() Group by the sortorder column
 *
 * @method     ChildSensorQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildSensorQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildSensorQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildSensorQuery leftJoinDisplaytype($relationAlias = null) Adds a LEFT JOIN clause to the query using the Displaytype relation
 * @method     ChildSensorQuery rightJoinDisplaytype($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Displaytype relation
 * @method     ChildSensorQuery innerJoinDisplaytype($relationAlias = null) Adds a INNER JOIN clause to the query using the Displaytype relation
 *
 * @method     ChildSensorQuery leftJoinMeasurement($relationAlias = null) Adds a LEFT JOIN clause to the query using the Measurement relation
 * @method     ChildSensorQuery rightJoinMeasurement($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Measurement relation
 * @method     ChildSensorQuery innerJoinMeasurement($relationAlias = null) Adds a INNER JOIN clause to the query using the Measurement relation
 *
 * @method     ChildSensorQuery leftJoinSensorstation($relationAlias = null) Adds a LEFT JOIN clause to the query using the Sensorstation relation
 * @method     ChildSensorQuery rightJoinSensorstation($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Sensorstation relation
 * @method     ChildSensorQuery innerJoinSensorstation($relationAlias = null) Adds a INNER JOIN clause to the query using the Sensorstation relation
 *
 * @method     \DisplaytypeQuery|\MeasurementQuery|\SensorstationQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildSensor findOne(ConnectionInterface $con = null) Return the first ChildSensor matching the query
 * @method     ChildSensor findOneOrCreate(ConnectionInterface $con = null) Return the first ChildSensor matching the query, or a new ChildSensor object populated from the query conditions when no match is found
 *
 * @method     ChildSensor findOneById(int $id) Return the first ChildSensor filtered by the id column
 * @method     ChildSensor findOneByName(string $name) Return the first ChildSensor filtered by the name column
 * @method     ChildSensor findOneByDescription(string $description) Return the first ChildSensor filtered by the description column
 * @method     ChildSensor findOneByUnit(string $unit) Return the first ChildSensor filtered by the unit column
 * @method     ChildSensor findOneByDisplaytypeId(int $displaytype_id) Return the first ChildSensor filtered by the displaytype_id column
 * @method     ChildSensor findOneByTitle(string $title) Return the first ChildSensor filtered by the title column
 * @method     ChildSensor findOneBySortorder(int $sortorder) Return the first ChildSensor filtered by the sortorder column
 *
 * @method     ChildSensor[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildSensor objects based on current ModelCriteria
 * @method     ChildSensor[]|ObjectCollection findById(int $id) Return ChildSensor objects filtered by the id column
 * @method     ChildSensor[]|ObjectCollection findByName(string $name) Return ChildSensor objects filtered by the name column
 * @method     ChildSensor[]|ObjectCollection findByDescription(string $description) Return ChildSensor objects filtered by the description column
 * @method     ChildSensor[]|ObjectCollection findByUnit(string $unit) Return ChildSensor objects filtered by the unit column
 * @method     ChildSensor[]|ObjectCollection findByDisplaytypeId(int $displaytype_id) Return ChildSensor objects filtered by the displaytype_id column
 * @method     ChildSensor[]|ObjectCollection findByTitle(string $title) Return ChildSensor objects filtered by the title column
 * @method     ChildSensor[]|ObjectCollection findBySortorder(int $sortorder) Return ChildSensor objects filtered by the sortorder column
 * @method     ChildSensor[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class SensorQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \Base\SensorQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'smojedb', $modelName = '\\Sensor', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildSensorQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildSensorQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildSensorQuery) {
            return $criteria;
        }
        $query = new ChildSensorQuery();
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
     * @return ChildSensor|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = SensorTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SensorTableMap::DATABASE_NAME);
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
     * @return ChildSensor A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, name, description, unit, displaytype_id, title, sortorder FROM sensor WHERE id = :p0';
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
            /** @var ChildSensor $obj */
            $obj = new ChildSensor();
            $obj->hydrate($row);
            SensorTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildSensor|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildSensorQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(SensorTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildSensorQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(SensorTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildSensorQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(SensorTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(SensorTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SensorTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildSensorQuery The current query, for fluid interface
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

        return $this->addUsingAlias(SensorTableMap::COL_NAME, $name, $comparison);
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
     * @return $this|ChildSensorQuery The current query, for fluid interface
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

        return $this->addUsingAlias(SensorTableMap::COL_DESCRIPTION, $description, $comparison);
    }

    /**
     * Filter the query on the unit column
     *
     * Example usage:
     * <code>
     * $query->filterByUnit('fooValue');   // WHERE unit = 'fooValue'
     * $query->filterByUnit('%fooValue%'); // WHERE unit LIKE '%fooValue%'
     * </code>
     *
     * @param     string $unit The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSensorQuery The current query, for fluid interface
     */
    public function filterByUnit($unit = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($unit)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $unit)) {
                $unit = str_replace('*', '%', $unit);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SensorTableMap::COL_UNIT, $unit, $comparison);
    }

    /**
     * Filter the query on the displaytype_id column
     *
     * Example usage:
     * <code>
     * $query->filterByDisplaytypeId(1234); // WHERE displaytype_id = 1234
     * $query->filterByDisplaytypeId(array(12, 34)); // WHERE displaytype_id IN (12, 34)
     * $query->filterByDisplaytypeId(array('min' => 12)); // WHERE displaytype_id > 12
     * </code>
     *
     * @see       filterByDisplaytype()
     *
     * @param     mixed $displaytypeId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSensorQuery The current query, for fluid interface
     */
    public function filterByDisplaytypeId($displaytypeId = null, $comparison = null)
    {
        if (is_array($displaytypeId)) {
            $useMinMax = false;
            if (isset($displaytypeId['min'])) {
                $this->addUsingAlias(SensorTableMap::COL_DISPLAYTYPE_ID, $displaytypeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($displaytypeId['max'])) {
                $this->addUsingAlias(SensorTableMap::COL_DISPLAYTYPE_ID, $displaytypeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SensorTableMap::COL_DISPLAYTYPE_ID, $displaytypeId, $comparison);
    }

    /**
     * Filter the query on the title column
     *
     * Example usage:
     * <code>
     * $query->filterByTitle('fooValue');   // WHERE title = 'fooValue'
     * $query->filterByTitle('%fooValue%'); // WHERE title LIKE '%fooValue%'
     * </code>
     *
     * @param     string $title The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSensorQuery The current query, for fluid interface
     */
    public function filterByTitle($title = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($title)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $title)) {
                $title = str_replace('*', '%', $title);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SensorTableMap::COL_TITLE, $title, $comparison);
    }

    /**
     * Filter the query on the sortorder column
     *
     * Example usage:
     * <code>
     * $query->filterBySortorder(1234); // WHERE sortorder = 1234
     * $query->filterBySortorder(array(12, 34)); // WHERE sortorder IN (12, 34)
     * $query->filterBySortorder(array('min' => 12)); // WHERE sortorder > 12
     * </code>
     *
     * @param     mixed $sortorder The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSensorQuery The current query, for fluid interface
     */
    public function filterBySortorder($sortorder = null, $comparison = null)
    {
        if (is_array($sortorder)) {
            $useMinMax = false;
            if (isset($sortorder['min'])) {
                $this->addUsingAlias(SensorTableMap::COL_SORTORDER, $sortorder['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($sortorder['max'])) {
                $this->addUsingAlias(SensorTableMap::COL_SORTORDER, $sortorder['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SensorTableMap::COL_SORTORDER, $sortorder, $comparison);
    }

    /**
     * Filter the query by a related \Displaytype object
     *
     * @param \Displaytype|ObjectCollection $displaytype The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSensorQuery The current query, for fluid interface
     */
    public function filterByDisplaytype($displaytype, $comparison = null)
    {
        if ($displaytype instanceof \Displaytype) {
            return $this
                ->addUsingAlias(SensorTableMap::COL_DISPLAYTYPE_ID, $displaytype->getId(), $comparison);
        } elseif ($displaytype instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SensorTableMap::COL_DISPLAYTYPE_ID, $displaytype->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByDisplaytype() only accepts arguments of type \Displaytype or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Displaytype relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSensorQuery The current query, for fluid interface
     */
    public function joinDisplaytype($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Displaytype');

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
            $this->addJoinObject($join, 'Displaytype');
        }

        return $this;
    }

    /**
     * Use the Displaytype relation Displaytype object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \DisplaytypeQuery A secondary query class using the current class as primary query
     */
    public function useDisplaytypeQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinDisplaytype($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Displaytype', '\DisplaytypeQuery');
    }

    /**
     * Filter the query by a related \Measurement object
     *
     * @param \Measurement|ObjectCollection $measurement  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSensorQuery The current query, for fluid interface
     */
    public function filterByMeasurement($measurement, $comparison = null)
    {
        if ($measurement instanceof \Measurement) {
            return $this
                ->addUsingAlias(SensorTableMap::COL_ID, $measurement->getSensorId(), $comparison);
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
     * @return $this|ChildSensorQuery The current query, for fluid interface
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
     * @return ChildSensorQuery The current query, for fluid interface
     */
    public function filterBySensorstation($sensorstation, $comparison = null)
    {
        if ($sensorstation instanceof \Sensorstation) {
            return $this
                ->addUsingAlias(SensorTableMap::COL_ID, $sensorstation->getSensorId(), $comparison);
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
     * @return $this|ChildSensorQuery The current query, for fluid interface
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
     * @param   ChildSensor $sensor Object to remove from the list of results
     *
     * @return $this|ChildSensorQuery The current query, for fluid interface
     */
    public function prune($sensor = null)
    {
        if ($sensor) {
            $this->addUsingAlias(SensorTableMap::COL_ID, $sensor->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the sensor table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SensorTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            SensorTableMap::clearInstancePool();
            SensorTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(SensorTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(SensorTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            SensorTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            SensorTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // SensorQuery
