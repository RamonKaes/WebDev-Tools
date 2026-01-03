/**
 * JSON Tree View Renderer
 *
 * Interactive tree visualization for JSON data with lazy loading and virtualization.
 * Provides expand/collapse controls and efficient rendering for large datasets.
 */

/**
 * Configuration for tree renderer
 */
export const CONFIG = {
  VIRTUALIZATION_THRESHOLD: 1000,
  LAZY_RENDER_THRESHOLD: 50,
  MAX_INITIAL_RENDER: 100
};

/**
 * Count total nodes in JSON data
 *
 * @param {any} data - JSON data
 * @returns {number} - Total node count
 */
function countNodes(data) {
  if (data === null || typeof data !== 'object') return 1;

  let count = 1;

  if (Array.isArray(data)) {
    data.forEach(item => {
      count += countNodes(item);
    });
  } else {
    Object.values(data).forEach(value => {
      count += countNodes(value);
    });
  }

  return count;
}

/**
 * Render JSON data as interactive tree view
 *
 * @param {any} data - Parsed JSON data
 * @param {HTMLElement} container - Target container
 * @param {Object} options - Rendering options
 */
export function renderJSONTree(data, container, options = {}) {
  container.innerHTML = '';

  const nodeCount = countNodes(data);
  const useVirtualization = nodeCount > CONFIG.VIRTUALIZATION_THRESHOLD;
  const enableLazy = options.enableLazy !== false;

  // Add control buttons
  const controls = document.createElement('div');
  controls.className = 'json-tree-controls mb-2';
  controls.innerHTML = `
    <button class="btn btn-sm btn-outline-secondary me-2" id="json-expand-all">
      <i class="bi bi-arrows-expand"></i> Expand All
    </button>
    <button class="btn btn-sm btn-outline-secondary me-2" id="json-collapse-all">
      <i class="bi bi-arrows-collapse"></i> Collapse All
    </button>
    <span class="text-muted small">
      ${nodeCount.toLocaleString(document.documentElement.lang || 'en')} node${nodeCount === 1 ? '' : 's'}
      ${useVirtualization ? ' (virtualized)' : ''}
    </span>
  `;
  container.appendChild(controls);

  const tree = document.createElement('div');
  tree.className = 'json-tree';
  tree.dataset.nodeCount = nodeCount;
  tree.dataset.virtualized = useVirtualization;

  renderNode(data, tree, 0, enableLazy);

  container.appendChild(tree);

  setupToggleHandlers(container);
  setupControlButtons(container, tree);

  if (useVirtualization) {
    setupLazyRendering(tree);
  }
}

/**
 * Setup toggle handlers for expand/collapse
 *
 * @param {HTMLElement} container - Tree container
 */
function setupToggleHandlers(container) {
  container.querySelectorAll('.json-tree-toggle').forEach(toggle => {
    toggle.addEventListener('click', function(e) {
      e.stopPropagation();
      this.classList.toggle('collapsed');
      const content = this.nextElementSibling;
      if (content && content.classList.contains('json-tree-children')) {
        content.style.display = content.style.display === 'none' ? 'block' : 'none';

        if (content.dataset.lazyRender === 'true' && content.style.display === 'block') {
          renderLazyChildren(content);
        }
      }
    });
  });
}

/**
 * Setup Expand All / Collapse All buttons
 *
 * @param {HTMLElement} container - Main container
 * @param {HTMLElement} tree - Tree element
 */
function setupControlButtons(container, tree) {
  const expandBtn = container.querySelector('#json-expand-all');
  const collapseBtn = container.querySelector('#json-collapse-all');

  if (expandBtn) {
    expandBtn.addEventListener('click', () => {
      tree.querySelectorAll('.json-tree-toggle').forEach(toggle => {
        toggle.classList.remove('collapsed');
        const content = toggle.nextElementSibling;
        if (content && content.classList.contains('json-tree-children')) {
          content.style.display = 'block';

          if (content.dataset.lazyRender === 'true') {
            renderLazyChildren(content);
          }
        }
      });
    });
  }

  if (collapseBtn) {
    collapseBtn.addEventListener('click', () => {
      tree.querySelectorAll('.json-tree-toggle').forEach(toggle => {
        toggle.classList.add('collapsed');
        const content = toggle.nextElementSibling;
        if (content && content.classList.contains('json-tree-children')) {
          content.style.display = 'none';
        }
      });
    });
  }
}

/**
 * Setup IntersectionObserver for lazy rendering
 *
 * @param {HTMLElement} tree - Tree element
 */
function setupLazyRendering(tree) {
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting && entry.target.dataset.lazyRender === 'true') {
        renderLazyChildren(entry.target);
        observer.unobserve(entry.target);
      }
    });
  }, {
    root: null,
    rootMargin: '50px',
    threshold: 0.01
  });

  tree.querySelectorAll('[data-lazy-render="true"]').forEach(el => {
    observer.observe(el);
  });
}

/**
 * Render lazy children
 *
 * @param {HTMLElement} container - Children container
 */
