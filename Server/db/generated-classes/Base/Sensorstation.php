<?php

namespace Base;

use \Alert as ChildAlert;
use \AlertQuery as ChildAlertQuery;
use \Sensor as ChildSensor;
use \SensorQuery as ChildSensorQuery;
use \Sensorstation as ChildSensorstation;
use \SensorstationQuery as ChildSensorstationQuery;
use \Station as ChildStation;
use \StationQuery as ChildStationQuery;
use \Exception;
use \PDO;
use Map\SensorstationTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;

/**
 * Base class that represents a row from the 'sensorstation' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class Sensorstation implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\SensorstationTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the id field.
     * @var        int
     */
    protected $id;

    /**
     * The value for the sensor_id field.
     * @var        int
     */
    protected $sensor_id;

    /**
     * The value for the station_id field.
     * @var        int
     */
    protected $station_id;

    /**
     * The value for the active field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $active;

    /**
     * The value for the delay field.
     * @var        int
     */
    protected $delay;

    /**
     * @var        ChildSensor
     */
    protected $aSensor;

    /**
     * @var        ChildStation
     */
    protected $aStation;

    /**
     * @var        ObjectCollection|ChildAlert[] Collection to store aggregation of ChildAlert objects.
     */
    protected $collAlerts;
    protected $collAlertsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildAlert[]
     */
    protected $alertsScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->active = 0;
    }

    /**
     * Initializes internal state of Base\Sensorstation object.
     * @see applyDefaults()
     */
    public function __construct()
    {
        $this->applyDefaultValues();
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>Sensorstation</code> instance.  If
     * <code>obj</code> is an instance of <code>Sensorstation</code>, delegates to
     * <code>equals(Sensorstation)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this|Sensorstation The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        return array_keys(get_object_vars($this));
    }

    /**
     * Get the [id] column value.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [sensor_id] column value.
     *
     * @return int
     */
    public function getSensorId()
    {
        return $this->sensor_id;
    }

    /**
     * Get the [station_id] column value.
     *
     * @return int
     */
    public function getStationId()
    {
        return $this->station_id;
    }

    /**
     * Get the [active] column value.
     *
     * @return int
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Get the [delay] column value.
     *
     * @return int
     */
    public function getDelay()
    {
        return $this->delay;
    }

    /**
     * Set the value of [id] column.
     *
     * @param  int $v new value
     * @return $this|\Sensorstation The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[SensorstationTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [sensor_id] column.
     *
     * @param  int $v new value
     * @return $this|\Sensorstation The current object (for fluent API support)
     */
    public function setSensorId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->sensor_id !== $v) {
            $this->sensor_id = $v;
            $this->modifiedColumns[SensorstationTableMap::COL_SENSOR_ID] = true;
        }

        if ($this->aSensor !== null && $this->aSensor->getId() !== $v) {
            $this->aSensor = null;
        }

        return $this;
    } // setSensorId()

    /**
     * Set the value of [station_id] column.
     *
     * @param  int $v new value
     * @return $this|\Sensorstation The current object (for fluent API support)
     */
    public function setStationId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->station_id !== $v) {
            $this->station_id = $v;
            $this->modifiedColumns[SensorstationTableMap::COL_STATION_ID] = true;
        }

        if ($this->aStation !== null && $this->aStation->getId() !== $v) {
            $this->aStation = null;
        }

        return $this;
    } // setStationId()

    /**
     * Set the value of [active] column.
     *
     * @param  int $v new value
     * @return $this|\Sensorstation The current object (for fluent API support)
     */
    public function setActive($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->active !== $v) {
            $this->active = $v;
            $this->modifiedColumns[SensorstationTableMap::COL_ACTIVE] = true;
        }

        return $this;
    } // setActive()

    /**
     * Set the value of [delay] column.
     *
     * @param  int $v new value
     * @return $this|\Sensorstation The current object (for fluent API support)
     */
    public function setDelay($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->delay !== $v) {
            $this->delay = $v;
            $this->modifiedColumns[SensorstationTableMap::COL_DELAY] = true;
        }

        return $this;
    } // setDelay()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
            if ($this->active !== 0) {
                return false;
            }

        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : SensorstationTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : SensorstationTableMap::translateFieldName('SensorId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->sensor_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : SensorstationTableMap::translateFieldName('StationId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->station_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : SensorstationTableMap::translateFieldName('Active', TableMap::TYPE_PHPNAME, $indexType)];
            $this->active = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : SensorstationTableMap::translateFieldName('Delay', TableMap::TYPE_PHPNAME, $indexType)];
            $this->delay = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 5; // 5 = SensorstationTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Sensorstation'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
        if ($this->aSensor !== null && $this->sensor_id !== $this->aSensor->getId()) {
            $this->aSensor = null;
        }
        if ($this->aStation !== null && $this->station_id !== $this->aStation->getId()) {
            $this->aStation = null;
        }
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SensorstationTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildSensorstationQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aSensor = null;
            $this->aStation = null;
            $this->collAlerts = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Sensorstation::setDeleted()
     * @see Sensorstation::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(SensorstationTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildSensorstationQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(SensorstationTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $isInsert = $this->isNew();
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                SensorstationTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aSensor !== null) {
                if ($this->aSensor->isModified() || $this->aSensor->isNew()) {
                    $affectedRows += $this->aSensor->save($con);
                }
                $this->setSensor($this->aSensor);
            }

            if ($this->aStation !== null) {
                if ($this->aStation->isModified() || $this->aStation->isNew()) {
                    $affectedRows += $this->aStation->save($con);
                }
                $this->setStation($this->aStation);
            }

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                } else {
                    $this->doUpdate($con);
                }
                $affectedRows += 1;
                $this->resetModified();
            }

            if ($this->alertsScheduledForDeletion !== null) {
                if (!$this->alertsScheduledForDeletion->isEmpty()) {
                    \AlertQuery::create()
                        ->filterByPrimaryKeys($this->alertsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->alertsScheduledForDeletion = null;
                }
            }

            if ($this->collAlerts !== null) {
                foreach ($this->collAlerts as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[SensorstationTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . SensorstationTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(SensorstationTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(SensorstationTableMap::COL_SENSOR_ID)) {
            $modifiedColumns[':p' . $index++]  = 'sensor_id';
        }
        if ($this->isColumnModified(SensorstationTableMap::COL_STATION_ID)) {
            $modifiedColumns[':p' . $index++]  = 'station_id';
        }
        if ($this->isColumnModified(SensorstationTableMap::COL_ACTIVE)) {
            $modifiedColumns[':p' . $index++]  = 'active';
        }
        if ($this->isColumnModified(SensorstationTableMap::COL_DELAY)) {
            $modifiedColumns[':p' . $index++]  = 'delay';
        }

        $sql = sprintf(
            'INSERT INTO sensorstation (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'id':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case 'sensor_id':
                        $stmt->bindValue($identifier, $this->sensor_id, PDO::PARAM_INT);
                        break;
                    case 'station_id':
                        $stmt->bindValue($identifier, $this->station_id, PDO::PARAM_INT);
                        break;
                    case 'active':
                        $stmt->bindValue($identifier, $this->active, PDO::PARAM_INT);
                        break;
                    case 'delay':
                        $stmt->bindValue($identifier, $this->delay, PDO::PARAM_INT);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = SensorstationTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getSensorId();
                break;
            case 2:
                return $this->getStationId();
                break;
            case 3:
                return $this->getActive();
                break;
            case 4:
                return $this->getDelay();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {

        if (isset($alreadyDumpedObjects['Sensorstation'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Sensorstation'][$this->hashCode()] = true;
        $keys = SensorstationTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getSensorId(),
            $keys[2] => $this->getStationId(),
            $keys[3] => $this->getActive(),
            $keys[4] => $this->getDelay(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aSensor) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'sensor';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'sensor';
                        break;
                    default:
                        $key = 'Sensor';
                }

                $result[$key] = $this->aSensor->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aStation) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'station';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'station';
                        break;
                    default:
                        $key = 'Station';
                }

                $result[$key] = $this->aStation->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collAlerts) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'alerts';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'alerts';
                        break;
                    default:
                        $key = 'Alerts';
                }

                $result[$key] = $this->collAlerts->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\Sensorstation
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = SensorstationTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Sensorstation
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setSensorId($value);
                break;
            case 2:
                $this->setStationId($value);
                break;
            case 3:
                $this->setActive($value);
                break;
            case 4:
                $this->setDelay($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = SensorstationTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setSensorId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setStationId($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setActive($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setDelay($arr[$keys[4]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     *
     * @return $this|\Sensorstation The current object, for fluid interface
     */
    public function importFrom($parser, $data)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), TableMap::TYPE_PHPNAME);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(SensorstationTableMap::DATABASE_NAME);

        if ($this->isColumnModified(SensorstationTableMap::COL_ID)) {
            $criteria->add(SensorstationTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(SensorstationTableMap::COL_SENSOR_ID)) {
            $criteria->add(SensorstationTableMap::COL_SENSOR_ID, $this->sensor_id);
        }
        if ($this->isColumnModified(SensorstationTableMap::COL_STATION_ID)) {
            $criteria->add(SensorstationTableMap::COL_STATION_ID, $this->station_id);
        }
        if ($this->isColumnModified(SensorstationTableMap::COL_ACTIVE)) {
            $criteria->add(SensorstationTableMap::COL_ACTIVE, $this->active);
        }
        if ($this->isColumnModified(SensorstationTableMap::COL_DELAY)) {
            $criteria->add(SensorstationTableMap::COL_DELAY, $this->delay);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildSensorstationQuery::create();
        $criteria->add(SensorstationTableMap::COL_ID, $this->id);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getId();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Sensorstation (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setSensorId($this->getSensorId());
        $copyObj->setStationId($this->getStationId());
        $copyObj->setActive($this->getActive());
        $copyObj->setDelay($this->getDelay());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getAlerts() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAlert($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \Sensorstation Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Declares an association between this object and a ChildSensor object.
     *
     * @param  ChildSensor $v
     * @return $this|\Sensorstation The current object (for fluent API support)
     * @throws PropelException
     */
    public function setSensor(ChildSensor $v = null)
    {
        if ($v === null) {
            $this->setSensorId(NULL);
        } else {
            $this->setSensorId($v->getId());
        }

        $this->aSensor = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildSensor object, it will not be re-added.
        if ($v !== null) {
            $v->addSensorstation($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildSensor object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildSensor The associated ChildSensor object.
     * @throws PropelException
     */
    public function getSensor(ConnectionInterface $con = null)
    {
        if ($this->aSensor === null && ($this->sensor_id !== null)) {
            $this->aSensor = ChildSensorQuery::create()->findPk($this->sensor_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aSensor->addSensorstations($this);
             */
        }

        return $this->aSensor;
    }

    /**
     * Declares an association between this object and a ChildStation object.
     *
     * @param  ChildStation $v
     * @return $this|\Sensorstation The current object (for fluent API support)
     * @throws PropelException
     */
    public function setStation(ChildStation $v = null)
    {
        if ($v === null) {
            $this->setStationId(NULL);
        } else {
            $this->setStationId($v->getId());
        }

        $this->aStation = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildStation object, it will not be re-added.
        if ($v !== null) {
            $v->addSensorstation($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildStation object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildStation The associated ChildStation object.
     * @throws PropelException
     */
    public function getStation(ConnectionInterface $con = null)
    {
        if ($this->aStation === null && ($this->station_id !== null)) {
            $this->aStation = ChildStationQuery::create()->findPk($this->station_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aStation->addSensorstations($this);
             */
        }

        return $this->aStation;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('Alert' == $relationName) {
            return $this->initAlerts();
        }
    }

    /**
     * Clears out the collAlerts collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addAlerts()
     */
    public function clearAlerts()
    {
        $this->collAlerts = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collAlerts collection loaded partially.
     */
    public function resetPartialAlerts($v = true)
    {
        $this->collAlertsPartial = $v;
    }

    /**
     * Initializes the collAlerts collection.
     *
     * By default this just sets the collAlerts collection to an empty array (like clearcollAlerts());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAlerts($overrideExisting = true)
    {
        if (null !== $this->collAlerts && !$overrideExisting) {
            return;
        }
        $this->collAlerts = new ObjectCollection();
        $this->collAlerts->setModel('\Alert');
    }

    /**
     * Gets an array of ChildAlert objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSensorstation is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildAlert[] List of ChildAlert objects
     * @throws PropelException
     */
    public function getAlerts(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collAlertsPartial && !$this->isNew();
        if (null === $this->collAlerts || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAlerts) {
                // return empty collection
                $this->initAlerts();
            } else {
                $collAlerts = ChildAlertQuery::create(null, $criteria)
                    ->filterBySensorstation($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collAlertsPartial && count($collAlerts)) {
                        $this->initAlerts(false);

                        foreach ($collAlerts as $obj) {
                            if (false == $this->collAlerts->contains($obj)) {
                                $this->collAlerts->append($obj);
                            }
                        }

                        $this->collAlertsPartial = true;
                    }

                    return $collAlerts;
                }

                if ($partial && $this->collAlerts) {
                    foreach ($this->collAlerts as $obj) {
                        if ($obj->isNew()) {
                            $collAlerts[] = $obj;
                        }
                    }
                }

                $this->collAlerts = $collAlerts;
                $this->collAlertsPartial = false;
            }
        }

        return $this->collAlerts;
    }

    /**
     * Sets a collection of ChildAlert objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $alerts A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildSensorstation The current object (for fluent API support)
     */
    public function setAlerts(Collection $alerts, ConnectionInterface $con = null)
    {
        /** @var ChildAlert[] $alertsToDelete */
        $alertsToDelete = $this->getAlerts(new Criteria(), $con)->diff($alerts);


        $this->alertsScheduledForDeletion = $alertsToDelete;

        foreach ($alertsToDelete as $alertRemoved) {
            $alertRemoved->setSensorstation(null);
        }

        $this->collAlerts = null;
        foreach ($alerts as $alert) {
            $this->addAlert($alert);
        }

        $this->collAlerts = $alerts;
        $this->collAlertsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Alert objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Alert objects.
     * @throws PropelException
     */
    public function countAlerts(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collAlertsPartial && !$this->isNew();
        if (null === $this->collAlerts || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAlerts) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getAlerts());
            }

            $query = ChildAlertQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySensorstation($this)
                ->count($con);
        }

        return count($this->collAlerts);
    }

    /**
     * Method called to associate a ChildAlert object to this object
     * through the ChildAlert foreign key attribute.
     *
     * @param  ChildAlert $l ChildAlert
     * @return $this|\Sensorstation The current object (for fluent API support)
     */
    public function addAlert(ChildAlert $l)
    {
        if ($this->collAlerts === null) {
            $this->initAlerts();
            $this->collAlertsPartial = true;
        }

        if (!$this->collAlerts->contains($l)) {
            $this->doAddAlert($l);
        }

        return $this;
    }

    /**
     * @param ChildAlert $alert The ChildAlert object to add.
     */
    protected function doAddAlert(ChildAlert $alert)
    {
        $this->collAlerts[]= $alert;
        $alert->setSensorstation($this);
    }

    /**
     * @param  ChildAlert $alert The ChildAlert object to remove.
     * @return $this|ChildSensorstation The current object (for fluent API support)
     */
    public function removeAlert(ChildAlert $alert)
    {
        if ($this->getAlerts()->contains($alert)) {
            $pos = $this->collAlerts->search($alert);
            $this->collAlerts->remove($pos);
            if (null === $this->alertsScheduledForDeletion) {
                $this->alertsScheduledForDeletion = clone $this->collAlerts;
                $this->alertsScheduledForDeletion->clear();
            }
            $this->alertsScheduledForDeletion[]= clone $alert;
            $alert->setSensorstation(null);
        }

        return $this;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aSensor) {
            $this->aSensor->removeSensorstation($this);
        }
        if (null !== $this->aStation) {
            $this->aStation->removeSensorstation($this);
        }
        $this->id = null;
        $this->sensor_id = null;
        $this->station_id = null;
        $this->active = null;
        $this->delay = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->applyDefaultValues();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collAlerts) {
                foreach ($this->collAlerts as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collAlerts = null;
        $this->aSensor = null;
        $this->aStation = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(SensorstationTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {

    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
