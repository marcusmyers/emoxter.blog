+++
date = "2017-03-20T09:00:00-05:00"
draft = false
title = "Install Jenkins on macOS"
slug = "install-jenkins-on-macos"
tags = ["macOS", "jenkins", "automate", "devops"]
categories = ["macOS", "Jenkins", "DevOps"]
aliases = [
  "automate-all-the-things-part-1"
]
+++
# Automate all the things (_Part 1_)

As a DevOps Engineer you're constantly trying to automate almost everything you do to make you life easier. What better way to automate things then using [Jenkins](https://jenkins.io). This post is a first part of a series on how to use Jenkins to automate almost everything to manage macOS machines.

## Why macOS?

_"Why macOS when you can use a [Docker](https://hub.docker.com/_/jenkins/) image?"_ you might ask, but there is a method to my madness here and I hope you read the whole series. I will highlight some very cool things about Jenkins and macOS.


### Download & Install

To download the latest stable version of Jenkins for macOS click [here](https://jenkins.io/content/thank-you-downloading-os-x-installer/#stable) and run the package to install it to your Mac. The installer sets up Jenkins as a launch daemon, listening on port 8080. The launch daemon picks up the command line options from a standard preferences file, `/Library/Preferences/org.jenkins-ci.plist`. If the file does not exist, built-in defaults are used. Once Jenkins is done being installed restart your computer and then open a browser to navigate to _http://localhost:8080_.

> **NOTE:** If you would like to configure it outside of the defaults please check [here](https://wiki.jenkins-ci.org/display/JENKINS/Thanks+for+using+OSX+Installer).

### Configure Security

Immediately after installation, Jenkins will allow anyone to run anything as user Anonymous, which is bad. We will need to configure security for the newly installed Jenkins installation. Navigate to _Manage Jenkins > Configure Global Security_ where you should something like this picture below:

_Picture 1_
![alt text](configure-global-security.png "Picture 1")

Before you do anything, create a user that has full administrative rights and everything checked in the matrix security on Jenkins. After the user is created, you should select _Jenkins' own user database_ and now once you save everything you should get a login screen. If you would want to setup a different login method please check out [this](https://wiki.jenkins-ci.org/display/JENKINS/Standard+Security+Setup).
> **NOTE:** You can also use other methods to log into Jenkins with [Plugins](https://plugins.jenkins.io/), like _GitHub_.

## Play around

Let's stop there in order to let you play around with Jenkins once it's setup on your Mac. Check out this video on [YouTube](https://www.youtube.com/watch?v=2tR8PCd43VQ) to create your first build job. In _Part 2_ of this series we will setup a build job that uses [AutoPkg](http://autopkg.github.io/autopkg/) to download installable packages for macOS.
