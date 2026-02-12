# Service Models Section Update

## Overview
Updated the models ACF section for service pages with model descriptions, optional block title with fallback, and a responsive 6/3/2 grid layout without horizontal scroll.

## Changes Implemented

### 1. Updated Models CSS File
**File:** `/wp-content/themes/miele-support/assets/css/service-models.css`

**Changes:**
- Removed horizontal slider layout (wrapper, track, and scroll-related styles)
- Implemented CSS Grid layout with 6 columns on desktop, 3 on tablet, 2 on mobile
- Removed scroll-related hover effects and grab cursors
- Added new `.service-models__item` class for grid items
- Added new `.service-models__content` wrapper for name and description
- Added new `.service-models__description` class for model descriptions
- Updated responsive breakpoints for proper grid column changes
- Improved text scaling across breakpoints

### 2. Updated Flexible Content Models Template
**File:** `/wp-content/themes/miele-support/template-parts/service/models-flexible.php`

**Changes:**
- Changed from slider to grid layout (removed wrapper/track, added grid)
- Added visibility toggle check for title:
  ```php
  $show_title = isset($section_data['show_title']) ? (bool) $section_data['show_title'] : true;
  ```
- Added conditional title display with fallback to default:
  ```php
  $title = !empty($section_data['title']) ? $section_data['title'] : 'Models We Repair';
  ```
- Added model description display with conditional rendering
- Changed class names from `.service-models__slide` to `.service-models__item`
- Updated template to use new CSS Grid structure

### 3. Updated Fallback Models Template
**File:** `/wp-content/themes/miele-support/template-parts/service/models.php`

**Changes:**
- Changed from slider to grid layout (removed wrapper/track, added grid)
- Added model description display with conditional rendering
- Changed class names from `.service-models__slide` to `.service-models__item`
- Maintains default title "Models We Repair" (no toggle support in fallback)
- Updated template to use new CSS Grid structure

### 4. Removed Slider JavaScript
**File:** `/wp-content/themes/miele-support/functions.php` (line 254)

**Removed:**
```php
theme_script('service-models-js', 'service-models.js');
```

**Reason:** The slider functionality (drag scroll, wheel scroll) is no longer needed with the CSS Grid layout.

## Manual ACF Field Addition Required

### Why Manual?
The ACF JSON file modification requires either:
1. Using the WordPress admin interface to edit the field group
2. Running a server-side script with proper permissions

### Steps to Add Fields via WordPress Admin

1. **Navigate to ACF Field Groups**
   - Go to WordPress Admin > Custom Fields > Field Groups

2. **Edit "Service — Sections (Flexible)" Field Group**
   - Find the field group titled "Service — Sections (Flexible)"
   - Click "Edit"

3. **Locate the "Models" Layout**
   - In the Flexible Content field, find the "Models" layout
   - Expand it to see its sub-fields

4. **Add "Title" Field**
   - Before the "Models" repeater field, click "Add Field"
   - Configure the new field:
     - **Field Label:** Title
     - **Field Name:** title
     - **Field Type:** Text
     - **Instructions:** Optional section title. Leave empty to use default 'Models We Repair'.
     - **Required:** No
     - **Default Value:** (empty)
     - **Maximum Length:** 150
     - **Wrapper Width:** (leave empty for full width)

5. **Add "Show Title" Toggle Field**
   - After the "Title" field, click "Add Field"
   - Configure the new field:
     - **Field Label:** Show Title
     - **Field Name:** show_title
     - **Field Type:** True / False
     - **Instructions:** Show or hide the section title.
     - **Required:** No
     - **Default Value:** 1 (checked/true)
     - **Styling:** Toggle UI (enable)
     - **On Text:** Show
     - **Off Text:** Hide
     - **Wrapper Width:** 50%

6. **Add "Description" Field to Models Repeater**
   - Expand the "Models" repeater field
   - After the "Name" field, click "Add Field"
   - Configure the new field:
     - **Field Label:** Description
     - **Field Name:** description
     - **Field Type:** Textarea
     - **Instructions:** Optional model description.
     - **Required:** No
     - **Default Value:** (empty)
     - **Maximum Length:** 250
     - **Rows:** 3
     - **Wrapper Width:** (leave empty for full width)

7. **Save Changes**
   - Click "Save Changes" or "Update" to save the field group