function renderLazyChildren(container) {
  if (container.dataset.lazyRender !== 'true') return;

  const data = JSON.parse(container.dataset.lazyData);
  const depth = parseInt(container.dataset.depth);
  const type = container.dataset.type;

  container.innerHTML = '';

  if (type === 'object') {
    Object.keys(data).forEach(key => {
      const row = document.createElement('div');
      row.className = 'json-tree-row';

      const keySpan = document.createElement('span');
      keySpan.className = 'json-tree-key';
      keySpan.textContent = `"${key}": `;
      row.appendChild(keySpan);

      renderNode(data[key], row, depth + 1, false);
      container.appendChild(row);
    });
  } else if (type === 'array') {
    data.forEach((item, index) => {
      const row = document.createElement('div');
      row.className = 'json-tree-row';

      const indexSpan = document.createElement('span');
      indexSpan.className = 'json-tree-index';
      indexSpan.textContent = `[${index}]: `;
      row.appendChild(indexSpan);

      renderNode(item, row, depth + 1, false);
      container.appendChild(row);
    });
  }

  container.removeAttribute('data-lazy-render');
  container.removeAttribute('data-lazy-data');
  container.removeAttribute('data-depth');
  container.removeAttribute('data-type');
}

/**
 * Render single node in tree
 *
 * @param {any} value - Node value
 * @param {HTMLElement} parent - Parent element
 * @param {number} depth - Current depth
 * @param {boolean} enableLazy - Enable lazy rendering
 */
function renderNode(value, parent, depth, enableLazy = false) {
  const type = getValueType(value);

  if (type === 'object') {
    renderObject(value, parent, depth, enableLazy);
  } else if (type === 'array') {
    renderArray(value, parent, depth, enableLazy);
  } else {
    renderPrimitive(value, type, parent);
  }
}

/**
 * Render object
 *
 * @param {Object} obj - Object to render
 * @param {HTMLElement} parent - Parent element
 * @param {number} depth - Current depth
 * @param {boolean} enableLazy - Enable lazy rendering
 */
function renderObject(obj, parent, depth, enableLazy = false) {
  const keys = Object.keys(obj);

  if (keys.length === 0) {
    const empty = document.createElement('span');
    empty.className = 'json-tree-empty';
    empty.textContent = '{}';
    parent.appendChild(empty);
    return;
  }

  const container = document.createElement('div');
  container.className = 'json-tree-object';

  const toggle = document.createElement('span');
  toggle.className = 'json-tree-toggle';
  toggle.innerHTML = '<i class="bi bi-chevron-down"></i>';
  container.appendChild(toggle);

  const label = document.createElement('span');
  label.className = 'json-tree-label';
  label.textContent = `Object (${keys.length} ${keys.length === 1 ? 'key' : 'keys'})`;
  container.appendChild(label);

  const children = document.createElement('div');
  children.className = 'json-tree-children';
  children.style.paddingLeft = '1.5rem';

  if (enableLazy && keys.length > CONFIG.LAZY_RENDER_THRESHOLD) {
    children.dataset.lazyRender = 'true';
    children.dataset.lazyData = JSON.stringify(obj);
    children.dataset.depth = depth;
    children.dataset.type = 'object';
    children.innerHTML = '<div class="text-muted small">Click to load...</div>';
  } else {
    const itemsToRender = enableLazy && keys.length > CONFIG.MAX_INITIAL_RENDER
      ? keys.slice(0, CONFIG.MAX_INITIAL_RENDER)
      : keys;

    itemsToRender.forEach(key => {
      const row = document.createElement('div');
      row.className = 'json-tree-row';

      const keySpan = document.createElement('span');
      keySpan.className = 'json-tree-key';
      keySpan.textContent = `"${key}": `;
      row.appendChild(keySpan);

      renderNode(obj[key], row, depth + 1, enableLazy);
      children.appendChild(row);
    });

    if (enableLazy && keys.length > CONFIG.MAX_INITIAL_RENDER) {
      const loadMore = document.createElement('div');
      loadMore.className = 'json-tree-load-more text-muted small';
      loadMore.textContent = `... ${keys.length - CONFIG.MAX_INITIAL_RENDER} more items`;
      loadMore.style.cursor = 'pointer';
      loadMore.addEventListener('click', function() {
        this.remove();
        keys.slice(CONFIG.MAX_INITIAL_RENDER).forEach(key => {
          const row = document.createElement('div');
          row.className = 'json-tree-row';

          const keySpan = document.createElement('span');
          keySpan.className = 'json-tree-key';
          keySpan.textContent = `"${key}": `;
          row.appendChild(keySpan);

          renderNode(obj[key], row, depth + 1, false);
          children.appendChild(row);
        });
      });
      children.appendChild(loadMore);
    }
  }

  container.appendChild(children);
  parent.appendChild(container);
}

/**
 * Render array
 *
 * @param {Array} arr - Array to render
 * @param {HTMLElement} parent - Parent element
 * @param {number} depth - Current depth
 * @param {boolean} enableLazy - Enable lazy rendering
 */
