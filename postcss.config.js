module.exports = {
  plugins: [
    require('tailwindcss'),
    {
      postcssPlugin: 'fix-css-warnings',
      Once(root) {
        root.walkRules((rule) => {
          // 1. Fix appearance warnings on buttons & search inputs
          let hasWebkitAppearanceButton = false;
          let hasWebkitAppearanceTextfield = false;
          let hasAppearance = false;

          rule.walkDecls((decl) => {
            if (decl.prop === '-webkit-appearance') {
              if (decl.value === 'button') hasWebkitAppearanceButton = true;
              if (decl.value === 'textfield') hasWebkitAppearanceTextfield = true;
            }
            if (decl.prop === 'appearance') {
              hasAppearance = true;
            }
          });

          if (!hasAppearance) {
            if (hasWebkitAppearanceButton) {
              rule.append({ prop: 'appearance', value: 'button' });
            } else if (hasWebkitAppearanceTextfield) {
              rule.append({ prop: 'appearance', value: 'textfield' });
            }
          }

          // 2. Fix 'Property is ignored due to display' warning (vertical-align on block media elements)
          if (rule.selector.includes('img') && rule.selector.includes('svg')) {
            let hasDisplayBlock = false;
            rule.walkDecls((decl) => {
              if (decl.prop === 'display' && decl.value === 'block') {
                hasDisplayBlock = true;
              }
            });
            if (hasDisplayBlock) {
              rule.walkDecls((decl) => {
                if (decl.prop === 'vertical-align') {
                  decl.remove();
                }
              });
            }
          }

          // 3. Fix line-clamp compatibility warning
          if (rule.selector.includes('line-clamp')) {
            let lineClampVal = null;
            let hasStandardLineClamp = false;
            rule.walkDecls((decl) => {
              if (decl.prop === '-webkit-line-clamp') {
                lineClampVal = decl.value;
              }
              if (decl.prop === 'line-clamp') {
                hasStandardLineClamp = true;
              }
            });
            if (lineClampVal && !hasStandardLineClamp) {
              rule.append({ prop: 'line-clamp', value: lineClampVal });
            }
          }
        });
      }
    }
  ]
};
