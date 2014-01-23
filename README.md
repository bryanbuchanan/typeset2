# Typset
A simple content management system that can be added to most any PHP website.

### Installation
1. Make sure the host website is running PHP.
2. Upload the "edit" folder to the root level of the website.
3. Open "edit/_settings.php" and change the settings appropriately.
4. Insert `<? include "/edit/include.php" ?>` at the top of any pages that should display managed content.
5. Insert the appropriate "widget" in the pages where necessary.

### Content Types

#### blurb
Markdown or HTML-formatting text, with optional title and image. Good for informational blurbs like "About Us" sections.
```php
$typset->blurb(array(
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
$typset->html(array(
	"id" => "",
	"tag" => "",
	"format" => "html"
));
```

#### blog
Sequential content for use as blog posts, news, events, or most other kinds of groups of content items.
```php
$typset->blog(array(
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
$typset->banner(array(
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
- The title of an article can be grabbed with `<?= $typset->post_title() ?>`, which is useful for things like `<title>` meta tags.

test test test