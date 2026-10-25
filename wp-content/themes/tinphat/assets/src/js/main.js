/**
 * JS của theme Tín Phát.
 *
 * Thay cho các component React ở bản Next.js:
 * - đếm số khi cuộn tới (thay CcKeyNumbers)
 * - carousel dự án (thay CcProjects, dùng Swiper)
 */

import Swiper from 'swiper';
import { Navigation, Autoplay, Pagination } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

/**
 * Đếm số từ 0 tới đích khi phần tử lọt vào khung nhìn.
 */
function initCounters() {
  const sections = document.querySelectorAll('[data-tp-count]');
  if (sections.length === 0) return;

  // Người dùng bật "giảm chuyển động" thì hiện thẳng số cuối.
  const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  const runCount = (el) => {
    const target = parseInt(el.dataset.tpCountTo || '0', 10);
    if (Number.isNaN(target)) return;

    if (reduceMotion) {
      el.textContent = target.toLocaleString('vi-VN');
      return;
    }

    const duration = 1600;
    let startTime = null;

    const step = (timestamp) => {
      if (startTime === null) startTime = timestamp;
      const progress = Math.min((timestamp - startTime) / duration, 1);
      el.textContent = Math.floor(progress * target).toLocaleString('vi-VN');
      if (progress < 1) requestAnimationFrame(step);
    };

    requestAnimationFrame(step);
  };

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (!entry.isIntersecting) return;
        entry.target.querySelectorAll('[data-tp-count-to]').forEach(runCount);
        observer.unobserve(entry.target);
      });
    },
    { threshold: 0.25 }
  );

  sections.forEach((section) => observer.observe(section));
}

/**
 * Đánh dấu các slide "đang xem" của carousel dự án.
 *
 * Trang mẫu dùng slick: 3 slide giữa cùng mang .slick-active và cao
 * 125%, hai slide ló ở mép thấp hơn (85%). Swiper không có sẵn cách
 * gán như vậy nên tính tay quanh slide đang ở giữa.
 *
 * @param {import('swiper').Swiper} sw Thể hiện Swiper.
 */
function markActive(sw) {
  // slidesPerView có thể là 'auto' (bề rộng do CSS quyết định); khi đó
  // tính số slide lọt trong khung từ bề rộng thật của slide đầu tiên.
  let shown = sw.params.slidesPerView;

  if (typeof shown !== 'number') {
    const first = sw.slides[0];
    const w = first?.getBoundingClientRect().width || 0;
    const cs = first ? getComputedStyle(first) : null;
    const gap = cs ? parseFloat(cs.marginLeft) + parseFloat(cs.marginRight) : 0;
    shown = w > 0 ? Math.floor(sw.width / (w + gap)) : 1;
  }

  const half = Math.floor(Math.max(1, shown) / 2);

  sw.slides.forEach((slide, i) => {
    // realIndex nằm giữa; lấy half slide mỗi bên.
    const offset = i - sw.activeIndex;
    slide.classList.toggle('slick-active', offset >= -half && offset <= half);
  });
}

/**
 * Khởi tạo carousel dự án.
 */
function initProjectSliders() {
  const sliders = document.querySelectorAll('.slider_projects');
  if (sliders.length === 0) return;

  sliders.forEach((el) => {
    new Swiper(el, {
      // --- Cảm ứng trên điện thoại ---
      // Mặc định Swiper nuốt mọi cử chỉ bắt đầu trong vùng slider và chỉ
      // nhả khi góc vuốt lệch quá 45° so với phương ngang. Ba slider của
      // trang chủ chiếm gần hết chiều cao màn hình nên người dùng vuốt
      // dọc hơi xiên là trang đứng im.
      //
      // touchStartPreventDefault: false  -> trình duyệt vẫn cuộn được
      // touchAngle: 30                   -> chỉ nhận là vuốt ngang khi
      //                                     thật sự ngang
      // touchReleaseOnEdges: true        -> tới slide đầu/cuối thì nhả
      touchStartPreventDefault: false,
      touchAngle: 30,
      touchReleaseOnEdges: true,
      resistanceRatio: 0.65,

      modules: [Navigation, Pagination, Autoplay],
      // Trang mẫu: slide rộng 376px, bước nhảy 400px. Khoảng cách đã
      // do .slider_projects .item { margin: 0 12px } trong template lo,
      // nên KHÔNG đặt spaceBetween nữa — đặt thêm sẽ cộng dồn.
      slidesPerView: 1,
      spaceBetween: 0,
      loop: true,
      centeredSlides: true,
      autoplay: { delay: 4000, pauseOnMouseEnter: true, disableOnInteraction: false },

      // CSS của template viết cho slick, nơi CẢ 3 slide đang hiện đều
      // mang class .slick-active (khung cao 125%), còn các slide ló ra
      // ở mép thì thấp hơn (85%).
      //
      // Swiper chỉ gán slideActiveClass cho đúng một slide, còn
      // slideVisibleClass lại gán cho cả slide mới ló một phần (thành
      // 4 slide cao). Nên tự gán class: đúng 3 slide quanh slide giữa.
      watchSlidesProgress: true,
      on: {
        init: markActive,
        slideChange: markActive,
        resize: markActive,
      },

      navigation: {
        prevEl: el.querySelector('.left_nav'),
        nextEl: el.querySelector('.right_nav'),
      },
      pagination: {
        el: el.querySelector('.swiper-pagination'),
        clickable: true,
      },
      breakpoints: {
        768: { slidesPerView: 2 },
        992: { slidesPerView: 'auto' },
      },
    });
  });
}

