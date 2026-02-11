# Problems Section - Alternating Image/Text Layout

## Overview
This document describes the implementation of the alternating image/text layout for the "Problems" section (Level 3) in the Miele Support theme.

## Changes Made

### 1. ACF Field Configuration
**File:** `wp-content/themes/miele-support/acf-json/group_service_sections.json`

Added a new image field to the problems repeater:
- **Field Key:** `field_service_problem_image`
- **Field Name:** `image`
- **Field Type:** Image
- **Return Format:** Array
- **Description:** Optional image for each problem item (used in alternating layout)

The problems repeater now includes three fields per item:
1. `question` - The problem title/question
2. `answer` - The problem description
3. `image` - Optional image (NEW)

### 2. Template Updates
**File:** `wp-content/themes/miele-support/template-parts/service/problems-flexible.php`

Completely rewrote the template to support alternating image/text layout:

#### Key Features:
- **Alternating Layout:** Images alternate between left and right positions
  - Even index (0, 2, 4...): Image on LEFT, text on RIGHT
  - Odd index (1, 3, 5...): Image on RIGHT, text on LEFT
  
- **Responsive Design:**
  - Desktop: Side-by-side image and text layout
  - Tablet: Reduced gaps, maintained side-by-side
  - Mobile: Stacked layout (image above text)

- **Graceful Degradation:** If no image is provided, only text content is displayed

#### Template Structure:
```html
<section class="service-problems service-problems--alternating">
    <div class="service-problems__container">
        <div class="service-problems__header">
            <h2 class="service-problems__title">...</h2>
            <span class="service-problems__count">...</span>
        </div>
        <div class="service-problems__list">
            <!-- Each problem item -->
            <div class="service-problems__item service-problems__item--left">
                <div class="service-problems__image">...</div>
                <div class="service-problems__content">
                    <h3 class="service-problems__question">...</h3>
                    <div class="service-problems__answer">...</div>
                </div>
            </div>
        </div>
    </div>
</section>
```

### 3. CSS Styling
**File:** `wp-content/themes/miele-support/assets/css/service-problems.css`

Added comprehensive styles for the alternating layout (lines 146-316):

#### Desktop Layout (1024px+):
- Flexbox-based alternating layout
- 50/50 split between image and text
- 60px gap between image and content
- 80px gap between problem items
- Minimum height of 400px for uniformity
- Border radius of 12px for images

#### Tablet Layout (768px - 1023px):
- Maintained side-by-side layout
- Reduced gaps (40px between image/text, 60px between items)
- Adjusted font sizes

#### Mobile Layout (< 768px):
- Stacked layout (image above text)
- Full-width images
- Smaller font sizes and gaps
- Forced column direction regardless of alternating class

#### Key CSS Classes:
- `.service-problems--alternating` - Main container modifier
- `.service-problems__item--left` - Image on left variant
- `.service-problems__item--right` - Image on right variant (uses `flex-direction: row-reverse`)
- `.service-problems__image` - Image container
- `.service-problems__content` - Text content container
- `.service-problems__question` - Problem title
- `.service-problems__answer` - Problem description

## Usage

### In WordPress Admin:
1. Edit a Level 3 service page
2. Add a "Common Problems" section via flexible content
3. Add problem items with:
   - Problem title (required)
   - Description (optional)
   - Image (optional) - NEW FIELD
4. Images will automatically alternate left/right

### Without Images:
The section gracefully degrades to show text-only content when images are not provided.

## Backward Compatibility

The original grid-based layout template (`problems.php`) remains untouched for fallback scenarios. The new alternating layout only applies when using the flexible content system with `problems-flexible.php`.

## CSS Variables Used:
- `--white` - Background colors (#ffffff)
- `--black22` - Headings and dark text (#222)
- `--gray66` - Body text and descriptions (#666)
- `--graye5` - Borders (#e5e5e5)
- `--primary-red` - Brand accent color (#CC2229)
- `--font-family` - Theme font family

## Responsive Breakpoints:
- Mobile: `< 768px`
- Tablet: `768px - 1023px`
- Desktop: `>= 1024px`

## Implementation Details

### Alternating Logic:
```php
$is_even = ($index % 2 === 0);
$position_class = $is_even ? 'service-problems__item--left' : 'service-problems__item--right';
```

This ensures that:
- First item (index 0): Image LEFT
- Second item (index 1): Image RIGHT
- Third item (index 2): Image LEFT
- And so on...

## Testing Recommendations:

1. Test with images on all items
2. Test with no images (text-only)
3. Test with mixed content (some with images, some without)
4. Test responsive behavior at different screen sizes
5. Verify accessibility (alt text, keyboard navigation)
6. Check visual consistency across different image sizes

## Notes:

- The CSS is already enqueued via `functions.php` (line 194)
- Images use lazy loading for performance
- Text content supports HTML via `wp_kses_post()` and `wpautop()`
- All output is properly escaped for security
