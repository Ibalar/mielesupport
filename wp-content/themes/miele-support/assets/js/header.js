// header.js
document.addEventListener("DOMContentLoaded", function () {
    const burger = document.querySelector(".burger");
    const offcanvas = document.querySelector(".offcanvas");
    const offcanvasOverlay = document.querySelector(".offcanvas__overlay");
    const offcanvasClose = document.querySelector(".offcanvas__close");

    const cta = document.querySelector(".header-cta");
    const quickFormModal = document.querySelector(".quick-form-modal");
    const quickFormOverlay = document.querySelector(
        ".quick-form-modal__overlay"
    );
    const quickFormClose = document.querySelector(".quick-form-modal__close");

    // helper: блокируем скролл страницы
    function lockBodyScroll() {
        document.documentElement.style.overflow = "hidden";
        document.body.style.overflow = "hidden";
    }

    function unlockBodyScroll() {
        document.documentElement.style.overflow = "";
        document.body.style.overflow = "";
    }

    // -------- Offcanvas burger --------

    function openOffcanvas() {
        if (!offcanvas) return;
        offcanvas.classList.add("offcanvas--open");
        burger && burger.classList.add("burger--active");
        lockBodyScroll();
    }

    function closeOffcanvas() {
        if (!offcanvas) return;
        offcanvas.classList.remove("offcanvas--open");
        burger && burger.classList.remove("burger--active");
        unlockBodyScroll();
    }

    if (burger && offcanvas) {
        burger.addEventListener("click", function () {
            if (offcanvas.classList.contains("offcanvas--open")) {
                closeOffcanvas();
            } else {
                openOffcanvas();
            }
        });
    }

    if (offcanvasOverlay) {
        offcanvasOverlay.addEventListener("click", closeOffcanvas);
    }

    if (offcanvasClose) {
        offcanvasClose.addEventListener("click", closeOffcanvas);
    }

    // -------- Быстрая форма (CTA) --------

    function openQuickForm() {
        if (!quickFormModal) return;
        quickFormModal.classList.add("quick-form-modal--open");
        lockBodyScroll();
    }

    function closeQuickForm() {
        if (!quickFormModal) return;
        quickFormModal.classList.remove("quick-form-modal--open");
        unlockBodyScroll();
    }

    if (cta && quickFormModal) {
        cta.addEventListener("click", function (e) {
            e.preventDefault();
            openQuickForm();
        });
    }

    if (quickFormOverlay) {
        quickFormOverlay.addEventListener("click", closeQuickForm);
    }

    if (quickFormClose) {
        quickFormClose.addEventListener("click", closeQuickForm);
    }

    // закрытие по Esc
    document.addEventListener("keydown", function (e) {
        if (e.key === "Escape") {
            if (offcanvas && offcanvas.classList.contains("offcanvas--open")) {
                closeOffcanvas();
            }
            if (
                quickFormModal &&
                quickFormModal.classList.contains("quick-form-modal--open")
            ) {
                closeQuickForm();
            }
        }
    });

    // -------- Мега-меню --------

    const nav = document.querySelector(".main-nav");
    const megaMenu = document.querySelector("#services-mega");
    const rootToggle = document.querySelector(
        ".main-nav__item--has-mega .js-nav-toggle"
    );
    const submenuToggles = megaMenu
        ? megaMenu.querySelectorAll(".mega-menu__item--has-sub > .js-nav-toggle")
        : [];
    const desktopQuery = window.matchMedia("(min-width: 1025px)");

    function isDesktop() {
        return desktopQuery.matches;
    }

    function togglePanel(btn, forceOpen = null) {
        const targetSelector = btn.dataset.target;
        const panel = document.querySelector(targetSelector);
        if (!panel) return;

        const isOpen = btn.getAttribute("aria-expanded") === "true";
        const shouldOpen = forceOpen !== null ? forceOpen : !isOpen;

        btn.setAttribute("aria-expanded", shouldOpen ? "true" : "false");
        panel.hidden = !shouldOpen;
        btn.classList.toggle("is-open", shouldOpen);

        if (panel.classList.contains("mega-menu__sub")) {
            panel.classList.toggle("mega-menu__submenu--collapsed", !shouldOpen);
            panel.classList.toggle("mega-menu__submenu--expanded", shouldOpen);
        }

        if (panel === megaMenu && !shouldOpen) {
            closeAllSubmenus();
        }
    }

    function closeAllSubmenus() {
        submenuToggles.forEach((btn) => togglePanel(btn, false));
    }

    function closeSiblingSubmenus(activeBtn) {
        submenuToggles.forEach((btn) => {
            if (btn !== activeBtn) {
                togglePanel(btn, false);
            }
        });
    }

    submenuToggles.forEach((btn) => {
        const item = btn.closest(".mega-menu__item--has-sub");

        btn.addEventListener("click", (event) => {
            event.preventDefault();
            closeSiblingSubmenus(btn);
            togglePanel(btn);
        });

        if (item) {
            item.addEventListener("mouseenter", () => {
                if (!isDesktop()) return;
                closeSiblingSubmenus(btn);
                togglePanel(btn, true);
            });

            item.addEventListener("mouseleave", () => {
                if (!isDesktop()) return;
                togglePanel(btn, false);
            });
        }
    });

    if (rootToggle) {
        const rootItem = rootToggle.closest(".main-nav__item--has-mega");
        let hoverTimeout;

        rootToggle.addEventListener("click", (event) => {
            event.preventDefault();
            togglePanel(rootToggle);
        });

        if (rootItem) {
            rootItem.addEventListener("mouseenter", () => {
                clearTimeout(hoverTimeout);
                togglePanel(rootToggle, true);
            });

            rootItem.addEventListener("mouseleave", () => {
                hoverTimeout = setTimeout(() => {
                    if (!megaMenu || !megaMenu.matches(":hover")) {
                        togglePanel(rootToggle, false);
                    }
                }, 100);
            });
        }

        if (megaMenu) {
            megaMenu.addEventListener("mouseenter", () => {
                clearTimeout(hoverTimeout);
            });

            megaMenu.addEventListener("mouseleave", () => {
                togglePanel(rootToggle, false);
            });
        }
    }

    // клик вне меню и мега-меню — закрыть
    document.addEventListener("click", (e) => {
        const clickInsideNav = nav && nav.contains(e.target);
        const clickInsideMega = megaMenu && megaMenu.contains(e.target);

        if (clickInsideNav || clickInsideMega) return;

        if (rootToggle) {
            togglePanel(rootToggle, false);
        }
        closeAllSubmenus();
    });

    // -------- Бургер подменю --------

    const burgerToggles = document.querySelectorAll(".js-burger-toggle");

    function toggleBurgerSubmenu(btn, forceOpen = null) {
        const targetSelector = btn.dataset.target;
        const panel = document.querySelector(targetSelector);
        if (!panel) return;

        const isOpen = btn.getAttribute("aria-expanded") === "true";
        const shouldOpen = forceOpen !== null ? forceOpen : !isOpen;

        btn.setAttribute("aria-expanded", shouldOpen ? "true" : "false");
        panel.hidden = !shouldOpen;
        btn.classList.toggle("is-open", shouldOpen);
    }

    burgerToggles.forEach((btn) => {
        btn.addEventListener("click", () => toggleBurgerSubmenu(btn));
    });
});
