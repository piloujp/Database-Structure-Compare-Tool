***Database Structure Compare Tool*** is an encapsulated plugin for Zen Cart v2.1.0 and above that allows you to **compare** two databases **structures**. This can be very useful when doing some database upgrade or trouble shooting ZC or plugins installation that modify database.  
Important: To use this plugin, your database user must have access to the information_schema table which might not be the case on some hosting. Please check before downloading.  
After you choose a database to compare yours to, columns differences will be displayed with a color code and highlight on the difference. Optionally, you can although display tables names that are not shared by both databases.

### INSTALL:

**Copy zc_plugins folder content** to the zc_plugins folder in your cart. Then go to Zen Cart **admin menu Modules->Plugin Manager**. You should now see *Database Structure Compare Tool* in the plugin list. **Click on Install** button on the right as many times as necessary and you are done.

### USAGE:

Choose a database to compare yours to in the drop down menu. As soon as it is done results will appear below.  
Note: The drop down menu will only list databases your user has access too.  
If some tables are only present in one of the databases, then a large button will appear  below the drop down, for each of the databases. Clicking on it will display the list of tables only found in this database.

### UNINSTALL:

Like for installation, use Zen Cart's **Plugin Manager** in admin: Modules->Plugin Manager. You can either disable the plugin or uninstall it. **Disable** option will just deactivate the plugin but deletes nothing. **Uninstall** will remove configuration keys from the database and deactivate the plugin.