function renderArray(arr, parent, depth, enableLazy = false) {
  if (arr.length === 0) {
    const empty = document.createElement('span');
    empty.className = 'json-tree-empty';
    empty.textContent = '[]';
    parent.appendChild(empty);
    return;
  }

  const container = document.createElement('div');
  container.className = 'json-tree-array';

  const toggle = document.createElement('span');
  toggle.className = 'json-tree-toggle';
  toggle.innerHTML = '<i class="bi bi-chevron-down"></i>';
  container.appendChild(toggle);

  const label = document.createElement('span');
  label.className = 'json-tree-label';
  label.textContent = `Array (${arr.length} ${arr.length === 1 ? 'item' : 'items'})`;
  container.appendChild(label);

  const children = document.createElement('div');
  children.className = 'json-tree-children';
  children.style.paddingLeft = '1.5rem';

  const itemsToRender = enableLazy && arr.length > CONFIG.MAX_INITIAL_RENDER
    ? arr.slice(0, CONFIG.MAX_INITIAL_RENDER)
    : arr;

  itemsToRender.forEach((item, index) => {
    const row = document.createElement('div');
    row.className = 'json-tree-row';

    const indexSpan = document.createElement('span');
    indexSpan.className = 'json-tree-index';
    indexSpan.textContent = `[${index}]: `;
    row.appendChild(indexSpan);

    renderNode(item, row, depth + 1, enableLazy);
    children.appendChild(row);
  });

  if (enableLazy && arr.length > CONFIG.MAX_INITIAL_RENDER) {
    const loadMore = document.createElement('div');
    loadMore.className = 'json-tree-load-more text-muted small';
    loadMore.textContent = `... ${arr.length - CONFIG.MAX_INITIAL_RENDER} more items`;
    loadMore.style.cursor = 'pointer';
    loadMore.addEventListener('click', function() {
      this.remove();
      arr.slice(CONFIG.MAX_INITIAL_RENDER).forEach((item, index) => {
        const row = document.createElement('div');
        row.className = 'json-tree-row';

        const indexSpan = document.createElement('span');
        indexSpan.className = 'json-tree-index';
        indexSpan.textContent = `[${index + CONFIG.MAX_INITIAL_RENDER}]: `;
        row.appendChild(indexSpan);

        renderNode(item, row, depth + 1, false);
        children.appendChild(row);
      });
    });
    children.appendChild(loadMore);
  }

  container.appendChild(children);
  parent.appendChild(container);
}

/**
 * Render primitive value
 */
function renderPrimitive(value, type, parent) {
  const span = document.createElement('span');
  span.className = `json-tree-value json-tree-${type}`;

  switch (type) {
    case 'string':
      span.textContent = `"${value}"`;
      break;
    case 'number':
      span.textContent = value.toString();
      break;
    case 'boolean':
      span.textContent = value ? 'true' : 'false';
      break;
    case 'null':
      span.textContent = 'null';
      break;
    default:
      span.textContent = String(value);
  }

  parent.appendChild(span);
}

/**
 * Get value type
 */
function getValueType(value) {
  if (value === null) return 'null';
  if (Array.isArray(value)) return 'array';
  if (typeof value === 'object') return 'object';
  return typeof value;
}

/**
 * Add CSS styles for tree view
 */
export function addTreeStyles() {
  if (document.getElementById('json-tree-styles')) return;

  const style = document.createElement('style');
  style.id = 'json-tree-styles';
  style.textContent = `
    .json-tree-controls {
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }
    .json-tree-toggle {
      cursor: pointer;
      user-select: none;
      margin-right: 0.5rem;
      display: inline-block;
      width: 16px;
      transition: transform 0.2s;
    }
    .json-tree-toggle.collapsed {
      transform: rotate(-90deg);
    }
    .json-tree-toggle.collapsed + .json-tree-label {
      opacity: 0.7;
    }
    .json-tree-row {
      margin: 0.25rem 0;
    }
    .json-tree-key {
      color: var(--bs-purple);
      font-weight: 500;
    }
    .json-tree-index {
      color: var(--bs-blue);
      font-weight: 500;
    }
    .json-tree-value {
      font-family: var(--bs-font-monospace);
    }
    .json-tree-string {
      color: var(--bs-green);
    }
    .json-tree-number {
      color: var(--bs-cyan);
    }
    .json-tree-boolean {
      color: var(--bs-orange);
      font-weight: 600;
    }
    .json-tree-null {
      color: var(--bs-secondary);
      font-style: italic;
    }
    .json-tree-label {
      color: var(--bs-body-color);
      opacity: 0.8;
      font-size: 0.9rem;
    }
    .json-tree-empty {
      color: var(--bs-secondary);
      font-family: var(--bs-font-monospace);
    }
    .json-tree-load-more {
      padding: 0.5rem;
      margin: 0.25rem 0;
      background: var(--bs-light);
      border-radius: 0.25rem;
      transition: background 0.2s;
    }
    .json-tree-load-more:hover {
      background: var(--bs-secondary-bg);
    }
  `;

  document.head.appendChild(style);
}

// Functions and configuration are already exported inline above
// No need for duplicate export statement
