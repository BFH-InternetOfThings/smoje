//
//  SmuoyTableViewController.swift
//  Smuoy
//
//  Created by Christian Basler on 31.10.14.
//  Copyright (c) 2014 BFH. All rights reserved.
//

import UIKit
import THCCoreData

class SmuoyTableViewController: UITableViewController {
    
    var fetchedResultsController: FetchedTableController<Smuoy>?

    override func viewDidLoad() {
        super.viewDidLoad()
        
        let ctx = ContextManager.defaultManager.mainContext

        self.fetchedResultsController = FetchedTableController(tableView: self.tableView, context: ctx)
        self.fetchedResultsController?.fetchObjects(nil, sortDescriptors: [NSSortDescriptor(key: "name", ascending: true)], sectionNameKeyPath: nil)

        
        
        
        
        let smuoy = Smuoy(managedObjectContext: ctx)
        smuoy.name = "Test Smoje"
        ctx.persist()

        
        //        let ep = NSErrorPointer()
        //        ctx.save(ep)
        //        ctx.parentContext!.performBlock({ctx.parentContext!.save(ep);return})

        // Uncomment the following line to preserve selection between presentations
        // self.clearsSelectionOnViewWillAppear = false

        // Uncomment the following line to display an Edit button in the navigation bar for this view controller.
        // self.navigationItem.rightBarButtonItem = self.editButtonItem()
    }

    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }

    // MARK: - Table view data source

    override func numberOfSectionsInTableView(tableView: UITableView) -> Int {
        // #warning Potentially incomplete method implementation.
        // Return the number of sections.
        return self.fetchedResultsController!.numberOfSections()
    }

    override func tableView(tableView: UITableView, numberOfRowsInSection section: Int) -> Int {
        // #warning Incomplete method implementation.
        // Return the number of rows in the section.
        return self.fetchedResultsController!.numberOfRowsInSection(section)!
    }

    override func tableView(tableView: UITableView, cellForRowAtIndexPath indexPath: NSIndexPath) -> UITableViewCell {
        // FIXME: the error lies here:
        let cell = tableView.dequeueReusableCellWithIdentifier("SmuoyCell", forIndexPath: indexPath) as UITableViewCell

        // Configure the cell...
        let smuoy = self.fetchedResultsController!.objectAt(indexPath)!
        cell.textLabel.text = smuoy.name

        return cell
    }

    /*
    // Override to support conditional editing of the table view.
    override func tableView(tableView: UITableView, canEditRowAtIndexPath indexPath: NSIndexPath) -> Bool {
        // Return NO if you do not want the specified item to be editable.
        return true
    }
    */

    /*
    // Override to support editing the table view.
    override func tableView(tableView: UITableView, commitEditingStyle editingStyle: UITableViewCellEditingStyle, forRowAtIndexPath indexPath: NSIndexPath) {
        if editingStyle == .Delete {
            // Delete the row from the data source
            tableView.deleteRowsAtIndexPaths([indexPath], withRowAnimation: .Fade)
        } else if editingStyle == .Insert {
            // Create a new instance of the appropriate class, insert it into the array, and add a new row to the table view
        }    
    }
    */

    /*
    // Override to support rearranging the table view.
    override func tableView(tableView: UITableView, moveRowAtIndexPath fromIndexPath: NSIndexPath, toIndexPath: NSIndexPath) {

    }
    */

    /*
    // Override to support conditional rearranging of the table view.
    override func tableView(tableView: UITableView, canMoveRowAtIndexPath indexPath: NSIndexPath) -> Bool {
        // Return NO if you do not want the item to be re-orderable.
        return true
    }
    */

    /*
    // MARK: - Navigation

    // In a storyboard-based application, you will often want to do a little preparation before navigation
    override func prepareForSegue(segue: UIStoryboardSegue, sender: AnyObject?) {
        // Get the new view controller using [segue destinationViewController].
        // Pass the selected object to the new view controller.
    }
    */

}
