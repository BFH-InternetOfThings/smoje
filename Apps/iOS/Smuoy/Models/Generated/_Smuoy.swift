// DO NOT EDIT. This file is machine-generated and constantly overwritten.
// Make changes to Smuoy.swift instead.

import CoreData
import THCCoreData

enum SmuoyAttributes: String {
    case name = "name"
}

enum SmuoyRelationships: String {
    case sensors = "sensors"
}

@objc
class _Smuoy: ManagedObject {

    // MARK: - Class methods

    override class func entityName () -> String {
        return "Smuoy"
    }

    override class func entity(managedObjectContext: NSManagedObjectContext!) -> NSEntityDescription! {
        return NSEntityDescription.entityForName(self.entityName(), inManagedObjectContext: managedObjectContext);
    }

    // MARK: - Life cycle methods

    override init(entity: NSEntityDescription, insertIntoManagedObjectContext context: NSManagedObjectContext!) {
        super.init(entity: entity, insertIntoManagedObjectContext: context)
    }

    convenience init(managedObjectContext: NSManagedObjectContext!) {
        let entity = _Smuoy.entity(managedObjectContext)
        self.init(entity: entity, insertIntoManagedObjectContext: managedObjectContext)
    }

    // MARK: - Properties

    @NSManaged
    var name: String?

    // func validateName(value: AutoreleasingUnsafePointer<AnyObject>, error: NSErrorPointer) {}

    // MARK: - Relationships

    @NSManaged
    var sensors: NSSet

}

extension _Smuoy {

    func addSensors(objects: NSSet) {
        let mutable = self.sensors.mutableCopy() as NSMutableSet
        mutable.unionSet(objects)
        self.sensors = mutable.copy() as NSSet
    }

    func removeSensors(objects: NSSet) {
        let mutable = self.sensors.mutableCopy() as NSMutableSet
        mutable.minusSet(objects)
        self.sensors = mutable.copy() as NSSet
    }

    func addSensorsObject(value: SensorData!) {
        let mutable = self.sensors.mutableCopy() as NSMutableSet
        mutable.addObject(value)
        self.sensors = mutable.copy() as NSSet
    }

    func removeSensorsObject(value: SensorData!) {
        let mutable = self.sensors.mutableCopy() as NSMutableSet
        mutable.removeObject(value)
        self.sensors = mutable.copy() as NSSet
    }

}
