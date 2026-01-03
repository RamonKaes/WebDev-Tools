/**
 * DOM Utility Functions
 *
 * Safe DOM manipulation helpers with XSS protection.
 * Provides consistent text handling and element creation across all tools.
 */

/**
 * Escape HTML special characters to prevent XSS
 *
 * @param {string} text - Text to escape
 * @returns {string} - HTML-escaped string
 */
export function escapeHtml(text) {
  if (typeof window !== 'undefined' && window.AppHelpers && typeof window.AppHelpers.escapeHtml === 'function') {
    return window.AppHelpers.escapeHtml(text);
  }

  if (typeof text !== 'string') return '';
  return text
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;')
    .replace(/'/g, '&#039;');
} 

/**
 * Safely set text content on element
 *
 * @param {HTMLElement} element - Target element
 * @param {string} text - Text to set
 */
export function setTextContent(element, text) {
  element.textContent = '';
  element.appendChild(document.createTextNode(text));
}

/**
 * Create alert element with optional icon
 *
 * @param {string} message - Alert message
 * @param {string} type - Alert type: 'success', 'danger', 'warning', 'info'
 * @param {string} iconClass - Optional Bootstrap Icon class
 * @returns {HTMLElement} - The alert element
 */
export function createAlert(message, type = 'info', iconClass = null) {
  const alert = document.createElement('div');
  alert.className = `alert alert-${type} mb-0`;

  if (iconClass) {
    const icon = document.createElement('i');
    icon.className = `${iconClass} me-2`;
    alert.appendChild(icon);
  }

  alert.appendChild(document.createTextNode(message));
  return alert;
}

/**
 * Display message in container
 *
 * @param {HTMLElement} container - Target container
 * @param {string} message - Message to display
 * @param {string} type - Message type: 'success', 'danger', 'warning', 'info', 'muted'
 * @param {string} iconClass - Optional Bootstrap Icon class
 */
export function displayMessage(container, message, type = 'muted', iconClass = null) {
  container.textContent = '';

  const paragraph = document.createElement('p');
  paragraph.className = `text-${type} mb-0`;

  if (iconClass) {
    const icon = document.createElement('i');
    icon.className = `${iconClass} me-2`;
    paragraph.appendChild(icon);
  }

  paragraph.appendChild(document.createTextNode(message));
  container.appendChild(paragraph);
}

/**
 * Create text node with optional wrapper
 *
 * @param {string} text - Text content
 * @param {string} wrapperTag - Optional HTML tag to wrap text
 * @returns {HTMLElement|Text} - Text node or wrapped element
 */
export function createText(text, wrapperTag = null) {
  if (wrapperTag) {
    const wrapper = document.createElement(wrapperTag);
    wrapper.textContent = text;
    return wrapper;
  }
  return document.createTextNode(text);
}
