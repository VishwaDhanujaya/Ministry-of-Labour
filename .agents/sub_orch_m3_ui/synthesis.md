# Synthesis: UI Polish & Tailwind (Milestone 3)

## Consensus
All Explorers agree on the following standardizations to resolve UI inconsistencies without component file proliferation:

### Toasts
- **Current State**: Frontend uses a hardcoded `<div id="toast">` in `footer.php` with manual class toggling, while the admin backend uses a dynamic `showToast()` in `admin.js`. Some frontend files use bare `alert()` calls.
- **Fix**: Remove the static `#toast` from `includes/footer.php`. Implement a dynamic `showToast(msg, type)` in `assets/js/main.js` that mirrors `admin.js` but uses standardized Tailwind classes (`bottom-6 right-6`, `rounded-xl`, `shadow-2xl`, etc.). Replace all `alert()` calls in `about-us.php` and `contact-us.php` with `showToast()`. Standardize admin toasts to match structural classes.

### Modals
- **Current State**: Modals suffer from inconsistent centering (absolute vs flexbox), varying z-indexes (`z-50`, `z-[100]`, `z-[110]`, `z-[120]`), and differing overlay opacities and blurs (`bg-black/50`, `bg-black/80`, `backdrop-blur-sm`).
- **Fix**: Standardize all modals to use flexbox centering and a unified wrapper/overlay class set.
  - Wrapper: `fixed inset-0 z-[100] hidden items-center justify-center p-4 transition-opacity duration-300 opacity-0`
  - Overlay: `absolute inset-0 bg-black/60 backdrop-blur-sm` (or inline with the wrapper).
  - Cards: `bg-white rounded-2xl shadow-2xl transform scale-95 opacity-0 transition-all duration-300`.
  - Apply these to `contact-us.php`, `about-us.php`, `ampara-circuit-bungalow.php`, `gallery.php`, and `admin.js` dynamically generated modals.

## Resolved Conflicts
No major conflicts. All explorers agreed on the fix strategy. Explorer 2 noted different card styles (`rounded-[24px]` vs `rounded-xl`) which will be standardized to `rounded-2xl`.

## Gaps
The `lightbox-modal` (`gallery.php`) requires a darker tint (`bg-[#070e17]/95`) for immersion, but its `z-index` should still be standardized to `z-[100]`, and its visibility toggling should be standardized to `hidden` instead of `pointer-events-none opacity-0` if possible, or at least unified.
