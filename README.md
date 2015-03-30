# Typeset2
A simple content management system that can be added to most any PHP website. Ideal for small custom hand-made websites that need to allow the client to update small bits of content themselves.

### Features

- **Non-intrusive:** You add it to your website, vs. having to adjust your workflow and build your website around the CMS. 
- **Crazy simple to use:** Have a stupid client that can't be trusted with a WordPress site? Perfect.
- **Almost-inline editing:** Rather than a separate admin area, users can click on the content they'd like to edit and do so right on the page.
- **Markdown** Text formatting to give users enough control to format their text, but not enough to make it ugly.
- **Client-side image resizing:** Images are resized client side *before* they're uploaded, so much larger images can be used without having to worry about upload/memory limits.

### Demo

http://typeset2.resen.co/edit  
Name: `demo`  
Password: `demo`

### Installation

1. Upload the `html/edit` folder to the root level of the website (You don't need the rest of the stuff).
1. Create a new MySQL database by importing the `database_template.sql` file.
1. Open "edit/_settings.php" and change the settings appropriately.
1. Insert `<? include "/edit/include.php" ?>` at the top of any pages that should display managed content.
1. Insert the appropriate "widget" in the pages where necessary.
1. The admin area is accessible via yourwebsite.com/edit

### Widgets

#### blurb
Markdown or HTML-formatting text, with optional title and image. Good for informational blurbs like "About Us" sections.
```php
$typeset->blurb(array(
	"id" => "",
	"tag" => "",
	"image_width" => 1000,
	"image_height" => 1000,
	"format" => "html"
));
```

#### html
Direct text input without Markdown formatting.
```php
$typeset->html(array(
	"id" => "",
	"tag" => "",
	"format" => "html"
));
```

#### blog
Sequential content for use as blog posts, news, events, or most other kinds of groups of content items.
```php
$typeset->blog(array(
	"title" => "Latest News", // Title of the widget
	"id" => "", // ID attribute given to the html element
	"tag" => "", // Used to differentiate multiple instances of the same content type in the database
	"truncate" => 0, // Truncates the posts to short blurbs of x characters
	"format" => "html", // html, json, raw
	"items" => 10, // Number of items shown
	"sort" => "date", // Property to sort by
	"order" => "DESC", // ASC, DESC
	"scope" => "past", // Limit results to past, future, or all
	"image_width" => 1000,
	"image_height" => 1000,
	"thumb_width" => 200,
	"thumb_height" => 200,
	"page" => "post" // Page that displays full blog posts
));
```

#### banner
Similar to blog content, but allows linking to offsite urls, has more focus on images themselves, and has no concept of dates.
```php
$typeset->banner(array(
	"title" => "Banners",
	"id" => "",
	"tag" => "",
	"format" => "html",
	"items" => 50,
	"sort" => "id",
	"order" => "DESC",
	"image_width" => 1000,
	"image_height" => 1000
));
```

### Templates
Content templates are in the "/edit/templates" folder. Each content type has a default template, but that can be overridden by passing the "template" option to the class.

### Misc Functions
- The title of an article can be grabbed with `<?= $typeset->post_title() ?>`, which is useful for things like `<title>` meta tags.


