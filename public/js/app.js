// Live search: as the user types, fetch the results page in the background
// and swap in the result list without a full reload. Without JavaScript the
// form still works as a normal GET search.
(() => {
    const form = document.querySelector('form[data-live-search]');
    if (!form) {
        return;
    }

    const input = form.querySelector('input[name="q"]');
    const target = document.querySelector(form.dataset.liveSearch);
    let timer = null;
    let controller = null;

    const search = async () => {
        const url = new URL(form.action);
        if (input.value.trim() !== '') {
            url.searchParams.set('q', input.value.trim());
        }

        controller?.abort();
        controller = new AbortController();

        try {
            const response = await fetch(url, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                signal: controller.signal,
            });
            const html = await response.text();
            const fresh = new DOMParser().parseFromString(html, 'text/html').querySelector(form.dataset.liveSearch);

            if (fresh && target) {
                target.innerHTML = fresh.innerHTML;
                history.replaceState(null, '', url);
            }
        } catch (error) {
            if (error.name !== 'AbortError') {
                form.submit();
            }
        }
    };

    input.addEventListener('input', () => {
        clearTimeout(timer);
        timer = setTimeout(search, 300);
    });
})();