function init() {
  initBannerSlider();
  initCounters();
  initProjectSliders();
  initMobileMenu();
  initSearchToggle();
  initSectionTabs();
  initAccordion();
  initPartnerSlider();
  initScrollReveal();
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', init);
} else {
  init();
}

/**
 * Banner slider trang chủ.
 */
function initBannerSlider() {
  const el = document.querySelector('.tp-banner__slider');
  if (!el) return;

  new Swiper(el, {
      // --- Cảm ứng trên điện thoại ---
      // Mặc định Swiper nuốt mọi cử chỉ bắt đầu trong vùng slider và chỉ
      // nhả khi góc vuốt lệch quá 45° so với phương ngang. Ba slider của
      // trang chủ chiếm gần hết chiều cao màn hình nên người dùng vuốt
      // dọc hơi xiên là trang đứng im.
      //
      // touchStartPreventDefault: false  -> trình duyệt vẫn cuộn được
      // touchAngle: 30                   -> chỉ nhận là vuốt ngang khi
      //                                     thật sự ngang
      // touchReleaseOnEdges: true        -> tới slide đầu/cuối thì nhả
      touchStartPreventDefault: false,
      touchAngle: 30,
      touchReleaseOnEdges: true,
      resistanceRatio: 0.65,

    modules: [Navigation, Autoplay, Pagination],
    slidesPerView: 1,
    loop: el.querySelectorAll('.swiper-slide').length > 1,
    autoplay: { delay: 5000, pauseOnMouseEnter: true, disableOnInteraction: false },
    navigation: {
      prevEl: el.querySelector('.swiper-button-prev'),
      nextEl: el.querySelector('.swiper-button-next'),
    },
    pagination: { el: el.querySelector('.swiper-pagination'), clickable: true },
  });
}

/**
 * Tab điều hướng trang con: cuộn ngang và ẩn nút khi hết chiều.
 */
function initSectionTabs() {
  const track = document.querySelector('[data-tp-tabs-track]');
  if (!track) return;

  const prev = document.querySelector('[data-tp-tabs-prev]');
  const next = document.querySelector('[data-tp-tabs-next]');

  const update = () => {
    const max = track.scrollWidth - track.clientWidth;
    prev?.setAttribute('aria-disabled', String(track.scrollLeft <= 2));
    next?.setAttribute('aria-disabled', String(track.scrollLeft >= max - 2));
  };

  const scrollBy = (dir) => {
    track.scrollBy({ left: dir * Math.max(160, track.clientWidth * 0.6), behavior: 'smooth' });
  };

  prev?.addEventListener('click', () => scrollBy(-1));
  next?.addEventListener('click', () => scrollBy(1));
  track.addEventListener('scroll', update, { passive: true });
  window.addEventListener('resize', update);

  // Cuộn tới mục đang xem nếu nó nằm ngoài khung nhìn.
  const active = track.querySelector('.item.active');
  if (active) {
    const offset = active.offsetLeft - (track.clientWidth - active.clientWidth) / 2;
    track.scrollLeft = Math.max(0, offset);
  }

  update();
}

/**
 * Accordion khối tuyển dụng — mở một mục tại một thời điểm.
 */
