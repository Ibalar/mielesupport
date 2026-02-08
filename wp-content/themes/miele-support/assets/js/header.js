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
    const toggles = document.querySelectorAll(".js-nav-toggle");

    function togglePanel(btn, forceOpen = null) {
        const targetSelector = btn.dataset.target;
        const panel = document.querySelector(targetSelector);
        if (!panel) return;

        const isOpen = btn.getAttribute("aria-expanded") === "true";
        const shouldOpen = forceOpen !== null ? forceOpen : !isOpen;

        btn.setAttribute("aria-expanded", shouldOpen ? "true" : "false");
        panel.hidden = !shouldOpen;
        btn.classList.toggle("is-open", shouldOpen);
    }

    // клик по триггерам
    toggles.forEach((btn) => {
        btn.addEventListener("click", () => togglePanel(btn));
    });

    // ховер только для верхнего пункта (Services)
    const rootItem = document.querySelector(".main-nav__item--has-mega");
    if (rootItem) {
        const rootBtn = rootItem.querySelector(".js-nav-toggle");
        let hoverTimeout;

        rootItem.addEventListener("mouseenter", () => {
            clearTimeout(hoverTimeout);
            togglePanel(rootBtn, true);
        });

        rootItem.addEventListener("mouseleave", (e) => {
            // Проверяем, не перешла ли мышь на mega-menu
            hoverTimeout = setTimeout(() => {
                // Если мышь не на mega-menu, закрываем
                if (!megaMenu || !megaMenu.matches(':hover')) {
                    togglePanel(rootBtn, false);
                }
            }, 100);
        });

        // Обработчик для mega-menu
        if (megaMenu) {
            megaMenu.addEventListener("mouseenter", () => {
                clearTimeout(hoverTimeout);
            });

            megaMenu.addEventListener("mouseleave", () => {
                togglePanel(rootBtn, false);
            });
        }
    }

    // клик вне меню и мега-меню — закрыть
    document.addEventListener("click", (e) => {
        const clickInsideNav = nav && nav.contains(e.target);
        const clickInsideMega = megaMenu && megaMenu.contains(e.target);

        if (clickInsideNav || clickInsideMega) return;

        toggles.forEach((btn) => togglePanel(btn, false));
    });
});
