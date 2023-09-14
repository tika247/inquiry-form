((win, doc) => {
    class ActivateSubmitBtn {
        constructor(root, options = {}) {
            this.btnClass = options.btnClass || 'fn-form-btn';

            this.root = root;
            this.required = this.root.querySelectorAll('select[required], input[required], textarea[required]');
            this.btn = this.root.querySelector(`.${this.btnClass}`);
        }

        /**
         * Initialize
         */
        init() {
            this.required.forEach(el => {
                if (el instanceof HTMLSelectElement) {
                    el.addEventListener('change', this.checkRequiredValues.bind(this));
                } else {
                    el.addEventListener('keyup', this.checkRequiredValues.bind(this));
                    el.addEventListener('paste', this.checkRequiredValues.bind(this));
                }
            });
        }

        /**
         * Check each values and activate or inactivate button
         * @param {HTMLElement} el
         */
        checkRequiredValues() {
            const result = [...this.required].some((el) => el.value.trim() === "");
            (!result) ? this.btn.removeAttribute('disabled') : this.btn.setAttribute('disabled', 'true');
        }
    }
    (() => {
        const rootEl = doc.querySelector('.js-form');
        if (!rootEl) return;

        const activateSubmitBtn = new ActivateSubmitBtn(rootEl);
        activateSubmitBtn.checkRequiredValues(); // for the case at least one required element has its value added by PHP
        activateSubmitBtn.init();
    })();
})(window, document);