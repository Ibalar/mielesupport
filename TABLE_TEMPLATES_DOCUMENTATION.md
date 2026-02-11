# Table Templates for Level 3 Sections

## Overview

This document describes the new table-based templates created for level 3 service sections (pricing and error codes). These templates provide alternative layouts to the existing card-based and accordion designs.

## Files Created

### 1. Pricing Comparison Table

**Template Files:**
- `/wp-content/themes/miele-support/template-parts/service/pricing-table-comparison.php` - Standard version
- `/wp-content/themes/miele-support/template-parts/service/pricing-table-comparison-flexible.php` - Flexible content version
- `/wp-content/themes/miele-support/template-parts/service/flexible/pricing-comparison.php` - Proxy file

**CSS:**
- `/wp-content/themes/miele-support/assets/css/service-pricing-comparison.css`

**Features:**
- Displays pricing plans in a comparison table format
- Shows all features across plans in a matrix layout
- Highlights the most popular/featured plan
- Mobile-responsive with horizontal scroll
- Check marks (✓) and cross marks (✗) for feature availability

**Usage:**
```php
// Direct include (with ACF field 'pricing_plans')
get_template_part('template-parts/service/pricing-table-comparison');

// Flexible content version
set_query_var('section_data', $section);
get_template_part('template-parts/service/pricing-table-comparison-flexible');
```

**Data Structure:**
```php
$pricing_plans = [
    [
        'title' => 'Plan Name',
        'price' => '99',
        'description' => 'Plan description',
        'icon' => '🔍',
        'featured' => true, // Optional
        'features' => [
            'Feature 1',
            'Feature 2',
            // or with nested structure:
            ['feature' => 'Feature text']
        ]
    ]
];
```

### 2. Error Codes Table

**Template Files:**
- `/wp-content/themes/miele-support/template-parts/service/error-codes-table.php` - Standard version
- `/wp-content/themes/miele-support/template-parts/service/error-codes-table-flexible.php` - Flexible content version
- `/wp-content/themes/miele-support/template-parts/service/flexible/error-codes-table.php` - Proxy file

**CSS:**
- `/wp-content/themes/miele-support/assets/css/service-error-codes-table.css`

**Features:**
- Displays error codes in a structured table with three columns: Code, Issue, Description
- Includes a CTA section at the bottom for scheduling repairs
- Mobile-responsive with horizontal scroll
- Hover effects on table rows
- Fallback data if no ACF fields are set

**Usage:**
```php
// Direct include (with ACF field 'error_codes')
get_template_part('template-parts/service/error-codes-table');

// Flexible content version
set_query_var('section_data', $section);
get_template_part('template-parts/service/error-codes-table-flexible');
```

**Data Structure:**
```php
$error_codes = [
    [
        'code' => 'F11',
        'title' => 'Issue Title',
        'description' => 'Description and solution text'
    ]
];
```

## Differences from Original Templates

### Pricing Templates

| Original (`pricing-table.php`) | Table Version (`pricing-table-comparison.php`) |
|--------------------------------|-----------------------------------------------|
| Card-based layout with 3 columns | Table format with feature comparison matrix |
| Features listed vertically per plan | Features listed as rows, plans as columns |
| Best for 3-4 plans | Better for comparing multiple plans side-by-side |
| Mobile: Stacks cards | Mobile: Horizontal scroll |

### Error Codes Templates

| Original (`error-codes.php`) | Table Version (`error-codes-table.php`) |
|------------------------------|----------------------------------------|
| Accordion/details layout | Structured table with fixed columns |
| Expandable sections | All information visible at once |
| Better for longer descriptions | Better for quick reference and scanning |
| Mobile: Stacks accordions | Mobile: Horizontal scroll |

## Integration with ACF

Both templates integrate with the existing ACF flexible content structure defined in `group_service_sections.json`:

- **service_pricing_table** layout
- **service_error_codes** layout

The table versions use the same data structure, so they can be used interchangeably without modifying ACF fields.

## Enqueued Styles

The CSS files are automatically enqueued in `functions.php`:

```php
theme_style('service-pricing-comparison', 'service-pricing-comparison.css', ['base']);
theme_style('service-error-codes-table', 'service-error-codes-table.css', ['base']);
```

## Responsive Behavior

### Mobile (< 744px)
- Tables enable horizontal scrolling
- Text sizes are reduced for better fit
- CTA sections stack vertically
- Maintains table structure for data integrity

### Tablet (744px - 1023px)
- Moderate text sizes
- CTA sections may stack based on content

### Desktop (≥ 1024px)
- Full-width tables with optimal spacing
- All columns visible without scrolling
- Enhanced hover effects

## When to Use Each Version

### Use Card/Accordion Versions When:
- You have 3 or fewer pricing plans
- Descriptions are long and detailed
- Mobile-first experience is critical
- You want a more modern, card-based UI

### Use Table Versions When:
- You need to compare multiple plans side-by-side
- Quick reference and scanning is important
- You have many features to compare
- Desktop users are your primary audience
- You want a more traditional, structured layout

## Customization

### CSS Variables Used:
- `--black22` - Primary text color (#222)
- `--gray66` - Secondary text color (#666)
- `--red` - Brand color (#cc2229)
- `--red-hover` - Hover state (#9b1116)
- `--white` - Background (#ffffff)
- `--whitef6` - Light background (#f6f6f6)
- `--graye5` - Borders (#e5e5e5)
- `--font-family` - Theme font family

## Testing Checklist

- [ ] Test with 2, 3, 4, and 5 pricing plans
- [ ] Test with varying numbers of features (5-15)
- [ ] Test with long and short feature names
- [ ] Test error codes table with 3-10 codes
- [ ] Test on mobile devices (< 744px)
- [ ] Test on tablets (744px - 1023px)
- [ ] Test on desktop (≥ 1024px)
- [ ] Test with empty/missing data
- [ ] Test hover states and animations
- [ ] Verify accessibility (keyboard navigation, screen readers)

## Future Enhancements

Potential improvements for future versions:

1. **Sorting/Filtering**: Add ability to sort table rows
2. **Column Toggling**: Allow users to hide/show columns on mobile
3. **Sticky Headers**: Keep table headers visible while scrolling
4. **Export**: Add CSV/PDF export functionality
5. **Print Styles**: Optimize for printing
6. **Dark Mode**: Add dark theme support
7. **Animation**: Subtle animations on data load

## Support

For questions or issues with these templates, refer to:
- WordPress Codex for template hierarchy
- ACF documentation for field usage
- Theme functions.php for helper functions
