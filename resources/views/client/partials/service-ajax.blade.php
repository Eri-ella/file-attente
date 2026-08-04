<script>
(function () {
    window.smartQueuePanelStack = window.smartQueuePanelStack || [];

    function getTargetContainer() {
        // tousServices : conteneur unique de la grille de services
        var servicesContent = document.getElementById('services-content');
        if (servicesContent) {
            return servicesContent;
        }
        // accueil : grille de cartes défilante
        var slider = document.getElementById('slidedContainer');
        if (slider) {
            return slider;
        }
        // repli générique si aucun des deux n'existe
        return document.getElementById('main-content');
    }

    function loadIntoPane(url, method, body) {
        var container = getTargetContainer();
        if (!container) {
            window.location.href = url;
            return;
        }

        window.smartQueuePanelStack.push({ container: container, html: container.innerHTML });

        fetch(url, {
            method: method || 'GET',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            body: body || null,
        })
            .then(function (res) { return res.text(); })
            .then(function (html) {
                container.innerHTML = html;
                if (method !== 'POST') {
                    history.pushState({ ajaxUrl: url }, '', url);
                }
            })
            .catch(function () {
                window.location.href = url;
            });
    }

    document.addEventListener('click', function (e) {
        var link = e.target.closest('a');
        if (!link) return;
        if (!link.pathname.startsWith('/service/') && !link.pathname.startsWith('/reservation/')) return;

        e.preventDefault();
        loadIntoPane(link.href);
    });

    document.addEventListener('submit', function (e) {
        var form = e.target.closest('.js-reservation-form');
        if (!form) return;
        e.preventDefault();
        loadIntoPane(form.action, 'POST', new FormData(form));
    });

    window.smartQueueGoBack = function () {
        if (window.smartQueuePanelStack.length) {
            var prev = window.smartQueuePanelStack.pop();
            prev.container.innerHTML = prev.html;
            history.back();
        } else {
            history.back();
        }
    };
})();
</script>