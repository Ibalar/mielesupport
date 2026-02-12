# Service/Category/Subcategory Structure Documentation

## Overview

The Miele Support theme uses a **3-level hierarchical structure** for organizing services. This structure is implemented using WordPress Custom Post Types (CPT) with parent-child relationships.

## Hierarchy Levels

```
Level 1: Main Categories
    └── Level 2: Appliance Types (Subcategories)
            └── Level 3: Individual Services
```

### Example Structure

```
Kitchen Appliances (Level 1 - Category)
├── Refrigerators & Freezers (Level 2 - Subcategory)
│   ├── MasterCool (Level 3 - Service)
│   ├── Side-by-Side (Level 3 - Service)
│   └── Wine Storage (Level 3 - Service)
├── Dishwashers (Level 2 - Subcategory)
│   ├── Built-in (Level 3 - Service)
│   └── Freestanding (Level 3 - Service)
└── Ovens & Cooktops (Level 2 - Subcategory)
    └── Steam Ovens (Level 3 - Service)

Laundry (Level 1 - Category)
├── Washing Machines (Level 2 - Subcategory)
│   └── Front Load (Level 3 - Service)
└── Dryers (Level 2 - Subcategory)
    └── Heat Pump (Level 3 - Service)
```

## Technical Implementation

### Custom Post Type Registration

The service post type is registered in `functions.php`:

```php
function register_service_cpt() {
    register_post_type('service', [
        'label' => 'Services',
        'public' => true,
        'hierarchical' => true,  // Enables parent-child relationships
        'menu_icon' => 'dashicons-admin-tools',
        'supports' => ['title', 'editor', 'thumbnail', 'page-attributes'],
        'has_archive' => false,
        'rewrite' => ['slug' => 'services'],
        'show_in_rest' => true,
    ]);
}
```

**Key Setting**: `'hierarchical' => true` enables the parent-child relationship structure.

## How to Create Main Categories (Level 1)

### Step-by-Step Instructions

1. **Navigate to Services → Add New**
2. **Enter the Category Title** (e.g., "Kitchen Appliances", "Laundry")
3. **Leave "Parent Service" as "(no parent)"** - This makes it a Level 1 category
4. **Fill in Level 1 ACF Fields** (displayed in sidebar):
   - **Category Icon**: Upload icon for mega menu display
   - **Category Description**: Short description (max 200 chars)
   - **Category Banner**: Banner image for category page
   - **Menu Label**: Custom label for mega menu (e.g., "Kitchen", "Laundry")
5. **Set Menu Order**: Controls display order in menus and lists
6. **Publish**

### Level 1 ACF Fields (group_service_level1.json)

| Field | Type | Purpose |
|-------|------|---------|
| `category_icon` | Image | Icon displayed in mega menu |
| `category_description` | Textarea | Short description for the category |
| `category_banner` | Image | Banner image for category page |
| `menu_label` | Text | Custom label for mega menu columns |

## How to Create Subcategories (Level 2)

### Step-by-Step Instructions

1. **Navigate to Services → Add New**
2. **Enter the Subcategory Title** (e.g., "Miele Refrigerators & Freezers Repair")
3. **Set Parent Service**:
   - Select the Level 1 category (e.g., "Kitchen Appliances")
   - This creates the parent-child relationship
4. **Fill in Level 2 ACF Fields**:
   - **Short Description**: Brief description for mega menu and cards (max 150 chars)
   - **Hero Image**: Hero image for the appliance type page
   - **Brands**: List of applicable brands (name + logo)
   - **Show in Mega Menu**: Toggle visibility in mega menu
5. **Set Menu Order**: Controls display order within parent
6. **Publish**

### Level 2 ACF Fields (group_service_level2.json)

| Field | Type | Purpose |
|-------|------|---------|
| `short_description` | Textarea | Brief description for mega menu/cards |
| `hero_image_level2` | Image | Hero image for appliance type page |
| `brands` | Repeater | List of applicable brands |
| `show_in_mega_menu` | True/False | Display in mega menu toggle |

### Creating "Miele Refrigerators & Freezers Repair" Example

```
Title: Miele Refrigerators & Freezers Repair
Parent: Kitchen Appliances (Level 1)
Short Description: Expert repair services for all Miele refrigerator models
Hero Image: [Upload refrigerator hero image]
Brands:
  - Brand Name: Miele
    Brand Logo: [Upload Miele logo]
Show in Mega Menu: Yes
Menu Order: 1
```

## How to Create Individual Services (Level 3)

### Step-by-Step Instructions

1. **Navigate to Services → Add New**
2. **Enter the Service Title** (e.g., "MasterCool")
3. **Set Parent Service**:
   - Select the Level 2 subcategory (e.g., "Refrigerators & Freezers")
   - This links the service to its appliance type
4. **Add Featured Image**: Service thumbnail
5. **Build Service Page Content** using Flexible Content Sections:
   - Service Hero
   - Service Advantages
   - Service Models
   - Service Problems
   - Pricing Table
   - Error Codes
   - Reviews
   - Areas
   - Trust CTA
   - Accent Sections
   - Services Catalog
   - And more...
