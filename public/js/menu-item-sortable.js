document.addEventListener('DOMContentLoaded', () => {
    const listContainers = document.querySelectorAll('.filament-tables-table tbody');

    listContainers.forEach((container) => {
        new Sortable(container, {
            group: 'nested',
            animation: 150,
            fallbackOnBody: true,
            swapThreshold: 0.65,
            onEnd: async function (evt) {
                const parentId = evt.to.closest('tr').dataset.key;
                const children = Array.from(evt.to.children).map(child => child.dataset.key);
                
                await fetch('/admin/menu-items/reorder', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({ parent_id: parentId, children }),
                });
            },
        });
    });
});