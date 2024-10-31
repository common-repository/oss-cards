=== VIVA(OSS) Content Cards ===
Contributors: andrew112512
Donate link: http://vivapro.net/donate/
Tags: cards, display pages, display featured posts, link internal, link cards
Requires at least: 6.0
Tested up to: 6.2.2
Requires PHP: 7.4
Stable tag: 1.1.1
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Present your products, services or content using beautiful cards. All you do you can see in admin panel without saving or reloading.

== Description ==

[Demo Frontend](http://demo.vivapro.net/viva-cards-free/) | [Demo Admin -  Playground](http://demo.vivapro.net/play/cards-free.php)

## Main Features

* Content Item as card data(any type including custom which has text)
* Featured Image as Card Image
* Icons as a card Image
* Fully editable, you can change image, edit text, change colors etc, before to add or then editing
* Titles, descriptions
* Button, simple link or whole cad as a link
* Two layout – horizontal or vertical
* Full customization of all elements
* 5 Animation effects
* 10 Border/shadow styles
* 12 Title styles
* Live preview in admin dashboard
* Shortcode or Widget to display cards

### New in Version 1.1.1

[youtube https://www.youtube.com/watch?v=jm-16U7mkME]

### Short Video Introduction

[youtube https://www.youtube.com/watch?v=Usn8io2WIHc]


== Frequently Asked Questions ==

= Why when i pick any content items it add unknown image as  the card image? =
It happens if you you page, post or other content types has no Featured Image. If plugin doesn't find it adds default image, you can replace it with any other. Featured image is should be added in the past add/edit page(usually on right sidebar box)
= My page has Featured Image, but instead it plugin uses one from previous card? =
You try to add it too fast. To pick image plugin does additional request, as featured image doesn't included to post object, only its id. You should just wait 1-2 seconds before to click add. In the next versions we are also going to add options to collect image frob article body if it exists.
= How many cards I can add? =
As many as you wish. In horizontal mode maximum cards in row is four, but  you can have more. If you amount not equal 4 for row, rest of cards also have same width and will be centered.

= What icons do you use =
We use FontAwesome version 5. We tried to use Google Material Icons as it has 4 more parameters for settings, but unfortunately it's done as direct code, not as class - ie it can show code, for a moments while css is loading, it's not good, especially if icon is big as we use.
= What is export option =
Using export option you can copy JSON code of cards and pass it to another or even to another site. Import is looks like export - just click export tab on new cards, and paste code replacing existing default one. Don't forget to save and reload page then
= I have problem with my cards, how can you help me =
Function Export also was done for debugging, just copy code from Export tab and send. 

== Installation ==
1. Upload the entire `oss-cards` folder to the `/wp-content/plugins/` directory.
1. Activate the plugin through the **Plugins** screen (**Plugins > Installed Plugins**).

== Screenshots ==
1. screenshot-1.jpg
2. screenshot-2.jpg
3. screenshot-3.jpg
4. screenshot-4.jpg
5. screenshot-5.jpg

== Upgrade Notice ==
NOTE: your site should have REST API enabled

== Changelog ==
= 1.1.1 - July 12, 2023 =
Fixed minor bugs
= 1.1.0 - July 10, 2023 =
Updated Interface 
Added Option to pick content Items as card data
Added New Icons Picker(full screen for better selection)
Added Setting Page
