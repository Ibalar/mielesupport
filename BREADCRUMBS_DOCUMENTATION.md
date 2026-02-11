# Breadcrumbs Implementation Documentation

## Overview
This implementation provides comprehensive breadcrumb navigation supporting all hierarchy levels for the Miele Support theme.

## Supported Page Types

### 1. Service Hierarchy (3 levels)
- **Level 1 (Category)**: Home > Services > Category
- **Level 2 (Appliance Type)**: Home > Services > Category > Appliance Type  
- **Level 3 (Service)**: Home > Services > Category > Appliance Type > Service

### 2. Regular Pages
- **Simple Page**: Home > Page
- **Page with Parent**: Home > Parent Page > Child Page
- **Deep Hierarchy**: Home > Grandparent > Parent > Page

### 3. Blog/Posts
- **Blog Post**: Home > Blog > Category > Post
- **Category Archive**: Home > Blog > Category

### 4. Other Pages
- **Search Results**: Home > Search Results
- **404 Page**: Home > Page Not Found
- **Services Archive**: Home > Services

## File Structure

```
wp-content/themes/miele-support/
├── inc/
│   └── breadcrumbs.php              # Helper functions
├── template-parts/
│   ├── global/
│   │   └── breadcrumbs.php          # Main breadcrumbs template
│   └── service/
│       └── flexible/
│           └── breadcrumbs.php      # Flexible content version
├── assets/
│   └── css/
│       └── breadcrumbs.css          # Breadcrumbs styles
├── functions.php                    # Includes breadcrumbs.php
├── page.php                         # Generic page with breadcrumbs
├── page-services.php               # Services page with breadcrumbs
├── page-contacts.php               # Contacts page with breadcrumbs
├── single.php                      # Blog post with breadcrumbs
├── single-service.php              # Service with breadcrumbs
├── archive.php                     # Archives with breadcrumbs
├── search.php                      # Search results with breadcrumbs
└── 404.php                         # 404 page with breadcrumbs
```

## Helper Functions

### `get_breadcrumb_items(): array`
Returns an array of breadcrumb items for the current page.

### `get_service_breadcrumbs(): array`
Returns breadcrumbs for service posts with full hierarchy.

### `get_page_breadcrumbs(): array`
Returns breadcrumbs for regular pages with parent hierarchy.

### `get_post_breadcrumbs(): array`
Returns breadcrumbs for blog posts.

### `get_taxonomy_breadcrumbs(): array`
Returns breadcrumbs for category/tag archives.

### `render_breadcrumbs(?array $breadcrumbs = null): void`
Renders the breadcrumbs HTML. Optionally accepts pre-built breadcrumbs array.

### `should_show_breadcrumbs(): bool`
Checks if breadcrumbs should be shown on current page.

## Usage

### Basic Usage
```php
<?php render_breadcrumbs(); ?>
```

### With Custom Container
```php
<div class="custom-container">
    <?php render_breadcrumbs(); ?>
</div>
```

### Conditional Display
```php
<?php if (should_show_breadcrumbs()) : ?>
    <div class="breadcrumbs-wrapper">
        <?php render_breadcrumbs(); ?>
    </div>
<?php endif; ?>
```

## CSS Classes

- `.breadcrumbs` - Main container
- `.breadcrumbs__list` - Ordered list
- `.breadcrumbs__item` - Individual breadcrumb item
- `.breadcrumbs__item--current` - Current page item
- `.breadcrumbs__link` - Link to parent pages
- `.breadcrumbs__current` - Current page text (no link)
- `.breadcrumbs__separator` - Separator between items
- `.breadcrumbs__separator-icon` - SVG separator icon

## Schema.org Markup

Breadcrumbs include structured data markup for SEO:
- `itemscope itemtype="https://schema.org/BreadcrumbList"` - Container
- `itemprop="itemListElement"` - Each item
- `itemscope itemtype="https://schema.org/ListItem"` - List item type
- `itemprop="item"` - Link element
- `itemprop="name"` - Item name
- `itemprop="position"` - Item position

## Responsive Behavior

### Mobile (< 744px)
- Smaller font size (13px)
- Truncated text with ellipsis
- Maximum width: 200px per item
- Reduced padding

### Tablet (744px - 1439px)
- Standard font size (14px)
- Maximum width: 250px per item
- Medium padding

### Desktop (≥ 1440px)
- Standard font size (14px)
- Maximum width: 300px per item
- Larger padding

## Accessibility

- Semantic HTML with `<nav>` and `<ol>` elements
- `aria-label` on navigation
- `aria-current="page"` on current item
- Proper focus styles
- Hidden separators from screen readers (`aria-hidden`)

## Styling Variables

Uses CSS custom properties from `base.css`:
- `--gap-xs` (8px) - Small gaps
- `--gap-sm` (16px) - Mobile padding
- `--gap-md` (24px) - Tablet padding
- `--gap-lg` (32px) - Desktop padding
- `--grayc5` - Link color
- `--white` - Current page color
- `--red` - Focus outline color

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- IE11 not supported

## Print Styles

Breadcrumbs are hidden when printing (`@media print`).
