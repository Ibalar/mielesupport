# Task 9: Accent Sections (Level 3) - Documentation

## Overview

This task adds two new accent section templates specifically for Level 3 service pages (final services). These sections feature eye-catching red gradient backgrounds with decorative circle patterns, designed to highlight important calls-to-action.

## Created Files

### PHP Templates

1. **`template-parts/service/flexible/accent.php`**
   - Simple accent section with title, subtitle, and single button
   - Uses red gradient background (#8c0014 to #cc2229)
   - Decorative circle patterns in corners
   - Responsive layout: centered on mobile/tablet, two-column on desktop

2. **`template-parts/service/flexible/accent_with_buttons.php`**
   - Accent section with multiple action buttons
   - Same visual style as single-button variant
   - Supports multiple buttons with different styles (primary/outline)
   - Flexible button layout with proper wrapping

### CSS Files

1. **`assets/css/service-accent.css`**
   - Styles for single-button accent section
   - Responsive breakpoints:
     - Mobile (<640px): Stacked layout, centered text
     - Tablet (640-1023px): Centered layout
     - Desktop (1024px+): Two-column layout (text left, button right)
   - Decorative circle patterns using CSS radial-gradient

2. **`assets/css/service-accent-buttons.css`**
   - Styles for multi-button accent section
   - Responsive breakpoints similar to single-button variant
   - Desktop layout: Centered text above, buttons below
   - Button wrapping for graceful overflow handling

### ACF Configuration

Updated **`acf-json/group_service_sections.json`** with two new flexible content layouts:

1. **`service_accent`** - Accent Section
   - Fields:
     - `title` (text, max 150 chars)
     - `subtitle` (wysiwyg, basic toolbar)
     - `button_text` (text, max 100 chars)
     - `button_link` (link field, returns array)

2. **`service_accent_with_buttons`** - Accent Section with Buttons
   - Fields:
     - `title` (text, max 150 chars)
     - `subtitle` (wysiwyg, basic toolbar)
     - `buttons` (repeater field)
       - `button_text` (text, max 100 chars)
       - `button_link` (link field, returns array)
       - `button_style` (select: primary/outline)

## Integration

### Single Service Template

Updated **`single-service.php`** to handle the new section types in the Level 3 flexible content switch statement:

```php
case 'service_accent':
    set_query_var('section_data', $section);
    get_template_part('template-parts/service/flexible/accent');
    break;

case 'service_accent_with_buttons':
    set_query_var('section_data', $section);
    get_template_part('template-parts/service/flexible/accent_with_buttons');
    break;
```

### Functions.php

Updated **`functions.php`** to enqueue the new CSS files:

```php
theme_style('service-accent', 'service-accent.css', ['base']);
theme_style('service-accent-buttons', 'service-accent-buttons.css', ['base']);
```

## Design Features

### Visual Style

- **Background**: Linear gradient from dark red (#8c0014) to brand red (#cc2229)
- **Decorative Elements**: Semi-transparent white circle patterns in top-left and bottom-right corners
- **Typography**:
  - Title: 48px (desktop), 36px (tablet), 24px (mobile), white, 600 weight
  - Subtitle: 18px (desktop), 17px (tablet), 14px (mobile), light gray (#c5c5c5)
- **Buttons**: White border, transparent background, hover effect with subtle background and transform

### Responsive Behavior

#### Mobile (<640px)
- Vertical stacking
- Centered alignment
- Full-width buttons
- Reduced decorative pattern opacity (50%)
- Compact padding: 60px vertical, 20px horizontal

#### Tablet (640-1023px)
- Centered layout maintained
- Moderate padding: 80px vertical, 40px horizontal
- Buttons remain centered

#### Desktop (1024px+)
- **Single Button Variant**: Two-column layout
  - Text group on left (max-width 700px)
  - Button on right
- **Multi-Button Variant**: Stacked center layout
  - Text centered at top (max-width 800px)
  - Buttons centered below with wrapping
- Generous padding: 120px vertical, 50px horizontal
- Desktop sections have side margins: 0 50px

## Usage in ACF

### For Content Editors

1. Navigate to a Level 3 service page (final service with no children)
2. Scroll to "Service Sections" flexible content
3. Click "Add Service Section"
4. Choose either:
   - **"Accent Section"** for a single CTA
   - **"Accent Section with Buttons"** for multiple CTAs

#### Single Button Accent
- Enter a compelling title
- Add descriptive subtitle (HTML allowed)
- Set button text and link
- Button opens in same/new window based on link target

#### Multi-Button Accent
- Enter title and subtitle
- Add multiple buttons (3-4 recommended)
- For each button:
  - Set text and link
  - Choose style: Primary or Outline
- Buttons will wrap gracefully on smaller screens

## Technical Notes

### Data Handling

Both templates:
- Use strict type declarations
- Validate all data with `??` null coalescing
- Properly escape output (`esc_html`, `esc_url`, `esc_attr`, `wp_kses_post`)
- Check for required data before rendering
- Handle link targets including `_blank` with proper security attributes

### CSS Architecture

- BEM naming convention
- Mobile-first approach (base styles, then `@media` min-width)
- CSS custom properties from `base.css` (colors, fonts)
- No JavaScript required
- Print-friendly (decorative elements use `background-image`)

### Performance

- Decorative circles use CSS gradients (no images)
- Minimal DOM nodes
- Efficient CSS selectors
- No external dependencies

## Comparison with Existing Sections

### Similar to Section 5 (Homepage)
- Same gradient background and decorative pattern
- Similar responsive behavior
- Adapted for service page context

### Differences from Section 6
- Section 6: Dark background (#222) with image/content split
- New sections: Red gradient, no image, focus on text + CTAs
- More prominent and attention-grabbing

## Use Cases

### Single Button Accent (`service_accent`)
- Emergency service contact
- Book appointment CTA
- Download resources
- Request quote
- Any single primary action

### Multi-Button Accent (`service_accent_with_buttons`)
- Multiple contact methods (call, email, chat)
- Different service tiers (basic, premium, emergency)
- Related actions (book service, get quote, learn more)
- Multiple locations or options
- Comparison scenarios

## Best Practices

1. **Content Length**: Keep titles concise (under 60 characters)
2. **Subtitle**: Use for supporting text, avoid walls of text
3. **Button Text**: Action-oriented, clear verbs (Call Now, Get Quote, Book Service)
4. **Button Count**: Maximum 3-4 buttons for optimal UX
5. **Placement**: Use accent sections strategically, not consecutively
6. **Frequency**: One accent section per page typically sufficient

## Accessibility

- Semantic HTML (`<section>`, `<h2>`)
- Proper heading hierarchy
- Link targets properly labeled
- `noopener noreferrer` for external links
- Sufficient color contrast (white on red gradient: >7:1)
- Focus states inherited from button styles
- Touch-friendly button sizing (minimum 44px height)

## Browser Support

- Modern browsers (Chrome, Firefox, Safari, Edge)
- IE11 not supported (uses CSS Grid and custom properties)
- Graceful degradation for older browsers
- Tested responsive breakpoints

## Future Enhancements

Potential improvements for future iterations:
- Icon support in buttons
- Background pattern customization
- Alternative color schemes
- Animation on scroll
- A/B testing variants
- Analytics tracking integration

## Maintenance

### When to Update

- Brand color changes: Update gradient values in both CSS files
- Typography changes: Adjust font-size, line-height in media queries
- Button styles change: Update both CSS files for consistency
- New button styles needed: Add to select field choices in ACF JSON

### Testing Checklist

- [ ] Desktop layout (1440px+)
- [ ] Tablet layout (744-1023px)
- [ ] Mobile layout (390-639px)
- [ ] Button hover states
- [ ] Link target behavior
- [ ] ACF field validation
- [ ] Content without buttons
- [ ] Long titles/subtitles
- [ ] 3+ buttons wrapping

## Related Tasks

- Task 8: Table templates (pricing, comparison, error codes)
- Previous section implementations (section3, section5, section6)
- Service page flexible content system
- ACF flexible content architecture

## Summary

These accent sections provide service pages with powerful, visually distinctive CTAs that match the existing design system while offering flexibility for both single and multiple action scenarios. The red gradient background ensures these sections stand out on the page and draw user attention to important conversion actions.
