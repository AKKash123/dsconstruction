/**
 * DS Construction - Frontend JavaScript & Theme Controller
 */

(function() {
    'use strict';

    // --- DAY / NIGHT THEME CONTROLLER ---
    const THEME_COOKIE_NAME = 'ds_theme_pref';
    const htmlEl = document.documentElement;

    function getCookie(name) {
        const matches = document.cookie.match(new RegExp('(?:^|; )' + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + '=([^;]*)'));
        return matches ? decodeURIComponent(matches[1]) : null;
    }

    function setCookie(name, value, days = 365) {
        const date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        document.cookie = `${name}=${encodeURIComponent(value)};expires=${date.toUTCString()};path=/;SameSite=Lax`;
    }

    // Determine day or night based on local client clock
    function isDayTimeNow() {
        const now = new Date();
        const currentMins = now.getHours() * 60 + now.getMinutes();
        const sunrise = 6 * 60;        // 6:00 AM
        const sunset = 18 * 60 + 30;   // 6:30 PM
        return (currentMins >= sunrise && currentMins < sunset);
    }

    function applyTheme(preference) {
        let activeTheme = 'day';

        if (preference === 'day') {
            activeTheme = 'day';
        } else if (preference === 'night') {
            activeTheme = 'night';
        } else {
            // Auto mode
            activeTheme = isDayTimeNow() ? 'day' : 'night';
        }

        htmlEl.classList.remove('theme-day', 'theme-night');
        htmlEl.classList.add(`theme-${activeTheme}`);

        // Update switcher buttons UI
        document.querySelectorAll('[data-theme-btn]').forEach(btn => {
            const btnTheme = btn.getAttribute('data-theme-btn');
            if (btnTheme === preference) {
                btn.classList.add('active');
            } else {
                btn.classList.remove('active');
            }
        });

        // Update auto badge text if exists
        const autoBadge = document.getElementById('themeAutoStatus');
        if (autoBadge) {
            autoBadge.textContent = isDayTimeNow() ? 'Daytime' : 'Nightfall';
        }
    }

    function setThemePreference(pref) {
        localStorage.setItem(THEME_COOKIE_NAME, pref);
        setCookie(THEME_COOKIE_NAME, pref, 365);
        applyTheme(pref);
    }

    // Initialize Theme
    const savedPref = localStorage.getItem(THEME_COOKIE_NAME) || getCookie(THEME_COOKIE_NAME) || 'auto';
    applyTheme(savedPref);

    // Bind Theme Switcher Buttons
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('[data-theme-btn]').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const pref = btn.getAttribute('data-theme-btn');
                setThemePreference(pref);
            });
        });

        // If in auto mode, re-evaluate every minute
        setInterval(() => {
            const currentPref = localStorage.getItem(THEME_COOKIE_NAME) || 'auto';
            if (currentPref === 'auto') {
                applyTheme('auto');
            }
        }, 60000);

        // --- STICKY NAVBAR ---
        const navbar = document.querySelector('.site-navbar');
        if (navbar) {
            window.addEventListener('scroll', () => {
                if (window.scrollY > 40) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            });
        }

        // --- MOBILE MENU TOGGLE ---
        const mobileToggle = document.querySelector('.mobile-nav-toggle');
        const navLinks = document.querySelector('.nav-links');
        if (mobileToggle && navLinks) {
            mobileToggle.addEventListener('click', () => {
                navLinks.classList.toggle('active');
                const icon = mobileToggle.querySelector('i');
                if (icon) {
                    icon.classList.toggle('fa-bars');
                    icon.classList.toggle('fa-xmark');
                }
            });
        }

        // --- PORTFOLIO CATEGORY FILTER ---
        const filterBtns = document.querySelectorAll('.filter-btn');
        const projectCards = document.querySelectorAll('[data-category]');

        if (filterBtns.length > 0 && projectCards.length > 0) {
            filterBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    filterBtns.forEach(b => b.classList.remove('active'));
                    btn.classList.add('active');

                    const selectedCategory = btn.getAttribute('data-filter');

                    projectCards.forEach(card => {
                        const cardCategory = card.getAttribute('data-category');
                        if (selectedCategory === 'all' || cardCategory.toLowerCase() === selectedCategory.toLowerCase()) {
                            card.style.display = 'block';
                            card.style.opacity = '1';
                        } else {
                            card.style.display = 'none';
                            card.style.opacity = '0';
                        }
                    });
                });
            });
        }

        // --- ANIMATED COUNTERS ---
        const counters = document.querySelectorAll('.counter-val');
        if (counters.length > 0 && 'IntersectionObserver' in window) {
            let countersStarted = false;
            const counterObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting && !countersStarted) {
                        countersStarted = true;
                        counters.forEach(counter => {
                            const rawTarget = counter.getAttribute('data-target') || counter.textContent;
                            const numericTarget = parseInt(rawTarget.replace(/\D/g, ''), 10);
                            const suffix = rawTarget.replace(/[0-9]/g, '');

                            if (isNaN(numericTarget)) return;

                            let count = 0;
                            const duration = 1800; // ms
                            const increment = Math.ceil(numericTarget / (duration / 25));

                            const timer = setInterval(() => {
                                count += increment;
                                if (count >= numericTarget) {
                                    counter.textContent = numericTarget + suffix;
                                    clearInterval(timer);
                                } else {
                                    counter.textContent = count + suffix;
                                }
                            }, 25);
                        });
                    }
                });
            }, { threshold: 0.2 });

            const statsSection = document.querySelector('.hero-stats-grid');
            if (statsSection) {
                counterObserver.observe(statsSection);
            }
        }
    });
})();
