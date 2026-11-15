document.addEventListener('DOMContentLoaded', () => {
    const toast = document.querySelector('[data-flash-toast]');
    if (toast) {
        window.setTimeout(() => {
            toast.style.transition = 'opacity 0.35s ease, transform 0.35s ease';
            toast.style.opacity = '0';
            toast.style.transform = 'translateY(-4px)';
            window.setTimeout(() => toast.remove(), 350);
        }, 4000);
    }

    document.querySelectorAll('form[method="POST"]').forEach((form) => {
        form.addEventListener('submit', (event) => {
            if (form.dataset.submitting === 'true') {
                event.preventDefault();
                return;
            }
            form.dataset.submitting = 'true';
            const submitButton = form.querySelector('button[type="submit"]');
            if (submitButton) {
                submitButton.classList.add('opacity-70', 'pointer-events-none');
            }
        });
    });

    const searchInput = document.querySelector('[data-todo-search]');
    if (searchInput) {
        document.addEventListener('keydown', (event) => {
            if (
                event.key === '/' &&
                !['INPUT', 'TEXTAREA', 'SELECT'].includes(document.activeElement?.tagName)
            ) {
                event.preventDefault();
                searchInput.focus();
                searchInput.select();
            }
        });
    }
});
