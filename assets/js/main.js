/**
* Template Name: LeadPage
* Template URL: https://bootstrapmade.com/leadpage-bootstrap-landing-page-template/
* Updated: Aug 12 2025 with Bootstrap v5.3.7
* Author: BootstrapMade.com
* License: https://bootstrapmade.com/license/
*/

(function() {
  "use strict";

  /**
   * Apply .scrolled class to the body as the page is scrolled down
   */
    function toggleScrolled() {
    const selectBody = document.querySelector('body');
    const selectHeader = document.querySelector('#header');
    if (!selectHeader.classList.contains('scroll-up-sticky') && !selectHeader.classList.contains('sticky-top') && !selectHeader.classList.contains('fixed-top')) return;
    window.scrollY > 100 ? selectBody.classList.add('scrolled') : selectBody.classList.remove('scrolled');
  }

  document.addEventListener('scroll', toggleScrolled);
  window.addEventListener('load', toggleScrolled);

  /**
   * Mobile nav toggle
   */
  const mobileNavToggleBtn = document.querySelector('.mobile-nav-toggle');

  function mobileNavToogle() {
    document.querySelector('body').classList.toggle('mobile-nav-active');
    mobileNavToggleBtn.classList.toggle('bi-list');
    mobileNavToggleBtn.classList.toggle('bi-x');
  }
  if (mobileNavToggleBtn) {
    mobileNavToggleBtn.addEventListener('click', mobileNavToogle);
  }

  /**
   * Hide mobile nav on same-page/hash links
   */
  document.querySelectorAll('#navmenu a').forEach(navmenu => {
    navmenu.addEventListener('click', () => {
      if (document.querySelector('.mobile-nav-active')) {
        mobileNavToogle();
      }
    });

  });

  /**
   * Toggle mobile nav dropdowns
   */
  document.querySelectorAll('.navmenu .toggle-dropdown').forEach(navmenu => {
    navmenu.addEventListener('click', function(e) {
      e.preventDefault();
      this.parentNode.classList.toggle('active');
      this.parentNode.nextElementSibling.classList.toggle('dropdown-active');
      e.stopImmediatePropagation();
    });
  });

  /**
   * Preloader
   */
  const preloader = document.querySelector('#preloader');
  if (preloader) {
    window.addEventListener('load', () => {
      preloader.remove();
    });
  }

  /**
   * Scroll top button
   */
  let scrollTop = document.querySelector('.scroll-top');

  function toggleScrollTop() {
    if (scrollTop) {
      window.scrollY > 100 ? scrollTop.classList.add('active') : scrollTop.classList.remove('active');
    }
  }
  scrollTop.addEventListener('click', (e) => {
    e.preventDefault();
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  });

  window.addEventListener('load', toggleScrollTop);
  document.addEventListener('scroll', toggleScrollTop);

  /**
   * Animation on scroll function and init
   */
  function aosInit() {
    AOS.init({
      duration: 600,
      easing: 'ease-in-out',
      once: true,
      mirror: false
    });
  }
  window.addEventListener('load', aosInit);

  /**
   * Initiate Pure Counter
   */
  new PureCounter();

  /**
   * Init swiper sliders
   */
  function initSwiper() {
    document.querySelectorAll(".init-swiper").forEach(function(swiperElement) {
      let config = JSON.parse(
        swiperElement.querySelector(".swiper-config").innerHTML.trim()
      );

      if (swiperElement.classList.contains("swiper-tab")) {
        initSwiperWithCustomPagination(swiperElement, config);
      } else {
        new Swiper(swiperElement, config);
      }
    });
  }

  window.addEventListener("load", initSwiper);

  /**
   * Frequently Asked Questions Toggle
   */
  document.querySelectorAll('.faq-item h3, .faq-item .faq-toggle, .faq-item .faq-header').forEach((faqItem) => {
    faqItem.addEventListener('click', () => {
      faqItem.parentNode.classList.toggle('faq-active');
    });
  });

  /**
   * Initiate glightbox
   */
  const glightbox = GLightbox({
    selector: '.glightbox'
  });

  /**
   * Init isotope layout and filters
   */
  document.querySelectorAll('.isotope-layout').forEach(function(isotopeItem) {
    let layout = isotopeItem.getAttribute('data-layout') ?? 'masonry';
    let filter = isotopeItem.getAttribute('data-default-filter') ?? '*';
    let sort = isotopeItem.getAttribute('data-sort') ?? 'original-order';

    let initIsotope;
    imagesLoaded(isotopeItem.querySelector('.isotope-container'), function() {
      initIsotope = new Isotope(isotopeItem.querySelector('.isotope-container'), {
        itemSelector: '.isotope-item',
        layoutMode: layout,
        filter: filter,
        sortBy: sort
      });
    });

    isotopeItem.querySelectorAll('.isotope-filters li').forEach(function(filters) {
      filters.addEventListener('click', function() {
        isotopeItem.querySelector('.isotope-filters .filter-active').classList.remove('filter-active');
        this.classList.add('filter-active');
        initIsotope.arrange({
          filter: this.getAttribute('data-filter')
        });
        if (typeof aosInit === 'function') {
          aosInit();
        }
      }, false);
    });

  });

  /**
   * Correct scrolling position upon page load for URLs containing hash links.
   */
  window.addEventListener('load', function(e) {
    if (window.location.hash) {
      if (document.querySelector(window.location.hash)) {
        setTimeout(() => {
          let section = document.querySelector(window.location.hash);
          let scrollMarginTop = getComputedStyle(section).scrollMarginTop;
          window.scrollTo({
            top: section.offsetTop - parseInt(scrollMarginTop),
            behavior: 'smooth'
          });
        }, 100);
      }
    }
  });

  /**
   * Navmenu Scrollspy
   */
  let navmenulinks = document.querySelectorAll('.navmenu a');

  function navmenuScrollspy() {
    navmenulinks.forEach(navmenulink => {
      if (!navmenulink.hash) return;
      let section = document.querySelector(navmenulink.hash);
      if (!section) return;
      let position = window.scrollY + 200;
      if (position >= section.offsetTop && position <= (section.offsetTop + section.offsetHeight)) {
        document.querySelectorAll('.navmenu a.active').forEach(link => link.classList.remove('active'));
        navmenulink.classList.add('active');
      } else {
        navmenulink.classList.remove('active');
      }
    })
  }
  window.addEventListener('load', navmenuScrollspy);
  document.addEventListener('scroll', navmenuScrollspy);

})();
        
        let cart = [];
        let userBalance = 10000; 
    // Carrito de compras emergente
        const cartButton = document.getElementById('cartButton');
        const cartPopup = document.getElementById('cartPopup');
        const cartOverlay = document.getElementById('cartOverlay');
        const cartItems = document.getElementById('cartItems');
        const cartBadge = document.getElementById('cartBadge');
        const cartCount = document.getElementById('cartCount');
        const itemCount = document.getElementById('itemCount');
        const totalPrice = document.getElementById('totalPrice');
        const balanceAfter = document.getElementById('balanceAfter');
        const buyButton = document.getElementById('buyButton');

        // Abrir/cerrar carrito
        cartButton.addEventListener('click', () => {
            cartPopup.classList.toggle('active');
            cartOverlay.classList.toggle('active');
        });
         // Cerrar al hacer clic en el overlay
        cartOverlay.addEventListener('click', () => {
            cartPopup.classList.remove('active');
            cartOverlay.classList.remove('active');
        });

        // Botón de comprar
        document.getElementById('buyButton').addEventListener('click', () => {
            cartPopup.classList.remove('active');
            cartOverlay.classList.remove('active');
        });
        // Modificar la función para recibir la imagen
    function addToCart(name, price, imageUrl) {
    cart.push({ 
        name: name, 
        price: price, 
        creator: 'Por Usuario',
        image: imageUrl  // Agregamos la imagen aquí
    });
    updateCart();
    }

