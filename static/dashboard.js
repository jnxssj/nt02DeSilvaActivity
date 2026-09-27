const sidebar = document.getElementById('sidebar');
    const backdrop = document.getElementById('sidebarBackdrop');
    const toggle = document.getElementById('menuToggle');

    function closeSidebar() {
        sidebar.classList.remove('show');
        backdrop.classList.remove('show');
        toggle.setAttribute('aria-expanded', 'false');
    }

    toggle.addEventListener('click', () => {
        const isOpen = sidebar.classList.toggle('show');
        backdrop.classList.toggle('show', isOpen);
        toggle.setAttribute('aria-expanded', String(isOpen));
    });

    backdrop.addEventListener('click', closeSidebar);

    document.querySelectorAll('.side-nav .nav-link').forEach((link) => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            document.querySelectorAll('.side-nav .nav-link').forEach((l) => l.classList.remove('active'));
            link.classList.add('active');
            closeSidebar();
        });
    });

    const dateEl = document.getElementById('topbarDate');
    const today = new Date();
    const formatted = today.toLocaleDateString('en-US', {
        weekday: 'long',
        month: 'long',
        day: 'numeric',
        year: 'numeric'
    });
    dateEl.textContent = formatted.toUpperCase();

    