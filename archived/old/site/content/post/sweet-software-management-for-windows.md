+++
date = "2014-04-29T21:34:00-04:00"
draft = false
title = "Sweet Software Management for Windows"
slug = "sweet-software-management-for-windows"
tags = ["windows", "chocolatey", "automate", "devops"]
categories = ["Windows", "DevOps"]
aliases = [
	"sweet-software-management-for-windows"
]
+++

Managing software on the Windows platform can be very cumbersome. Using Group Policy can sometimes be a hassle as it may take a couple restarts in order for the machine to get the software. Of course you could also purchse [Microsoft Systems Manager](http://www.microsoft.com/en-us/server-cloud/products/system-center-2012-r2/default.aspx#fbid=3PLDgMbYfRx) at a hefty chunk of cheese, but like me you work in educaiton so money is tight.

## Baked In
The quickest solution is to bake in all the software you need into a computer image. So if you have 3 computer labs that all serve different purposes you would create an image for each lab.  Lets also assume each lab has the same exact computer model the only thing that separates them is the software installed on them. Then you start adding all the teacher machines which can be separated by department and the list goes on.  

As you can see your imaging server can get bloated quick if you start baking in your software to all images. To me the less we have in the base image the faster it is to image a whole building. You might say, "*You still have to install all the software!*", but we'll get to that in a little bit.

## "Holy Chocolate(y) Eclair, Batman!"
Enter [chocolatey](http://chocolatey.org), an apt-get for Windows. Chocolatey has over 7,000 packages to install onto Windows with ease.  For example lets say we want to install Acrobat Reader on your Windows machine.

```
C:\> cinst adobereader
```

This will install the latest version that is in the chocolatey packages. Seems a little too simple doesn't it? That's what is so nice about it.  Simple. To the Point. 
So lets say you have a post-image script that runs and installs all the software needed for that particular machine or lab.  That would solve the problem of bloating your imaging server with a different image for each user(s) specific set of software.

## Installing Chocolatey
Installing chocolatey is a simple command in the command prompt.
```
C:\>  @powershell -NoProfile -ExecutionPolicy unrestricted -Command "iex ((new-object net.webclient).DownloadString('https://chocolatey.org/install.ps1'))" && SET PATH=%PATH%;%systemdrive%\chocolatey\bin
```
>Note: There have been issues when using `https://chocolatey.org/install.ps1` to fix the issue just remove the 's' and use this instead `http://chocolatey.org/install.ps1`


BUT there are a couple requirements needed on the operating system.

Requirements:

* Windows XP/Vista/7/8/2003/2008
* .NET Framework 4.0
* PowerShell 2.0

>Note: If you have .NET Framework 3.5 installed, chocolatey will take care of installing .NET 4.0. 

## The Chocolatey Goods
At work we are actually using [chocolatey](http://chocolatey.org) as a package provider for our [Puppet](http://puppetlabs.com) setup. We created a base node for Windows that has all the base software that we need for all machines.  So for example every one of our machines, no matter what, have the following installed.

* Adobe Reader
* Adobe Flash Player (plugin & active-x)
* Mozilla Firefox
* Google Chrome
* PDFCreator
* VLC
* K-Lite Codec Pack
* Java Runtime Environment
* Quicktime
* Putty
* Silverlight

So each computer is defined as a `node` in puppet and you can define what is installed and some other configuration stuff.  Enough about puppet for now but here is a possible example of how to define a puppet node and how we use it with chocolatey to install software.

```
# /etc/puppet/manifests/site.pp
node winbasenode {
  ...
  package { 'vlc':
    ensure => installed,
  }
  
  package { 'adobereader':
    ensure => installed,
  }
  
  package { 'firefox':
    ensure => installed,
  }
  
  package { 'googlechrome':
    ensure => installed,
  }
  ...
}

node 'hs-adm-princ.domain.lan' inherits 'winbasenode' {
   // More node definitions go here
}
```

So in short every software package that is defined in the `winbasenode` will get installed on the `hs-adm-princ.domain.lan` machine. Using chocolatey with puppet makes for a "set it and forget it" kind of imaging process.

## Resources {#resources}
* [Chocolatey vs Ninite](https://github.com/chocolatey/chocolatey/wiki/ChocolateyVsNinite)
* [Ninite](https://ninite.com/)
* [Chocolatey](http://chocolatey.org/)

