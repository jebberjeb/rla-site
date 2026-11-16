# rla-site

Code for the Rising Leaders Academy website, [risingleadersacademy.org](https://risingleadersacademy.org).

The site is WordPress on GoDaddy Managed WordPress. It's moving off Beaver Builder one page at a time. This repo holds the code for the new design. Page content stays in WordPress.

## `rla-design/`: the New design plugin

Adds two page templates. A page that picks one gets the new header, footer, CSS and JS. Every other page keeps the current Beaver Builder theme. Nothing changes until someone picks a template for a page.

- **New design:** a green title band with the page title (and the page's excerpt, if it has one, as a subtitle), then the content in a readable column. For ordinary pages.
- **New design: full width:** no title band; the content runs edge to edge. Build it from the full-width **Section** patterns. For the home page and landing pages.

- **Preview first:** a page on the new template shows the new design only to people who can edit it. Visitors keep seeing the old page until you tick **Show the new design to visitors** in the page's **New design** box.
- **Clean slate:** on new-design pages the old theme's CSS and JS aren't loaded. Beaver Builder's CSS isn't loaded either, unless the page itself still uses Beaver Builder.
- **Visual editing for staff:** pages on the template are edited in the WordPress block editor. The editor shows the new styles, and **Patterns → RLA** has pre-designed sections (see [Patterns](#patterns)).
- **Admin aids:**
  - **Pages → All Pages** has a **Design** column showing New (preview), New (live) or —.
  - On the front end, the admin bar shows the page's status, with a **View the old design** link for comparison.

### Install

Activating the plugin changes nothing on the live site.

**Option 1: upload a zip.** Go to **Plugins → Add New → Upload Plugin**, choose `rla-design.zip`, then activate it.

**Option 2: SFTP.** Copy the `rla-design/` folder into `wp-content/plugins/`, then activate it under **Plugins**.

### Moving a page to the new design

Build the new version in a private copy first. Turning Beaver Builder off on the real page would show half-finished content to visitors straight away, inside the old theme.

1. **Make a private draft.** Add a new page with the same title. Set **Template** to **New design** (or **New design: full width**) and visibility to **Private**. Only logged-in editors can see it.
2. **Build the content with blocks.** Use **Patterns → RLA** for designed sections.
3. **Review the draft at its own URL** and change it until it's approved.
4. **Swap it in, in one sitting:**
   1. Keep a copy of the old version. For a Beaver Builder page, use Beaver Builder's **Tools → Save Template**.
   2. Copy the draft's blocks into the real page.
   3. Turn Beaver Builder off for that page.
   4. Set **Template** to **New design** and tick **Show the new design to visitors**, then update.
   5. Trash the draft.

   A one-click "publish this draft over the real page" action is planned, so this step will get simpler.
5. **Flush the cache.** In WordPress, go to **GoDaddy → Tools → Flush Cache**.
6. **Mark the page Done** in the page migration tracker.

To roll back, untick **Show the new design to visitors**, or set **Template** back to **Default template**.

For a page that doesn't change content, only design (for example a page already outside Beaver Builder, like Our Staff), you can skip the draft. Set its Template to **New design**, review it while logged in, then tick **Show the new design to visitors**.

### Patterns

In the block editor, open the inserter (**+**) → **Patterns → RLA**.

For any page:

| Pattern | What it adds |
| --- | --- |
| Photo beside text | A photo next to a heading and paragraph |
| List of documents | Download links, styled as a list |
| Call to action | A highlighted box with a button |
| Three cards | Three short cards in a row |
| Map and address | The school address and a Google map |

For full-width pages (each is a band that runs edge to edge):

| Pattern | What it adds |
| --- | --- |
| Section: hero with photo | Big headline, a sentence, two buttons and a photo. Use once, at the top. |
| Section: highlights row | Four short facts with big values, on a tinted band |
| Section: video beside text | A YouTube video next to a heading and paragraph |
| Section: cards with photos | A grid of photo cards that link to pages |
| Section: award badges | A gallery of award badges, shown whole rather than cropped |
| Section: quick links | A grid of link tiles |
| Section: call-to-action band | A gold band with a heading and a button |

Sections are groups with CSS classes (in **Advanced → Additional CSS class(es)**). Add `rla-band--tint`, `rla-band--dark` or `rla-band--gold` to a section's group to change its background. A paragraph with the class `rla-eyebrow` becomes the small capitals label above a heading.

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
| `templates/` | The page template (both layouts), header and footer |
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
