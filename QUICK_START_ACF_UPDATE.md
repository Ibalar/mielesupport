# Quick Start: Complete the Service Advantages Update

## ✅ Automated Changes (Completed)

The following changes have been successfully implemented:

1. **Created service-specific CSS** (`/assets/css/service-advantages.css`)
   - 4-column grid for desktop
   - 2-column grid for tablet
   - 1-column grid for mobile
   - Scoped classes to avoid conflicts

2. **Updated flexible content template** (`/template-parts/service/advantages-flexible.php`)
   - New class names: `.service-advantages`
   - Toggle support for title/subtitle visibility
   - Backward compatible (defaults to show)

3. **Updated fallback template** (`/template-parts/service/advantages.php`)
   - New class names: `.service-advantages`
   - Maintains consistent styling

4. **Registered new CSS** (`/functions.php` line 221)
   - CSS file now loads on all pages

## ⚠️ Manual Step Required: Add ACF Toggle Fields

### Option 1: WordPress Admin Interface (Recommended)

1. **Login to WordPress Admin**
2. **Navigate to:** Custom Fields > Field Groups
3. **Edit:** "Service — Sections (Flexible)" field group
4. **Find:** The "Advantages" layout within the Flexible Content field
5. **Expand** the Advantages layout
6. **Add two new fields** after the "Subtitle" field:

#### Field 1: Show Title
- **Label:** Show Title
- **Name:** show_title
- **Type:** True / False
- **Instructions:** Show or hide the section title.
- **Default:** ✅ Checked (1)
- **UI:** Toggle (enable)
- **On Text:** Show
- **Off Text:** Hide
- **Width:** 50%

#### Field 2: Show Subtitle
- **Label:** Show Subtitle
- **Name:** show_subtitle
- **Type:** True / False
- **Instructions:** Show or hide the section subtitle.
- **Default:** ✅ Checked (1)
- **UI:** Toggle (enable)
- **On Text:** Show
- **Off Text:** Hide
- **Width:** 50%

7. **Click:** Save Changes or Update
8. The fields will automatically sync to the JSON file

### Option 2: Edit JSON File Directly

Edit `/wp-content/themes/miele-support/acf-json/group_service_sections.json` and insert these two field objects after the `field_service_advantages_subtitle` field (after line 373):

```json
,
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
}
```

## 🧪 Testing

After adding the ACF fields, test:

1. **Responsive Grid:**
   - Resize browser to verify 4/2/1 column breakpoints

2. **Toggle Functionality:**
   - Create/edit a service page
   - Add Advantages section
   - Test all toggle combinations:
     - ✅ Both ON (default)
     - ✅ Title ON, Subtitle OFF
     - ✅ Title OFF, Subtitle ON
     - ✅ Both OFF

3. **No Conflicts:**
   - Check homepage advantages still show 3 columns
   - Check service advantages show 4 columns

## 📚 Documentation

Full documentation available in: `SERVICE_ADVANTANGES_UPDATE.md`

## 🎯 Summary

- ✅ CSS: Complete
- ✅ Templates: Complete
- ✅ Registration: Complete
- ⚠️ ACF Fields: Requires manual addition (2 fields, 2 minutes)

The implementation is 95% complete. The final 5% (adding 2 ACF fields) takes about 2 minutes via WordPress admin.
