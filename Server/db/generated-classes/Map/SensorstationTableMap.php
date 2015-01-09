<?php

namespace Map;

use \Sensorstation;
use \SensorstationQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'sensorstation' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class SensorstationTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.SensorstationTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'smojedb';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'sensorstation';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Sensorstation';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Sensorstation';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 5;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 5;

    /**
     * the column name for the id field
     */
    const COL_ID = 'sensorstation.id';

    /**
     * the column name for the sensor_id field
     */
    const COL_SENSOR_ID = 'sensorstation.sensor_id';

    /**
     * the column name for the station_id field
     */
    const COL_STATION_ID = 'sensorstation.station_id';

    /**
     * the column name for the active field
     */
    const COL_ACTIVE = 'sensorstation.active';

    /**
     * the column name for the delay field
     */
    const COL_DELAY = 'sensorstation.delay';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Id', 'SensorId', 'StationId', 'Active', 'Delay', ),
        self::TYPE_CAMELNAME     => array('id', 'sensorId', 'stationId', 'active', 'delay', ),
        self::TYPE_COLNAME       => array(SensorstationTableMap::COL_ID, SensorstationTableMap::COL_SENSOR_ID, SensorstationTableMap::COL_STATION_ID, SensorstationTableMap::COL_ACTIVE, SensorstationTableMap::COL_DELAY, ),
        self::TYPE_FIELDNAME     => array('id', 'sensor_id', 'station_id', 'active', 'delay', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'SensorId' => 1, 'StationId' => 2, 'Active' => 3, 'Delay' => 4, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'sensorId' => 1, 'stationId' => 2, 'active' => 3, 'delay' => 4, ),
        self::TYPE_COLNAME       => array(SensorstationTableMap::COL_ID => 0, SensorstationTableMap::COL_SENSOR_ID => 1, SensorstationTableMap::COL_STATION_ID => 2, SensorstationTableMap::COL_ACTIVE => 3, SensorstationTableMap::COL_DELAY => 4, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'sensor_id' => 1, 'station_id' => 2, 'active' => 3, 'delay' => 4, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('sensorstation');
        $this->setPhpName('Sensorstation');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Sensorstation');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('sensor_id', 'SensorId', 'INTEGER', 'sensor', 'id', true, null, null);
        $this->addForeignKey('station_id', 'StationId', 'INTEGER', 'station', 'id', true, null, null);
        $this->addColumn('active', 'Active', 'INTEGER', true, 2, 0);
        $this->addColumn('delay', 'Delay', 'INTEGER', true, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Sensor', '\\Sensor', RelationMap::MANY_TO_ONE, array('sensor_id' => 'id', ), null, null);
        $this->addRelation('Station', '\\Station', RelationMap::MANY_TO_ONE, array('station_id' => 'id', ), null, null);
        $this->addRelation('Alert', '\\Alert', RelationMap::ONE_TO_MANY, array('id' => 'sensorstation_id', ), null, null, 'Alerts');
    } // buildRelations()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        return (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
        ];
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? SensorstationTableMap::CLASS_DEFAULT : SensorstationTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (Sensorstation object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = SensorstationTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = SensorstationTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + SensorstationTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = SensorstationTableMap::OM_CLASS;
            /** @var Sensorstation $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            SensorstationTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = SensorstationTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = SensorstationTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Sensorstation $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                SensorstationTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(SensorstationTableMap::COL_ID);
            $criteria->addSelectColumn(SensorstationTableMap::COL_SENSOR_ID);
            $criteria->addSelectColumn(SensorstationTableMap::COL_STATION_ID);
            $criteria->addSelectColumn(SensorstationTableMap::COL_ACTIVE);
            $criteria->addSelectColumn(SensorstationTableMap::COL_DELAY);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.sensor_id');
            $criteria->addSelectColumn($alias . '.station_id');
            $criteria->addSelectColumn($alias . '.active');
            $criteria->addSelectColumn($alias . '.delay');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(SensorstationTableMap::DATABASE_NAME)->getTable(SensorstationTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(SensorstationTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(SensorstationTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new SensorstationTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Sensorstation or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Sensorstation object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SensorstationTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Sensorstation) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(SensorstationTableMap::DATABASE_NAME);
            $criteria->add(SensorstationTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = SensorstationQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            SensorstationTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                SensorstationTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the sensorstation table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return SensorstationQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Sensorstation or Criteria object.
     *
     * @param mixed               $criteria Criteria or Sensorstation object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SensorstationTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Sensorstation object
        }

        if ($criteria->containsKey(SensorstationTableMap::COL_ID) && $criteria->keyContainsValue(SensorstationTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.SensorstationTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = SensorstationQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // SensorstationTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
SensorstationTableMap::buildTableMap();
