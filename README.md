
# LibSignTool - Library Digital Signage System using Kirby
A Simple and flexible digital signage and OPAC greeter built for public terminals using [Kirby](https://getkirby.com)

Originally forked from [catsoup11789/LibraryDigitalSignage](https://github.com/catsoup11789/LibraryDigitalSignage)

<img src="https://user-images.githubusercontent.com/36831696/188289361-3358749c-edcd-40d5-abde-3f65833bad03.jpg" width="23%"></img> <img src="https://user-images.githubusercontent.com/36831696/188716082-0ef6582c-978d-4518-8e0d-c13a4c28e921.jpg" width="23%"></img> <img src="https://user-images.githubusercontent.com/36831696/188716097-aa42512f-20fc-4237-8088-f772b7bd78dd.jpg" width="23%"></img> <img src="https://user-images.githubusercontent.com/36831696/188289371-733f02eb-c18a-4445-8a51-b6b436f33345.png" width="23%"></img> <img src="https://user-images.githubusercontent.com/36831696/188289377-1bfe6173-a6ec-4a04-b4ae-42a85867a2e3.png" width="23%"></img> <img src="https://user-images.githubusercontent.com/36831696/188289378-b31aeaad-3f0b-4f88-843b-7f9efdd477a6.png" width="23%"></img> <img src="https://user-images.githubusercontent.com/36831696/188289379-821063ab-6074-44e4-8ee5-8491d405f526.png" width="23%"></img> <img src="https://user-images.githubusercontent.com/36831696/188289381-c6043f8e-874e-4639-bb4b-9154b8b0e16f.png" width="23%"></img> 


## Features



- Auto Detection of Landscape or Portrait Display for default campaign (Image Slides Only)
- Smart asset management: resizes uploaded images to proper size before loading
- Manually Choose orientation via URL Path
- Capability for multiple slideshow campaigns organized by a tagging system
- Web-based live slides for tasks such as calendar events or event goals
- Video slides
- Capability for multiple source image galleries
- Built-in Greeter page with easily customizable Link Buttons
- Start and stop date system for pre-planning when Campaigns should start and end

## Download and Install

This repository only contains the content pages of the site, you will need to download the latest Kirby plainkit seprately.

1. Before Starting, please check that your webserver meets Kirbys minimum requirements **[listed here](https://getkirby.com/docs/guide/quickstart#requirements)** and read the provided getting started documentation.
1. Download the latest release of **[Kirby Plainkit](https://github.com/getkirby/plainkit)**
1. Extract the plainkit to your Website Folder
1. Download the latest release of LibSignTool from the **[releases page](https://github.com/salinapl/LibSignTool/releases)**
1. Extract LibSignTool into the plainkit-main folder
1. Some files may ask to be overwritten, approve all overwrites.
1. Make sure hidden files such as .htaccess copied over, as these are required for the site to operate correctly.
1. Start your webserver and navigate to **yourdomain.example.com/location-of-kirbycms-install/panel** and you will be asked to create an account.
1. After creating the account, you will be able to log in and start adding images to create a campaign. The download includes example pages to get started, but you can edit or remove these pages as long as you replace them with ones using the same or similar templates. Doing more than that will require knowledge of how Kirby works. Examples of what templates do what will be provided later in this document.

## Backing up and Installing new Versions

### Kirby
Kirby is a Flat-file CMS and does not require a database, which makes it very easy to
install and backup. Just copy the folder you installed Kirby and LibSignTool to into your backup location to back it up.

To upgrade Kirby, simply download the newest version of the plainkit, Delete the "kirby" and "media" folders from your install folder, and copy the new versions from the plainkit into the folder. Always refer to the offical Kirby documentation for upgrade instructions as these are subject to change between releases.

LibSignTool is built on Kirby 3. Staying within the same generation of releases should be fine, but wait for offical word before upgrading to possible future KirbyCMS generations such as Kirby 4

#### Kirby 4
Kirby 4 is now fully supported, Kirby 3 is not supported in versions v0.3.0 and newer

### LibSignTool

Follow instructions provided in the release notes. We will generally advise to back up the site, content, and any other folders you have modified before upgrading. Typically extracting everything from the upgrade archive but the content folder is sufficent to avoid issues with data loss, but a backup is always recommended before attempting an upgrade.

## A Note about Licensing

While LibSignTool is provided free under the GPLv3 License, Kirby is not.

You can try Kirby on your local machine or on a test
server as long as you need to make sure it is the right
tool for your next project.

However Production use requires a License Key.

### Buying a license

You can purchase your Kirby license at
<https://getkirby.com/buy>

A Kirby license is valid for a single domain. You can find
Kirby's license agreement here: <https://getkirby.com/license>

You can learn more about Kirby at [getkirby.com](https://getkirby.com).

### Kirby Documentation

<https://getkirby.com/docs>

### Kirby Support

<https://getkirby.com/support>
    
## Issues

We do not develop for Kirby, for issues getting Kirby up and running, please contact that project. We only provide the website content files to host on Kirby to use as a Digital Signage Platform.

If you have a Github account, please report issues directly on Github: <https://github.com/salinapl/LibSignTool/issues>

Or you can email the maintainers directly at <tech.lib@salinapublic.org>
