/**
 * Category Filter System
 * 
 * SEO-friendly tool filtering for homepage with tab and dropdown navigation.
 * Filters by visibility (display:none) to maintain DOM structure for search engines.
 */

document.addEventListener('DOMContentLoaded', () => {
  const tabs = document.querySelectorAll('#categoryTabs button[data-category]');
  const dropdownItems = document.querySelectorAll('.dropdown-menu a[data-category]');
  const toolItems = document.querySelectorAll('.tool-item[data-category]');
  const selectedCategoryLabel = document.getElementById('selectedCategory');

  /**
   * Filter tools by category
   *
   * @param {string} category - Category to show ('all' or specific category)
   */
  function filterTools(category) {
    toolItems.forEach((item) => {
      const itemCategory = item.dataset.category;

      if (category === 'all' || itemCategory === category) {
        item.style.display = '';
        item.classList.add('fade-in');
      } else {
        item.style.display = 'none';
        item.classList.remove('fade-in');
      }
    });
  }

  /**
   * Update active state for tab navigation
   *
   * @param {HTMLElement} activeButton - Button to mark as active
   */
  function setActiveTab(activeButton) {
    tabs.forEach((tab) => {
      tab.classList.remove('active');
      tab.setAttribute('aria-selected', 'false');
    });
    activeButton.classList.add('active');
    activeButton.setAttribute('aria-selected', 'true');
  }

  /**
   * Update active state for dropdown navigation
   *
   * @param {HTMLElement} activeItem - Dropdown item to mark as active
   */
  function setActiveDropdownItem(activeItem) {
    dropdownItems.forEach((item) => {
      item.classList.remove('active');
    });
    activeItem.classList.add('active');

    if (selectedCategoryLabel) {
      selectedCategoryLabel.textContent = activeItem.textContent;
    }
  }

  tabs.forEach((tab) => {
    tab.addEventListener('click', (e) => {
      e.preventDefault();
      const category = tab.dataset.category;

      setActiveTab(tab);
      filterTools(category);

      if (category !== 'all') {
        window.history.pushState(null, '', `#${category}`);
      } else {
        window.history.pushState(null, '', window.location.pathname);
      }
    });
  });

  dropdownItems.forEach((item) => {
    item.addEventListener('click', (e) => {
      e.preventDefault();
      const category = item.dataset.category;

      setActiveDropdownItem(item);
      filterTools(category);

      if (category !== 'all') {
        window.history.pushState(null, '', `#${category}`);
      } else {
        window.history.pushState(null, '', window.location.pathname);
      }
    });
  });

  // Apply filter from URL hash on page load
  const hash = window.location.hash.slice(1);
  if (hash && ['encoders', 'formatters', 'converters', 'generators', 'stringtools', 'references', 'utilities'].includes(hash)) {
    const tabButton = document.querySelector(`#categoryTabs button[data-category="${hash}"]`);
    const dropdownItem = document.querySelector(`.dropdown-menu a[data-category="${hash}"]`);

    if (tabButton) {
      setActiveTab(tabButton);
    }
    if (dropdownItem) {
      setActiveDropdownItem(dropdownItem);
    }
    filterTools(hash);
  }
});
