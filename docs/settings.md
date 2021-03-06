# General Settings

Configure general settings

![General Settings](./img/general-settings.PNG)

## Debug

If yes, load plugin's unminified plugin css and javascript files, otherwise load minified versions.

## HTML Settings

### Minify HTML

Enable or disable HTML minification.

### IE Conditional Comments

Do not remove IE Conditional Comments

### Force Space Between Attributes

Fix invalid HTML by forcing space between HTML attributes before minifying

## Hotlink Protection

Configure hotlink protection features.

### Enabled

Enable or disable hotlink protection

### Secret

The secret key used to encrypt hotlink protected links

### Access Method

allow or Disallow HTTP method that can be used to download the files. Values are:

- any
- GET: forbid file access except when using GET
- POST: forbid file access except when using POST

### Duration

Configure how long the link remains valid

### File Type

Enable hotlink protected for the selected file types

### Custom File Type

Extend the list of files that support hotlink protection with your own type. If you want to generate links for _rar_ and _zip_ files, you will add this

```txt
zip application/zip
rar application/octet-stream
```

## Instant Page Preloading

Configure instant page preloading feature.

### Enabled

Enable or disable instant preloading

### Trigger

Configure when the page should be preloaded

### Intensity

Configure the delay between the mouseover event and the link preload

### Query String

Configure whether or not links that contain a query string are preloaded

### Allow External Links

Configure whether or not external links are preloaded

### Filter Type

Configure links pattern to be either blacklist or whitelist

### Links Pattern

Use links that match the provided patterns
