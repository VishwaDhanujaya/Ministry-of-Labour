# Observation
I investigated the codebase to find UI inconsistencies in toasters, notifications, and modals, and areas where Tailwind CSS classes can be optimized.

**Toasters:**
- Frontend (`includes/footer.php`, line 84): The global `#toast` has classes: `bg-gradient-to-r from-primary to-[#1a3656] text-white py-3.5 px-6 rounded-xl shadow-2xl border border-white/10 translate-y-4`. Positioned at `bottom-6 left-6`.
- Backend (`admin/assets/js/admin.js`, line 33): The `showToast` function creates toasts dynamically with classes: `px-6 py-3 rounded shadow-lg text-white text-[13px] font-bold translate-y-10`. Positioned at `bottom-5 right-5` via its container.
- Notification fallbacks (`contact-us.php` line 431, `about-us.php` line 811, `admin/new-article.php` line 458): There are multiple `alert()` calls for errors/info instead of using toasts.

**Modals:**
- Overlays vary widely:
  - `bg-transparent` turning into `bg-black/40 backdrop-blur-md` (`ampara-circuit-bungalow.php` line 783).
  - `bg-black/50 backdrop-blur-sm` (`contact-us.php` line 320).
  - `bg-black bg-opacity-50` (`admin/bungalow-bookings.php` line 521).
  - `bg-black/80` (`about-us.php` line 359).
- Z-Indexes vary from `z-50` to `z-[100]` and `z-[110]`.
- Cards vary widely:
  - `rounded-[24px] shadow-2xl ... border border-gray-100` (`ampara-circuit-bungalow.php`).
  - `rounded-xl shadow-xl` (`admin/assets/js/admin.js` & `admin/bungalow-bookings.php`).
  - `rounded-2xl shadow-2xl` (`contact-us.php`).

# Logic Chain
1. **Consistency**: UI elements of the same type should look and behave the same across both the frontend and admin panels. The disparate classes for shadows, border radiuses, opacities, and z-indexes need unification.
2. **Constraint - No Component Proliferation**: We must not create new `.php` or `.js` component files. Thus, the fix must rely on refactoring the inline Tailwind CSS classes in existing files.
3. **Toaster Unification**: Define a standard set of utility classes for all toasts (e.g., `rounded-xl shadow-2xl text-sm font-semibold flex items-center gap-3`) and a unified positioning (`bottom-6 right-6`). Eliminate `alert()` calls by migrating them to either a global `showToast` function (to be added in `assets/js/main.js` for the frontend) or reusing the `#toast` element properly for errors.
4. **Modal Unification**: Define standard utility classes for overlays (`fixed inset-0 z-[100] bg-black/50 backdrop-blur-sm hidden flex items-center justify-center p-4 transition-opacity duration-300`) and cards (`bg-white rounded-2xl shadow-2xl overflow-hidden transform scale-95 opacity-0 transition-all duration-300`). 

# Caveats
- `about-us.php` contains a lightbox-style modal for the organizational chart that has no background card (just the image). This might need to keep a simpler structure but should still align its overlay classes (`bg-black/80` -> `bg-black/80 backdrop-blur-sm`).
- Backend vs. Frontend color themes differ slightly (e.g., Admin uses `bg-[#0A6C5B]` for success). We should preserve the semantic color but standardize the structural classes (`rounded`, `shadow`, `padding`, `typography`).

# Conclusion
We need to refactor the inline Tailwind CSS classes across the identified files. 

**Fix Strategy:**
1. **Toasters**:
   - Update `admin/assets/js/admin.js` lines 23 and 33 to use: `fixed bottom-6 right-6 ...` and `px-6 py-3.5 rounded-xl shadow-2xl text-white text-sm font-semibold flex items-center gap-3 transform transition-all duration-300 translate-y-10 opacity-0`.
   - Update `includes/footer.php` `#toast` to match structurally and add a `showToast(msg, type)` to `assets/js/main.js` to handle dynamic success/error states, removing all `alert()` calls from `contact-us.php` and `about-us.php`.
2. **Modals**:
   - Refactor overlays in `admin.js`, `bungalow-bookings.php`, `manage-admins.php`, `ampara-circuit-bungalow.php`, and `contact-us.php` to strictly use: `fixed inset-0 z-[100] bg-black/50 backdrop-blur-sm hidden items-center justify-center p-4 transition-opacity duration-300`.
   - Refactor modal cards to use: `bg-white rounded-2xl shadow-2xl w-full max-w-* transform scale-95 opacity-0 transition-all duration-300` (adjusting `max-w` per file).

# Verification Method
1. Run local PHP server and manually trigger the toaster (e.g., via contact form submission or newsletter) on the frontend.
2. Manually trigger a toast in the admin panel. Ensure both toasts have identical structural styling (border-radius, shadows, padding).
3. Open modals in `ampara-circuit-bungalow.php`, `contact-us.php`, and `admin/bungalow-bookings.php`. Ensure they all use the exact same backdrop blur, background opacity, and transition animation.
