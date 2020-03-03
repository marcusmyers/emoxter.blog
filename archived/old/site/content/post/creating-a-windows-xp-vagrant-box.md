+++
categories = ["Windows XP", "Vagrant"]
tags = ["windows", "vagrant", "devops"]
date = "2014-04-17T21:34:00-04:00"
draft = false
title = "Creating a Windows XP Vagrant box"
slug = "creating-a-windows-xp-vagrant-box"
aliases = [
	"creating-a-windows-xp-vagrant-box"
]
+++

[Vagrant](http://vagrantup.com) is a great tool to use when creating test boxes.  Although it is commonly used with *nix servers, but a lot of the time we may want to test other things such as a Windows box.  Because of obvious licensing issues there are NO Windows Vagrant boxes published online.

Vagrant is a great tool to use with [VirtualBox](http://www.virtualbox.org), until recently they added VMWare Fusion and Workstation for a price. VirtualBox is free and is an easy tool to get started with when using Vagrant.

[Post Resources](#resources)

> **Note:** Vagrant now defaults to WinRM for Windows

## Getting Started

Here are the steps we will go through in this guide.  (This assumes you already have Vagrant and VirtualBox installed.)

1. Install [vagrant-windows](https://github.com/WinRB/vagrant-windows) plugin
2. Create and configure a Windows XP guest base box

## Install vagrant-windows plugin <a name="vagrant-window"></a>

This will be the easiest step.

<code>vagrant plugin install vagrant-windows</code>

## Creating a Base Box

Out of the box the [vagrant-windows](https://github.com/WinRB/vagrant-windows) plugin supports the following Windows Operating Systems:

* Windows 7
* Windows 8
* Windows Server 2008
* Windows Server 2008 R2
* Windows Server 2012

So setting up XP will take a little more configuration.  If you are setting up one of the supported operating systems please follow the guide on the [vagrant-windows](https://github.com/WinRB/vagrant-windows) page.

### Install XP

This guide is not created to show you how to create a Windows XP guest on VirtualBox but here are is what I used for creating my guest box.

* Name: XP-BASE-BOX (We will need the name to create the base box) 
* Memory: 512MB
* Hard Drive: 20GB (Dynamically Allocated)

You can obviously change these settings as you see fit.  But these settings are what we used to hopefully help make the vagrant box as small as possible.  Our vagrant box ended up being ~2GB after the fact.

### Needed software for XP

Once you have your base box created we need to install a couple things to make it work with Vagrant.

* [PowerShell](http://www.microsoft.com/en-us/download/details.aspx?id=7217) *This will get upgraded to 2.0 when you install WinRM 2.0
* [WinRM 2.0](http://www.microsoft.com/en-us/download/details.aspx?id=16818)
* [Symbolic Link Driver for XP](http://homepage1.nifty.com/emk/symlink-1.06-x86.cab)
* [SSH Server](http://sshwindows.sourceforge.net/)

### WinRM (Windows Remote Management)

To get started with with WinRM you must set the following registry key to zero in order to all WinRM to work "remotely" on Windows XP.
```
HKLM\SYSTEM\CurrentControlSet\Control\Lsa forceguest 0
```
Next we will need to configure WinRM on the XP base box.  Open up the command prompt and type these in the prompt.

```
C:\> winrm quickconfig -q
C:\> winrm set winrm/config/winrs @{MaxMemoryPerShellMB="512"}
C:\> winrm set winrm/config @{MaxTimeoutms="1800000"}
C:\> winrm set winrm/config/service @{AllowUnencrypted="true"}
C:\> winrm set winrm/config/service/auth @{Basic="true"}
C:\> sc config WinRM start= auto
```

The settings above create defaults for WinRM.

### Symbolic Link Driver
The symbolic link driver makes it possible to share folders between your computer and the vagrant box, checkout [Vagrant Synced Folders](http://docs.vagrantup.com/v2/getting-started/synced_folders.html). Once you have downloaded the driver open the `.cab` file and copy all the files (`ln.exe, senable.exe, symlink.sys`) to `C:\WINDOWS` directory. Open up the command prompt and type the following:

```
> cd C:\WINDOWS
C:\WINDOWS> senable.exe install
```

Windows 7 came with a utility called `mklink` that creates symbolic links like `ln` for *nix type systems. Once again `vagrant-windows` supports Windows 7 and up so it will be looking for the `mklink` to create that synced folder.  In order to fake `mklink` for `vagrant-window` we need to do the following steps. 

### mklink.cmd
Open up notepad and paste the following:
```
@echo off

SET DIR=%~dp0%
@powershell -NoProfile -ExecutionPolicy unrestricted -Command "& '%DIR%Symlink.ps1' %*"

pushd "%DIR%"
"%DIR%senable.exe" start
popd
```

Save this file as `mklink.cmd` to `C:\WINDOWS`

### Symlink.ps1

Open up notpad and paste the following:
```
param (
 [string]$symlinktype,
 [string]$link,
 [string]$target
)

$scriptpath = $MyInvocation.MyCommand.Path
$ScriptDir = Split-Path $scriptpath

$senable = Join-Path "$ScriptDir" senable.exe
$ln = Join-Path "$ScriptDir" ln.exe

pushd "$ScriptDir"
& cmd /c "$senable" install
popd
& cmd /c "$ln" -s "$target" "$link"
```
Save this file as `Symlink.ps1` to `C:\WINDOWS`

### The Vagrant File
Vagrant loads multiple `Vagrantfile`s read the following page to understand vagrant file load ordering, [Vagrantfile Load Order](http://docs.vagrantup.com/v2/vagrantfile/#load-order). We can actually package a `Vagrantfile` with the box.  Anything that is in the `Vagrantfile` that you package with the box does not need to be in the project directory `Vagrantfile`.  Here's the `Vagrantfile` we will be packing with the base box. (I created a `XP` folder inside my `~/Documents` folder on my mac and put the `Vagrantfile` in it.)

```
Vagrant.configure("2") do |config|

  # Configure base box parameters
  config.vm.box = "windowsxp"
  config.vm.box_url = "./windowsxp.box"
  config.vm.guest = :windows

  config.vm.boot_timeout = 600
  # Port forward WinRM and RDP
  config.vm.network :forwarded_port, guest: 3389, host: 3389
  config.vm.network :forwarded_port, guest: 5985, host: 5985, id: "winrm", auto_correct: true

  # Provider 
  config.vm.provider "virtualbox" do |v|
    v.gui =true
  end
end
```

### Creating the vagrant box
Here's the command to create our base xp box:

```
:~/Documents/XP$ vagrant package --base XP-BASE-BOX --output windowsxp.box --vagrantfile ./Vagrantfile
```
#### Breakdown
```
--base XP-BASE-BOX
```
The `--base` command takes an argument of VirtualBox machine name to package as a base box.

```
--output windowsxp.box
```
The `--output` command takes an argument to name you newly packaged box. If you don't use the `--output` command it defaults to `package.box`.

```
--vagrantfile ./Vagrantfile
```
The `--vagrantfile` command will package a `Vagrantfile` with your new base box.

## Conclusion
Creating vagrant boxes aren't that hard to do, especially for operating systems that are still supported.  The truth is we are unfortunately still using XP at work and using a vagrant box to test things is a lot quicker than imaging a machine. We use [Puppet](http://www.puppetlabs.com) to manage all our desktops/laptops at work and having a way to test all our platforms using VirtualBox makes it so simple.  In a future post I will discuss how we use this vagrant box.

## Resources {#resources}
* [WinRb/vagrant-windows](https://github.com/WinRb/vagrant-windows)
* [Vagrant Package Command](http://docs.vagrantup.com/v2/cli/package.html)
* [Symbolic Links in XP](http://stackoverflow.com/questions/4339220/is-there-a-way-to-map-a-unc-path-to-a-local-folder-on-windows-2003/18593425#18593425)
* [Symbolic Link Driver for XP](http://schinagl.priv.at/nt/ln/ln.html#symboliclinksforwindowsxp)
* [Vagrant Boxes](http://www.vagrantbox.es/)
