# Dropdown Menu Fix Documentation

## Problem
The dropdown menu (mega menu) for the "Services" navigation item was not closing when the mouse moved outside the menu boundaries. It only closed when clicking outside the menu area.

## Solution Implemented

### 1. JavaScript Changes (`assets/js/header.js`)

Added mouse event handlers to properly manage dropdown menu state:

- **mouseenter on `.main-nav__item--has-mega`**: Opens the mega menu
- **mouseleave on `.main-nav__item--has-mega`**: Sets a 100ms timeout to check if mouse moved to the mega menu
- **mouseenter on `.mega-menu`**: Cancels the close timeout (keeps menu open)
- **mouseleave on `.mega-menu`**: Immediately closes the menu

The 100ms timeout creates a "bridge" between the menu item and the dropdown, preventing the menu from closing during mouse movement transition.

### 2. CSS Changes (`assets/css/header.css`)

Added smooth fade transitions to the mega menu:

```css
.mega-menu {
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.2s ease, visibility 0.2s ease;
}

.mega-menu:not([hidden]) {
    opacity: 1;
    visibility: visible;
}
```

This provides a smooth visual transition when opening/closing the menu.

## Expected Behavior

1. **Opening**: Hover over "Services" → mega menu appears smoothly
2. **Staying open**: Move mouse from "Services" to the mega menu → menu stays open
3. **Closing**: Move mouse away from both "Services" and mega menu → menu closes after 100ms
4. **Alternative closing**: Click outside the menu area → menu closes immediately

## Technical Details

### Event Flow
1. User hovers over "Services" → `mouseenter` fires → `togglePanel(rootBtn, true)` called
2. User moves mouse to mega menu → `mouseleave` on rootItem sets timeout → `mouseenter` on megaMenu clears timeout
3. User moves mouse away from mega menu → `mouseleave` fires → `togglePanel(rootBtn, false)` called

### Timeout Purpose
The 100ms timeout prevents flickering when the user moves the mouse from the menu item to the dropdown. Without it, the menu would close briefly during the transition.

## Browser Compatibility
- Uses standard JavaScript (no ES6+ features requiring transpilation)
- CSS transitions supported in all modern browsers
- `:hover` pseudo-class supported universally

## Testing Recommendations

1. Test hover behavior on desktop
2. Verify touch behavior on tablets (should still work with click)
3. Test keyboard navigation (existing click handlers remain)
4. Verify no console errors in browser DevTools
5. Test with slow mouse movements and fast movements

## Files Modified

- `/wp-content/themes/miele-support/assets/js/header.js`
- `/wp-content/themes/miele-support/assets/css/header.css`
