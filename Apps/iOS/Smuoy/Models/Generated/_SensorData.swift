// DO NOT EDIT. This file is machine-generated and constantly overwritten.
// Make changes to SensorData.swift instead.

import CoreData
import THCCoreData

enum SensorDataAttributes: String {
    case group = "group"
    case sensor = "sensor"
    case unit = "unit"
    case value = "value"
}

enum SensorDataRelationships: String {
    case smuoy = "smuoy"
}

@objc
class _SensorData: ManagedObject {

    // MARK: - Class methods

    override class func entityName () -> String {
        return "SensorData"
    }

    override class func entity(managedObjectContext: NSManagedObjectContext!) -> NSEntityDescription! {
        return NSEntityDescription.entityForName(self.entityName(), inManagedObjectContext: managedObjectContext);
    }

    // MARK: - Life cycle methods

    override init(entity: NSEntityDescription, insertIntoManagedObjectContext context: NSManagedObjectContext!) {
        super.init(entity: entity, insertIntoManagedObjectContext: context)
    }

    convenience init(managedObjectContext: NSManagedObjectContext!) {
        let entity = _SensorData.entity(managedObjectContext)
        self.init(entity: entity, insertIntoManagedObjectContext: managedObjectContext)
    }

    // MARK: - Properties

    @NSManaged
    var group: String?

    // func validateGroup(value: AutoreleasingUnsafePointer<AnyObject>, error: NSErrorPointer) {}

    @NSManaged
    var sensor: String?

    // func validateSensor(value: AutoreleasingUnsafePointer<AnyObject>, error: NSErrorPointer) {}

    @NSManaged
    var unit: String?

    // func validateUnit(value: AutoreleasingUnsafePointer<AnyObject>, error: NSErrorPointer) {}

    @NSManaged
    var value: NSNumber?

    // func validateValue(value: AutoreleasingUnsafePointer<AnyObject>, error: NSErrorPointer) {}

    // MARK: - Relationships

    @NSManaged
    var smuoy: Smuoy?

    // func validateSmuoy(value: AutoreleasingUnsafePointer<AnyObject>, error: NSErrorPointer) {}

}