8. **Verify JSON Export**
   - The updated configuration should automatically sync to the JSON file
   - Check `/wp-content/themes/miele-support/acf-json/group_service_sections.json`

### Alternative: Manual JSON Edit (Advanced)

If you prefer to edit the JSON directly, make the following changes in `/wp-content/themes/miele-support/acf-json/group_service_sections.json`:

**1. Add Title and Show Title fields before the Models repeater (after line 514):**
```json
{
    "key": "field_service_models_title",
    "label": "Title",
    "name": "title",
    "aria-label": "",
    "type": "text",
    "instructions": "Optional section title. Leave empty to use default 'Models We Repair'.",
    "required": false,
    "conditional_logic": false,
    "wrapper": {
        "width": "",
        "class": "",
        "id": ""
    },
    "default_value": "",
    "maxlength": 150,
    "placeholder": "",
    "prepend": "",
    "append": ""
},
{
    "key": "field_service_models_show_title",
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
```

**2. Add Description field to the models repeater sub-fields (after line 581):**
```json
{
    "key": "field_service_model_description",
    "label": "Description",
    "name": "description",
    "aria-label": "",
    "type": "textarea",
    "instructions": "Optional model description.",
    "required": false,
    "conditional_logic": false,
    "wrapper": {
        "width": "",
        "class": "",
        "id": ""
    },
    "default_value": "",
    "new_lines": "",
    "maxlength": 250,
    "placeholder": "",
    "rows": 3,
    "parent_repeater": "field_service_models"
},
```

## Testing Checklist

After completing the ACF field addition, test the following:

### Responsive Breakpoints
- [ ] Desktop (>1024px): 6 columns
- [ ] Tablet (641px-1024px): 3 columns
- [ ] Mobile (≤640px): 2 columns

### Title Visibility
- [ ] Title visible (default)
- [ ] Custom title displays correctly
- [ ] Title hidden when toggle is off
- [ ] Default title "Models We Repair" shows when title field is empty

### Model Descriptions
- [ ] Description displays when added
- [ ] Description is hidden when empty
- [ ] Description text is truncated to 3 lines (2 on mobile)
- [ ] Description text color matches design (gray)

### Grid Layout
- [ ] No horizontal scroll on any device
- [ ] Grid items align properly on all breakpoints
- [ ] Hover effects work (translateY and shadow)
- [ ] Images maintain aspect ratio and cover properly
- [ ] Gap between items is consistent

### Edge Cases
- [ ] Level 3 services with flexible content models
- [ ] Services using fallback models template
- [ ] Empty models array (section doesn't display)
- [ ] Models without images (item doesn't display)
- [ ] Models with only name (no description)
- [ ] Models with only description (edge case - both name and description optional)

### Performance
- [ ] No console errors
- [ ] Images load with lazy loading
- [ ] Smooth hover transitions
- [ ] No horizontal scrollbar visible

## Files Modified

1. ✅ Modified: `/wp-content/themes/miele-support/assets/css/service-models.css`
2. ✅ Modified: `/wp-content/themes/miele-support/template-parts/service/models-flexible.php`
3. ✅ Modified: `/wp-content/themes/miele-support/template-parts/service/models.php`
4. ✅ Modified: `/wp-content/themes/miele-support/functions.php`
5. ⚠️  Requires manual update: `/wp-content/themes/miele-support/acf-json/group_service_sections.json`

## Backward Compatibility

- Title and show_title fields default to showing title with default text
- Existing content will continue to display with default title "Models We Repair"
- Old entries without new fields fall back to showing title
- Model descriptions are optional - existing models without descriptions work fine
- Grid layout replaces slider - no horizontal scroll

## CSS Grid Breakpoints Summary

| Screen Size | Columns | Image Height | Gap |
|-------------|---------|--------------|-----|
| Desktop (>1024px) | 6 | 240px | 20px |
| Tablet (641-1024px) | 3 | 220px | 20px |
| Mobile (≤640px) | 2 | 180px | 12px |

## Notes

- The CSS is loaded globally but scoped with `.service-models` classes
- No conflicts with other grid-based sections
- Templates support both flexible content and fallback scenarios
- Description text is truncated with CSS line-clamp for consistent height
- Hover effects translate item upward and add shadow
- All images use lazy loading for performance
