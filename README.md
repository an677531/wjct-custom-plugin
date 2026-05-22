# wjct-custom-plugin
# Custom WordPress plugin built for the WJCT WordPress Developer skills test.

## What this plugin does
- Adds in a custom post type called "Cat Picks" with a paw icon in the dashboard
- Adds in a custom meta field called "Featured By" and allows the user to enter text into the field to be displayed in the post.
- Displays the entered content on the page, preceded by text "Featured By: ".

## How to install
1. Download or clone this repository into your WordPress plugins directory at wp-content/plugins/
2. Log into WordPress admin dashboard and navigate to Plugins
3. Activate Cat Picks

## How to test
- Verify that the new custom post type called "Cat Picks" is visible in the menu sidebar
- Create a new Cat Pick post with a title and content
- Scroll down below the content editor to find the Featured By field and enter text into the field
- Click Update or Save
- Click View Post and confirm the Featured By value appears on the page.

## What I would improve
Given more time I would consider adding a feature which allows the editor to add multiple contributors, allowing editors to add just one or multiple people to the "Featured By" section.

## Additional Notes
I used Claude as a development collaborator throughout this project. Specifically I used it to generate the initial boilerplate for the plugin structure, verify WordPress best practices around nonce verification and sanitization, and talk through implementation decisions. All code was reviewed, tested, and understood before committing.