6. **Fill Final Page Fields** (group_service_final.json):
   - **Advantages**: 4 advantages with icons
   - **Models**: List of serviceable models
   - **FAQ**: Questions and answers
7. **Set Menu Order**: Controls display order within parent
8. **Publish**

### Level 3 ACF Fields (group_service_final.json)

| Field | Type | Purpose |
|-------|------|---------|
| `advantages` | Repeater (4 items) | Service advantages with icons |
| `models` | Repeater | List of serviceable models |
| `faq` | Repeater | FAQ questions and answers |

### Creating "MasterCool" Example

```
Title: MasterCool
Parent: Refrigerators & Freezers (Level 2)
Featured Image: [Upload MasterCool image]

Flexible Content Sections:
  1. Service Hero - Main banner
  2. Service Advantages - 4 key benefits
  3. Service Models - Supported MasterCool models
  4. Service Problems - Common issues we fix
  5. Pricing Table - Repair costs
  6. Reviews - Customer testimonials
  7. CTA Secondary - Contact section

Final Page Fields:
  Advantages:
    - Certified Technicians
    - Genuine Miele Parts
    - Same-Day Service
    - Warranty Included
  
  Models:
    - KF 1901 Vi
    - KF 2812 Vi
    - KFN 13923 DE
  
  FAQ:
    - Q: How long does repair take?
      A: Most repairs completed within 2-4 hours...
```

## Linking Services to Categories

### Automatic Linking via Hierarchy

Services are automatically linked through WordPress parent-child relationships:

```php
// Get Level 2 children of a Level 1 category
$appliance_types = get_posts([
    'post_type' => 'service',
    'post_parent' => $category_id,  // Level 1 ID
    'orderby' => 'menu_order',
    'order' => 'ASC',
    'posts_per_page' => -1,
]);

// Get Level 3 services of a Level 2 subcategory
$final_services = get_posts([
    'post_type' => 'service',
    'post_parent' => $appliance_type_id,  // Level 2 ID
    'orderby' => 'menu_order',
    'order' => 'ASC',
    'posts_per_page' => -1,
]);
```

### Helper Functions in functions.php

```php
/**
 * Get children services for a parent service
 */
function get_service_children($parent_id, $check_visibility = true) {
    $args = [
        'post_type' => 'service',
        'post_parent' => $parent_id,
        'orderby' => 'menu_order',
        'order' => 'ASC',
        'posts_per_page' => -1,
    ];

    $children = get_posts($args);

    if ($check_visibility) {
        $children = array_filter($children, function($child) {
            $show_in_menu = get_field('show_in_mega_menu', $child->ID);
            return $show_in_menu !== false;
        });
    }

    return $children;
}

/**
 * Get cached level 1 services for mega menu
 */
function get_cached_level1_services() {
    $cached = get_transient(MEGA_MENU_CACHE_KEY);

    if ($cached !== false) {
        return $cached;
    }

    $services = get_posts([
        'post_type' => 'service',
        'post_parent' => 0,  // Level 1 only
        'orderby' => 'menu_order',
        'order' => 'ASC',
        'posts_per_page' => -1,
    ]);

    set_transient(MEGA_MENU_CACHE_KEY, $services, MEGA_MENU_CACHE_TIME);

    return $services;
}
```

## Template Hierarchy

### Single Service Template (single-service.php)

The template automatically detects the hierarchy level and displays appropriate content:

```php
// Определяем уровень иерархии
$has_parent = $post->post_parent > 0;
$children = get_children([
    'post_type' => 'service',
    'post_parent' => get_the_ID(),
]);
$has_children = !empty($children);

if (!$has_parent && $has_children) {
    $level = 1;  // Category
} elseif ($has_parent && $has_children) {
    $level = 2;  // Appliance Type
} else {
    $level = 3;  // Final Service
}
```

### Level-Specific Templates

| Level | Template Behavior |
|-------|-------------------|
| **Level 1** | Shows flexible sections or subcategory grid |
| **Level 2** | Shows children grid + flexible sections |
| **Level 3** | Shows full flexible content sections |

### Archive Template (archive-service.php)

Displays all services in a 3-level nested accordion:

```
Level 1: Categories (accordion headers)
    └── Level 2: Appliance Types (accordion sub-items, clickable)
            └── Level 3: Services (links)
```

## Breadcrumbs Navigation

Breadcrumbs automatically follow the hierarchy:

| Level | Breadcrumb Path |
|-------|-----------------|
| Level 1 | Home > Services > Category |
| Level 2 | Home > Services > Category > Appliance Type |
| Level 3 | Home > Services > Category > Appliance Type > Service |

Example: `MasterCool`
```
Home > Services > Kitchen Appliances > Refrigerators & Freezers > MasterCool
```

## ACF Field Groups Summary

### Field Group Files

