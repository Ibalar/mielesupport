# Archive Service Template Implementation

## Overview
Created `archive-service.php` template for the main services catalog at `/services/` URL (Variant 1).

## Files Created

### 1. `/wp-content/themes/miele-support/archive-service.php`
- **Purpose**: Dedicated archive template for the service custom post type
- **URL**: Accessible at `/services/` (WordPress archive URL for service post type)
- **Template Priority**: Higher than generic `archive.php` in WordPress template hierarchy

#### Features:
- **Hierarchical Display**: Shows services in 3-level nested accordion structure
  - Level 1: Categories (no parent)
  - Level 2: Appliance types (children of categories)
  - Level 3: Final services (children of appliance types)
- **Accordion Interaction**: Uses existing JavaScript from `page-services.js`
- **Breadcrumbs**: Integrated breadcrumb navigation
- **CTA Section**: Call-to-action at bottom for custom solutions
- **Internationalization**: All strings wrapped with `_e()` for translation support
- **Security**: Uses `esc_html()`, `esc_url()` for output sanitization

## Files Modified

### 1. `/wp-content/themes/miele-support/assets/css/page-services.css`
Added CSS support for new elements:

```css
.services-accordion__sub-title-link
.services-accordion__sub-title-link:hover
.services-accordion__no-services
```

#### Changes:
- **Sub-title Link Styling**: Made level 2 (appliance type) titles clickable with hover effects
- **No Services Message**: Styling for fallback when no level 3 services exist
- **Hover States**: Color transitions on interaction

## Architecture Decisions

### Why archive-service.php?
According to WordPress template hierarchy, `archive-{post_type}.php` has higher priority than `archive.php` for displaying post type archives. This allows:
1. Dedicated template for service archives
2. Better separation of concerns
3. Customized layout without affecting other post types

### Differences from page-services.php
| Feature | page-services.php | archive-service.php |
|---------|------------------|---------------------|
| URL | `/custom-page-slug/` | `/services/` |
| Type | Page Template | Archive Template |
| Sorting | `orderby: 'title'` | `orderby: 'menu_order'` |
| Level 2 | Not clickable | Clickable links |
| Purpose | Custom page display | Native archive URL |

### Key Improvements
1. **Clickable Level 2 Titles**: In archive-service.php, appliance type titles are now links
2. **Menu Order Sorting**: Uses `menu_order` for better control over display order
3. **Fallback Handling**: Shows "View service details" link when no level 3 services exist
4. **Archive-specific Class**: `.services-page--archive` modifier for potential custom styling

## Integration

### Existing Assets Used
- **CSS**: `page-services.css` (already loaded in theme)
- **JavaScript**: `page-services.js` (already loaded in theme)
- **Layout**: Same accordion structure as page-services.php
- **Styling**: Reuses all existing `.services-accordion__*` classes

### Functions Used
- `get_header()` / `get_footer()`: Theme structure
- `render_breadcrumbs()`: Breadcrumb navigation
- `get_posts()`: Retrieve hierarchical services
- `get_permalink()`: Generate service URLs
- `home_url()`: Generate contact page URL
- `_e()`: Translation support
- `esc_html()` / `esc_url()`: Security

## Template Hierarchy

WordPress will now use this template hierarchy for service archives:

```
1. archive-service.php ← NEW (highest priority)
2. archive.php
3. index.php
```

## Testing Checklist

- [ ] Visit `/services/` URL to see archive template
- [ ] Verify accordion functionality works (expand/collapse)
- [ ] Check breadcrumbs display correctly
- [ ] Test level 2 title links navigate correctly
- [ ] Verify level 3 service links work
- [ ] Check CTA button links to contacts page
- [ ] Test empty state (if no services exist)
- [ ] Verify responsive design on mobile/tablet
- [ ] Check hover states on all interactive elements
- [ ] Validate translations work (if using translation plugin)

## Browser Compatibility
- Uses CSS variables (all modern browsers)
- Flexbox layout (IE11+)
- CSS transitions (all modern browsers)
- Vanilla JavaScript (no framework dependencies)

## Accessibility
- `aria-expanded` attribute on accordion headers
- Semantic HTML structure (nav, main, h1-h3)
- Keyboard navigation support via native buttons
- Focus states preserved

## SEO Considerations
- Proper heading hierarchy (h1 → h2 → h3)
- Semantic HTML structure
- Descriptive meta content
- Breadcrumb navigation for context

## Future Enhancements
1. Add filter/search functionality
2. Add pagination for large service counts
3. Add service count indicators
4. Add category descriptions
5. Add icons for service categories
6. Implement lazy loading for images
7. Add schema.org markup for services
8. Add sorting options (alphabetical, by date, etc.)

## Maintenance Notes
- CSS changes should be made in `page-services.css` (shared with page template)
- JavaScript changes should be made in `page-services.js` (shared with page template)
- To disable archive template, simply rename or delete `archive-service.php`
- Template will fall back to `archive.php` if `archive-service.php` is removed