// Actualizar la función updateCart para usar la imagen
    function updateCart() {
    const total = cart.reduce((sum, item) => sum + item.price, 0);
    const count = cart.length;

    cartBadge.textContent = count;
    cartCount.textContent = count;
    itemCount.textContent = count;
    totalPrice.textContent = total;
    balanceAfter.textContent = userBalance - total;

    if (count === 0) {
        cartItems.innerHTML = `
            <div class="empty-cart">
                <div class="empty-cart-icon">🛒</div>
                <p>Tu carrito está vacío</p>
            </div>
        `;
        buyButton.disabled = true;
    } else {
        cartItems.innerHTML = cart.map((item, index) => `
            <div class="cart-item">
                <div class="item-image">
                    <img src="${item.image}" alt="${item.name}" 
                         style="width: 100%; height: 100%; object-fit: cover; border-radius: 6px;">
                </div>
                <div class="item-details">
                    <div class="item-name">${item.name}</div>
                    <div class="item-creator">De ${item.creator}</div>
                    <div class="item-price">
                        <span class="robux-icon">R$</span> ${item.price}
                    </div>
                </div>
            </div>
        `).join('');
        buyButton.disabled = false;
    }
}
        // Comprar
        buyButton.addEventListener('click', () => {
            const total = cart.reduce((sum, item) => sum + item.price, 0);
            if (total <= userBalance) {
                alert(`¡Compra realizada! Total: $ ${total}`);
                cart = [];
                updateCart();
                cartPopup.classList.remove('active');
                cartOverlay.classList.remove('active');
            } else {
                alert('Saldo insuficiente');
            }
        });

        // Inicializar
        balanceAfter.textContent = userBalance;