| File | Purpose | Applies To |
|------|---------|------------|
| `group_service_level1.json` | Category fields (icon, description, banner, menu label) | Level 1 (no parent) |
| `group_service_level2.json` | Appliance type fields (short desc, hero, brands, menu visibility) | Level 2 (has parent, has children) |
| `group_service_final.json` | Service page fields (advantages, models, FAQ) | Level 3 (leaf nodes) |
| `group_service_sections.json` | Flexible content sections | All levels |

### Flexible Content Sections Available

```
service_hero              - Hero banner section
service_advantages        - 4-column advantages grid
service_models            - Model showcase
service_problems          - Common problems with solutions
service_pricing_table     - Pricing comparison
service_cta_secondary     - Call-to-action section
service_error_codes       - Error code reference table
service_reviews           - Customer testimonials
service_areas             - Service area coverage
service_trust_cta         - Trust indicators + CTA
service_accent            - Accent/styled content block
service_accent_with_buttons - Accent with action buttons
services_catalog          - Services catalog grid
catalog-description       - Catalog description text
service_section3          - Generic content section
```

## Services Catalog Block (ACF Block)

The `services-catalog` ACF block provides an alternative way to display services without using the hierarchy:

### Block Structure

```
Section Title: "Our Services"
Service Categories (repeater):
  ├── Category 1: "Appliance Repair"
  │   └── Category Items (repeater):
  │       ├── Item 1: Refrigerator Repair (image, title, link)
  │       ├── Item 2: Washing Machine Repair (image, title, link)
  │       └── Item 3: Dryer Repair (image, title, link)
  └── Category 2: "Home Services"
      └── Category Items:
          ├── Item 1: HVAC Service
          └── Item 2: Plumbing Service
```

### When to Use

- **Use Hierarchy** when services have clear parent-child relationships
- **Use Services Catalog Block** for curated, custom layouts without strict hierarchy

## Best Practices

### Naming Conventions

1. **Level 1 (Categories)**: Use broad appliance categories
   - "Kitchen Appliances", "Laundry", "Coffee Machines"

2. **Level 2 (Subcategories)**: Include brand + appliance type
   - "Miele Refrigerators & Freezers Repair"
   - "Miele Washing Machines Repair"

3. **Level 3 (Services)**: Use specific model names or service types
   - "MasterCool", "Front Load Washing Machine", "Built-in Dishwasher"

### Menu Ordering

- Use Menu Order field to control display sequence
- Level 1: 1, 2, 3, etc.
- Level 2: 1, 2, 3 within each parent
- Level 3: 1, 2, 3 within each parent

### URL Structure

```
/services/                    - Services archive (all services)
/services/kitchen-appliances/ - Level 1 category
/services/refrigerators/      - Level 2 subcategory
/services/mastercool/         - Level 3 service
```

### Cache Management

The mega menu uses caching for performance. Cache is automatically cleared when:
- Any service post is saved
- Any service post is deleted

```php
// Clear cache manually
delete_transient('miele_mega_menu_cache');
```

## Common Tasks

### Add a New Appliance Category

1. Create Level 1 service (no parent)
2. Upload category icon and banner
3. Set menu order
4. Add Level 2 subcategories as children

### Add a New Appliance Type

1. Create Level 2 service
2. Select Level 1 category as parent
3. Add short description and hero image
4. Add applicable brands
5. Set "Show in Mega Menu" if needed
6. Add Level 3 services as children

### Add a New Service

1. Create Level 3 service
2. Select Level 2 appliance type as parent
3. Add featured image
4. Build flexible content sections
5. Fill advantages, models, FAQ
6. Set menu order

### Update Service Hierarchy

1. Edit the service
2. Change "Parent Service" dropdown
3. Update will reflect immediately in:
   - Breadcrumbs
   - Archive accordion
   - Mega menu

## Troubleshooting

### Services Not Showing in Menu

- Check "Show in Mega Menu" field (Level 2)
- Verify menu order is set
- Clear mega menu cache

### Wrong Hierarchy Level Detected

- Check parent-child relationships in admin
- Ensure no circular references
- Verify children exist using "Page Attributes"

### URLs Not Working

1. Go to Settings → Permalinks
2. Click "Save Changes" to flush rewrite rules
3. Or programmatically: `flush_rewrite_rules()`

### Cache Issues

```php
// Clear mega menu cache
delete_transient('miele_mega_menu_cache');

// Clear all transients
$wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_%'");
```

## File Reference

### Core Files

```
wp-content/themes/miele-support/
├── functions.php                    # CPT registration, helper functions
├── single-service.php               # Single service template (all levels)
├── archive-service.php              # Services archive (accordion)
├── page-services.php                # Services page template
├── inc/
│   └── breadcrumbs.php              # Breadcrumb navigation
├── acf-json/
│   ├── group_service_level1.json    # Level 1 fields
│   ├── group_service_level2.json    # Level 2 fields
│   ├── group_service_final.json     # Level 3 fields
│   └── group_service_sections.json  # Flexible content fields
└── template-parts/
    ├── blocks/
    │   └── services-catalog.php     # Services catalog block
    └── service/
        ├── category-grid.php        # Level 1 default view
        ├── children-grid.php        # Level 2 children display
        └── flexible/                # Flexible section templates
```
