# Service Advantages Section Update

## Overview
Updated the advantages ACF section for service pages with toggleable title/description and custom responsive grid styles.

## Changes Implemented

### 1. Created Service-Specific CSS File
**File:** `/wp-content/themes/miele-support/assets/css/service-advantages.css`

- Scoped class names to avoid conflicts with homepage advantages
- Responsive grid layout: 4 columns desktop, 2 tablet, 1 mobile
- Border handling for 4-column grid:
  - Desktop: Remove right border on 4th, 8th, 12th... items (`:nth-child(4n)`)
  - Desktop: Remove bottom border on last 4 items (`:nth-last-child(-n + 4)`)
  - Tablet: Reset to 2-column selectors (`:nth-child(2n)`, `:nth-last-child(-n + 2)`)
  - Mobile: Single column with `:last-child` for bottom border

### 2. Updated Flexible Content Advantages Template
**File:** `/wp-content/themes/miele-support/template-parts/service/advantages-flexible.php`

Changes:
- Changed all class names from `.advantages` to `.service-advantages`
- Added visibility toggle checks for title and subtitle:
  ```php
  $show_title = isset($section_data['show_title']) ? (bool) $section_data['show_title'] : true;
  $show_subtitle = isset($section_data['show_subtitle']) ? (bool) $section_data['show_subtitle'] : true;
  ```
- Conditional rendering based on toggle values (defaults to true for backward compatibility)

### 3. Updated Fallback Advantages Template
**File:** `/wp-content/themes/miele-support/template-parts/service/advantages.php`

Changes:
- Changed all class names from `.advantages` to `.service-advantages`
- Added comment explaining that fallback template always shows title/subtitle (no toggle fields)
- Maintains same visual styling with new grid layout

### 4. Registered New CSS File
**File:** `/wp-content/themes/miele-support/functions.php` (line 221)

Added:
```php
theme_style('service-advantages', 'service-advantages.css', ['base']);
```

## Manual ACF Field Addition Required

### Why Manual?
The ACF JSON file modification requires either:
1. Using the WordPress admin interface to edit the field group
2. Running a server-side script with proper permissions

### Steps to Add Toggle Fields via WordPress Admin

1. **Navigate to ACF Field Groups**
   - Go to WordPress Admin > Custom Fields > Field Groups

2. **Edit "Service — Sections (Flexible)" Field Group**
   - Find the field group titled "Service — Sections (Flexible)"
   - Click "Edit"

3. **Locate the "Advantages" Layout**
   - In the Flexible Content field, find the "Advantages" layout
   - Expand it to see its sub-fields

4. **Add "Show Title" Toggle Field**
   - After the "Subtitle" field, click "Add Field"
   - Configure the new field:
     - **Field Label:** Show Title
     - **Field Name:** show_title
     - **Field Type:** True / False
     - **Instructions:** Show or hide the section title.
     - **Default Value:** 1 (checked/true)
     - **Styling:** Toggle UI (enable)
     - **On Text:** Show
     - **Off Text:** Hide
     - **Wrapper Width:** 50%

5. **Add "Show Subtitle" Toggle Field**
   - Click "Add Field" again after the "Show Title" field
   - Configure the new field:
     - **Field Label:** Show Subtitle
     - **Field Name:** show_subtitle
     - **Field Type:** True / False
     - **Instructions:** Show or hide the section subtitle.
     - **Default Value:** 1 (checked/true)
     - **Styling:** Toggle UI (enable)
     - **On Text:** Show
     - **Off Text:** Hide
     - **Wrapper Width:** 50%

6. **Save Changes**
   - Click "Save Changes" or "Update" to save the field group

7. **Verify JSON Export**
   - The updated configuration should automatically sync to the JSON file
   - Check `/wp-content/themes/miele-support/acf-json/group_service_sections.json`

### Alternative: Manual JSON Edit (Advanced)

If you prefer to edit the JSON directly, add the following two field objects after the `field_service_advantages_subtitle` field in `/wp-content/themes/miele-support/acf-json/group_service_sections.json`:

```json
{
    "key": "field_service_advantages_show_title",
    "label": "Show Title",
    "name": "show_title",
    "aria-label": "",
    "type": "true_false",
    "instructions": "Show or hide the section title.",
    "required": false,
    "conditional_logic": false,
    "wrapper": {
        "width": "50",
        "class": "",
        "id": ""
    },
    "default_value": 1,
    "message": "",
    "ui": 1,
    "ui_on_text": "Show",
    "ui_off_text": "Hide"
},
{
    "key": "field_service_advantages_show_subtitle",
    "label": "Show Subtitle",
    "name": "show_subtitle",
    "aria-label": "",
    "type": "true_false",
    "instructions": "Show or hide the section subtitle.",
    "required": false,
    "conditional_logic": false,
    "wrapper": {
        "width": "50",
        "class": "",
        "id": ""
    },
    "default_value": 1,
    "message": "",
    "ui": 1,
    "ui_on_text": "Show",
    "ui_off_text": "Hide"
},
```

Insert these lines between line 373 and line 374 in the JSON file.

## Testing Checklist

After completing the ACF field addition, test the following:

### Responsive Breakpoints
- [ ] Desktop (>1024px): 4 columns
- [ ] Tablet (641px-1024px): 2 columns
- [ ] Mobile (≤640px): 1 column

### Title/Subtitle Visibility
- [ ] Both title and subtitle visible
- [ ] Title visible only
- [ ] Subtitle visible only
- [ ] Both hidden

### No Conflicts
- [ ] Homepage advantages still displays correctly (3 columns)
- [ ] Service advantages display correctly (4 columns)
- [ ] CSS classes don't interfere with each other

### Edge Cases
- [ ] Level 3 services with flexible content advantages
- [ ] Services using fallback advantages template
- [ ] Empty title/subtitle fields
- [ ] Background image from theme options displays correctly

## Files Modified

1. ✅ Created: `/wp-content/themes/miele-support/assets/css/service-advantages.css`
2. ✅ Modified: `/wp-content/themes/miele-support/template-parts/service/advantages-flexible.php`
3. ✅ Modified: `/wp-content/themes/miele-support/template-parts/service/advantages.php`
4. ✅ Modified: `/wp-content/themes/miele-support/functions.php`
5. ⚠️  Requires manual update: `/wp-content/themes/miele-support/acf-json/group_service_sections.json`

## Backward Compatibility

- Toggle fields default to `true` (show by default)
- Existing content will continue to display title/subtitle
- Old entries without toggle fields fall back to showing both
- Homepage advantages unchanged (still uses 3-column grid)

## Notes

- The CSS is loaded globally but scoped with `.service-advantages` classes
- No conflicts with existing `.advantages` classes
- Templates support both flexible content and fallback scenarios
- Background images from theme options continue to work
