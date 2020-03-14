+++
date = "1969-12-31T19:00:00-05:00"
draft = true
title = "Adding Chocolatey as a Package Provider to Windows 10"
slug = "adding-chocolatey-as-a-package-provider-to-windows-10"
aliases = [
	"adding-chocolatey-as-a-package-provider-to-windows-10"
]
+++
```powershell
PS C:\Users\User> Register-PackageSource -Name chocolatey -Location https://chocolatey.org/api/v2 -Provider NuGet -Trusted -Verbose
```
