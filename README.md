# rla-site

Code for the Rising Leaders Academy website, [risingleadersacademy.org](https://risingleadersacademy.org).

The site is WordPress on GoDaddy Managed WordPress. It's moving off Beaver Builder one page at a time. This repo holds the code for the new design. Page content stays in WordPress.

## `rla-design/`: the New design plugin

Adds a **New design** page template. A page that picks it gets the new header, footer, CSS and JS. Every other page keeps the current Beaver Builder theme. Nothing changes until someone picks the template for a page.

- **Preview first:** a page on the new template shows the new design only to people who can edit it. Visitors keep seeing the old page until you tick **Show the new design to visitors** in the page's **New design** box.
- **Clean slate:** on new-design pages the old theme's CSS and JS aren't loaded. Beaver Builder's CSS isn't loaded either, unless the page itself still uses Beaver Builder.
- **Visual editing for staff:** pages on the template are edited in the WordPress block editor. The editor shows the new styles, and **Patterns → RLA** has pre-designed sections: photo beside text, list of documents, call to action, and three cards.
- **Admin aids:**
  - **Pages → All Pages** has a **Design** column showing New (preview), New (live) or —.
  - On the front end, the admin bar shows the page's status, with a **View the old design** link for comparison.

### Install

Activating the plugin changes nothing on the live site.

**Option 1: upload a zip.** Go to **Plugins → Add New → Upload Plugin**, choose `rla-design.zip`, then activate it.

**Option 2: SFTP.** Copy the `rla-design/` folder into `wp-content/plugins/`, then activate it under **Plugins**.

### Moving a page to the new design

1. **Keep a copy of the old version.** For a Beaver Builder page, use Beaver Builder's **Tools → Save Template**, or copy the page to a private draft.
2. **Pick the template.** In the page editor's sidebar, set **Template** to **New design**, then save. Only editors see it for now.
3. **Rebuild the content with blocks.** Use **Patterns → RLA** for designed sections.
4. **Review the real page while logged in.** Use the admin bar's **View the old design** link to compare.
5. **Switch it live.** Tick **Show the new design to visitors** and save.
6. **Flush the cache.** In WordPress, go to **GoDaddy → Tools → Flush Cache**.
7. **Mark the page Done** in the page migration tracker.

To roll back, untick **Show the new design to visitors**, or set **Template** back to **Default template**.

### Menus

The new header and footer use the same menus as the current site:

- **main** in the header
- **Footer Menu** in the footer

To use different menus on new-design pages, assign them to **New design: main menu** and **New design: footer menu** under **Appearance → Menus → Manage Locations**.

### Maps and embeds

The site's firewall rejects any page save that contains an `<iframe>`, so pasted embed code won't save. Here's what to use instead:

- **Map:** add the **Map and address** pattern, or a Shortcode block with `[rla_map]`. You can also set the address and height: `[rla_map address="…" height="420"]`.
- **YouTube:** paste the video URL into an Embed or YouTube block. WordPress stores only the URL.

### Contact details and logo

Address, phone, email, hours, logo and the Apply link are set in `rla-design/includes/settings.php`. Code elsewhere can change them with the `rla_design_settings` filter.

### Files

| Path | What it is |
| --- | --- |
| `rla-design.php` | Plugin header and loader |
| `includes/template.php` | Template registration, the preview gate and body classes |
| `includes/assets.php` | Loads the new CSS and JS, removes the old theme's, and adds editor styles |
| `includes/admin.php` | The **New design** box, the **Design** column and the admin-bar badge |
| `includes/menus.php` | Menu locations and fallbacks |
| `includes/patterns.php` and `patterns/*.html` | Block patterns |
| `includes/settings.php` | Site details |
| `templates/` | The page template, header and footer |
| `assets/css/site.css` | Front-end styles. Everything is scoped under `body.rla`. |
| `assets/css/editor.css` | Styles for the block editor |
| `assets/js/site.js` | Mobile menu and dropdowns |

Tested on WordPress 7.1.4 with PHP 8.3 and a classic theme. The tests covered:

- visitors and editors on preview and live pages
- the old-design comparison link
- asset loading and removal
- the **New design** box and its save
- the **Design** column
- editor styles
- pattern markup
- desktop and mobile layouts
