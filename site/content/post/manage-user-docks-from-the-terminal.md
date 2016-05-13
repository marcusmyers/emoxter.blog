+++
date = "2014-12-21T13:17:00-05:00"
draft = false
title = "Manage User Docks from the Terminal"
slug = "manage-user-docks-from-the-terminal"
aliases = [
	"manage-user-docks-from-the-terminal"
]
+++

When managing school machines there are a lot of times were you want to have a certain set of apps in the Dock on a Mac. For example you have may have a cart of MacBooks that are used as a mobile lab that should all look the same to the user.

You might be surprised how many people think there might be something wrong with the Mac because it doesn't have the same Dock as the one they used previously.  Also kids will be kids and like to mess around.

Enter [dockutil](https://github.com/kcrawford/dockutil) ([Installer DMG](http://tech.napoleonareaschools.org/wp-content/uploads/2015/01/dockutil-2.0.2.dmg)), a command line utility written in Python.  The installer puts the utility in the ``/usr/local/bin`` directory, which is already in your path environment.  After install open up the terminal and run:

```
/~$ dockutil -h
usage:     dockutil -h
usage:     dockutil --add <path to item> | <url> [--label <label>] [ folder_options ] [ position_options ] [ plist_location_specification ] [--no-restart]
usage:     dockutil --remove <dock item label> | all [ plist_location_specification ] [--no-restart]
usage:     dockutil --move <dock item label>  position_options [ plist_location_specification ]
usage:     dockutil --find <dock item label> [ plist_location_specification ]
usage:     dockutil --list [ plist_location_specification ]
usage:     dockutil --version

position_options:
...
```

On our cart laptops we have LaunchAgent run this bash script:
```
#!/bin/bash

DOCKUTIL=/usr/local/bin/dockutil

$DOCKUTIL --remove all
$DOCKUTIL --add '/Applications/Google Chrome.app' --no-restart
$DOCKUTIL --add '/Applications/Safari.app' --no-restart
$DOCKUTIL --add '/Applications/Firefox.app' --no-restart
$DOCKUTIL --add '/Applications/Maps.app' --no-restart
$DOCKUTIL --add '/Applications/Notes.app' --no-restart
$DOCKUTIL --add '/Applications/Numbers.app' --no-restart
$DOCKUTIL --add '/Applications/Keynote.app' --no-restart
$DOCKUTIL --add '/Applications/Pages.app' --no-restart
$DOCKUTIL --add '/Applications/iBooks.app' --no-restart
$DOCKUTIL --add '/Applications/Managed Software Center.app' --no-restart
$DOCKUTIL --add '/Applications' --no-restart
$DOCKUTIL --add '~/Downloads'

exit 0
```

####What's going on here?!?
The ``$DOCKUTIL --remove all`` removes everything in the Dock which you might have guessed. ``$DOCKUTIL --add '/Applications/Google Chrome.app`` adds the Google Chrome web browser, but the added ``--no-restart`` doesn't restart the Dock meaning we have more to do. The default action is to restart the Dock after you make a change, by passing in the ``--no-restart`` it surpresses the OSes urge to restart it. Note that the of the script we ad the __Downloads__ folder as ``dockutil`` is able to differentiate the difference of an app and a folder.  

Hopefully the ``dockutil`` becomes a good utility for you to manage a users Dock.