function initAccordion() {
  document.querySelectorAll('[data-tp-accordion]').forEach((root) => {
    root.querySelectorAll('.accordion-button').forEach((btn) => {
      btn.addEventListener('click', () => {
        const item = btn.closest('.accordion-item');
        const panel = item?.querySelector('.accordion-collapse');
        const isOpen = panel?.classList.contains('show');

        root.querySelectorAll('.accordion-collapse').forEach((p) => p.classList.remove('show'));
        root.querySelectorAll('.accordion-button').forEach((b) => {
          b.classList.add('collapsed');
          b.setAttribute('aria-expanded', 'false');
        });

        if (!isOpen && panel) {
          panel.classList.add('show');
          btn.classList.remove('collapsed');
          btn.setAttribute('aria-expanded', 'true');
        }
      });
    });
  });
}

/**
 * Dải logo đối tác chạy liên tục.
 */
function initPartnerSlider() {
  const el = document.querySelector('.tp-partners__slider');
  if (!el) return;

  new Swiper(el, {
      // --- Cảm ứng trên điện thoại ---
      // Mặc định Swiper nuốt mọi cử chỉ bắt đầu trong vùng slider và chỉ
      // nhả khi góc vuốt lệch quá 45° so với phương ngang. Ba slider của
      // trang chủ chiếm gần hết chiều cao màn hình nên người dùng vuốt
      // dọc hơi xiên là trang đứng im.
      //
      // touchStartPreventDefault: false  -> trình duyệt vẫn cuộn được
      // touchAngle: 30                   -> chỉ nhận là vuốt ngang khi
      //                                     thật sự ngang
      // touchReleaseOnEdges: true        -> tới slide đầu/cuối thì nhả
      touchStartPreventDefault: false,
      touchAngle: 30,
      touchReleaseOnEdges: true,
      resistanceRatio: 0.65,

    modules: [Autoplay],
    slidesPerView: 2,
    spaceBetween: 24,
    loop: true,
    autoplay: { delay: 2500, pauseOnMouseEnter: true, disableOnInteraction: false },
    breakpoints: {
      576: { slidesPerView: 3 },
      768: { slidesPerView: 4 },
      992: { slidesPerView: 5 },
    },
  });
}

/**
 * Drawer menu mobile + toggle submenu.
 */
function initMobileMenu() {
  const burger = document.querySelector('.hamburger_btn');
  const drawer = document.getElementById('menu_mobile');
  const overlay = document.querySelector('.overlay_menu');
  if (!burger || !drawer) return;

  const setOpen = (open) => {
    drawer.classList.toggle('open', open);
    overlay?.classList.toggle('open', open);
    burger.querySelector('.hamburger-icon')?.classList.toggle('open', open);
    burger.setAttribute('aria-expanded', String(open));
  };

  burger.addEventListener('click', (e) => {
    e.preventDefault();
    setOpen(!drawer.classList.contains('open'));
  });

  overlay?.addEventListener('click', () => setOpen(false));

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') setOpen(false);
  });

  // Cấp 1 có con: bấm để mở submenu thay vì chuyển trang.
  drawer.querySelectorAll('.menu-item-has-children > a').forEach((link) => {
    link.addEventListener('click', (e) => {
      e.preventDefault();
      link.parentElement.classList.toggle('showmenu');
      link.parentElement.querySelector('.sub-menu')?.classList.toggle('d-block');
    });
  });
}

/**
 * Ô tìm kiếm ở header.
 */
function initSearchToggle() {
  const wrap = document.querySelector('.search_btn');
  if (!wrap) return;

  const trigger = wrap.querySelector('a');
  const form = wrap.querySelector('.search_form');
  if (!trigger || !form) return;

  trigger.addEventListener('click', (e) => {
    e.preventDefault();
    const open = form.style.display === 'block';
    form.style.display = open ? 'none' : 'block';
    if (!open) form.querySelector('input[type="search"]')?.focus();
  });

  document.addEventListener('click', (e) => {
    if (!wrap.contains(e.target)) form.style.display = 'none';
  });
}

/**
 * Hiệu ứng hiện dần khi cuộn (thay AOS).
 */
function initScrollReveal() {
  const items = document.querySelectorAll('[data-aos]');
  if (items.length === 0) return;

  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    items.forEach((el) => el.classList.add('aos-animate'));
    return;
  }

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (!entry.isIntersecting) return;
        entry.target.classList.add('aos-animate');
        observer.unobserve(entry.target);
      });
    },
    { threshold: 0.15, rootMargin: '0px 0px -40px 0px' }
  );

  items.forEach((el) => observer.observe(el));
}
