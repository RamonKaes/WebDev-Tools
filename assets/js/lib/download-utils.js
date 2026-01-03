/**
 * Download Utilities
 *
 * Secure file download helpers with MIME type validation and filename sanitization.
 * Prevents path traversal attacks and enforces security whitelists.
 */

/**
 * Allowed MIME types for downloads (security whitelist)
 */
const ALLOWED_MIME_TYPES = {
  'text/plain': ['.txt'],
  'text/csv': ['.csv'],
  'text/html': ['.html', '.htm'],
  'text/css': ['.css'],
  'text/javascript': ['.js'],
  'application/json': ['.json'],
  'application/xml': ['.xml'],
  'text/xml': ['.xml'],
  'image/png': ['.png'],
  'image/jpeg': ['.jpg', '.jpeg'],
  'image/gif': ['.gif'],
  'image/svg+xml': ['.svg'],
  'image/webp': ['.webp'],
  'image/bmp': ['.bmp'],
  'application/pdf': ['.pdf'],
  'application/zip': ['.zip'],
  'application/octet-stream': ['.*']
};

/**
 * Sanitize filename to prevent path traversal
 * Removes dangerous characters and enforces length limits
 *
 * @param {string} filename - Original filename
 * @returns {string} - Sanitized filename
 */
export function sanitizeFilename(filename) {
  if (!filename || typeof filename !== 'string') {
    return 'download.txt';
  }

  let sanitized = filename
    .split('')
    .map(char => /[\/\\:\0]/.test(char) ? '_' : char)
    .join('');

  sanitized = sanitized.replace(/[\x00-\x1F\x7F]/g, '');
  sanitized = sanitized.replace(/\.{3,}/g, '.');
  sanitized = sanitized.replace(/^[\s.]+|[\s.]+$/g, '');

  if (sanitized.length > 255) {
    const ext = sanitized.slice(sanitized.lastIndexOf('.'));
    const name = sanitized.slice(0, 255 - ext.length);
    sanitized = name + ext;
  }

  if (!sanitized || sanitized === '.') {
    return 'download.txt';
  }

  return sanitized;
}

/**
 * Validate MIME type against whitelist
 *
 * @param {string} mimeType - MIME type to validate
 * @returns {boolean} - True if valid
 */
export function isValidMimeType(mimeType) {
  return mimeType in ALLOWED_MIME_TYPES;
}

/**
 * Get validated MIME type or return safe default
 *
 * @param {string} mimeType - MIME type to validate
 * @returns {string} - Validated MIME type or default
 */
function getValidatedMimeType(mimeType) {
  if (isValidMimeType(mimeType)) {
    return mimeType;
  }

  console.warn(`MIME type "${mimeType}" not in whitelist, using application/octet-stream`);
  return 'application/octet-stream';
}

/**
 * Download text content as file
 *
 * @param {string} content - Text content to download
 * @param {string} filename - Filename for download
 * @param {string} mimeType - MIME type
 */
export function downloadText(content, filename, mimeType = 'text/plain') {
  const validatedMimeType = getValidatedMimeType(mimeType);
  const sanitizedFilename = sanitizeFilename(filename);

  const blob = new Blob([content], { type: validatedMimeType });
  downloadBlob(blob, sanitizedFilename);
}

/**
 * Download JSON data as file
 *
 * @param {object} data - JSON data to download
 * @param {string} filename - Filename
 * @param {boolean} pretty - Whether to prettify JSON
 */
export function downloadJSON(data, filename = 'data.json', pretty = true) {
  const content = pretty ? JSON.stringify(data, null, 2) : JSON.stringify(data);
  const sanitizedFilename = sanitizeFilename(filename);
  downloadText(content, sanitizedFilename, 'application/json');
}

/**
 * Download Blob object as file
 *
 * @param {Blob} blob - Blob to download
 * @param {string} filename - Filename for download
 */
export function downloadBlob(blob, filename) {
  const sanitizedFilename = sanitizeFilename(filename);
  const url = URL.createObjectURL(blob);
  const a = document.createElement('a');
  a.href = url;
  a.download = sanitizedFilename;
  a.style.display = 'none';
  a.rel = 'noopener noreferrer';

  document.body.appendChild(a);
  a.click();

  setTimeout(() => {
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
  }, 100);
}

/**
 * Download canvas content as PNG image
 *
 * @param {HTMLCanvasElement} canvas - Canvas element
 * @param {string} filename - Filename
 * @param {number} quality - Image quality 0-1
 */
export function downloadCanvas(canvas, filename = 'image.png', quality = 0.92) {
  const sanitizedFilename = sanitizeFilename(filename);

  canvas.toBlob((blob) => {
    if (blob) {
      downloadBlob(blob, sanitizedFilename);
    } else {
      console.error('Failed to create blob from canvas');
    }
  }, 'image/png', quality);
}

/**
 * Download SVG content as SVG file
 *
 * @param {string} svgContent - SVG markup
 * @param {string} filename - Filename
 */
export function downloadSVG(svgContent, filename = 'image.svg') {
  const sanitizedFilename = sanitizeFilename(filename);
  const blob = new Blob([svgContent], { type: 'image/svg+xml' });
  downloadBlob(blob, sanitizedFilename);
}

/**
 * Download Base64 data as file
 *
 * @param {string} base64Data - Base64 data or data URL
 * @param {string} filename - Filename for download
 */
export function downloadBase64(base64Data, filename) {
  const sanitizedFilename = sanitizeFilename(filename);
  let mimeType = 'application/octet-stream';
  let base64Content = base64Data;

  const dataUrlMatch = base64Data.match(/^data:([^;]+);base64,(.+)$/);
  if (dataUrlMatch) {
    mimeType = dataUrlMatch[1];
    base64Content = dataUrlMatch[2];
  }

  const validatedMimeType = getValidatedMimeType(mimeType);

  try {
    const binaryString = atob(base64Content);
    const bytes = new Uint8Array(binaryString.length);
    for (let i = 0; i < binaryString.length; i++) {
      bytes[i] = binaryString.charCodeAt(i);
    }

    const blob = new Blob([bytes], { type: validatedMimeType });
    downloadBlob(blob, sanitizedFilename);
  } catch (error) {
    console.error('Failed to decode base64:', error);
    throw new Error('Invalid base64 data');
  }
}

/**
 * Download CSV data as file with UTF-8 BOM for Excel compatibility
 *
 * @param {Array<Array<string>>} data - 2D array of CSV data
 * @param {string} filename - Filename
 * @param {string} delimiter - CSV delimiter
 * @param {boolean} includeBOM - Include UTF-8 BOM for Excel
 */
export function downloadCSV(data, filename = 'data.csv', delimiter = ',', includeBOM = true) {
  const sanitizedFilename = sanitizeFilename(filename);

  const csvContent = data
    .map(row => row
      .map(cell => {
        const cellStr = String(cell);
        if (cellStr.includes(delimiter) || cellStr.includes('"') || cellStr.includes('\n')) {
          return `"${cellStr.replace(/"/g, '""')}"`;
        }
        return cellStr;
      })
      .join(delimiter)
    )
    .join('\n');

  if (includeBOM) {
    const BOM = '\uFEFF';
    const encoder = new TextEncoder();
    const bomBytes = encoder.encode(BOM + csvContent);
    const blob = new Blob([bomBytes], { type: 'text/csv;charset=utf-8' });
    downloadBlob(blob, sanitizedFilename);
  } else {
    downloadText(csvContent, sanitizedFilename, 'text/csv;charset=utf-8');
  }
}

/**
 * Create download link element
 *
 * @param {string} url - URL or data URL
 * @param {string} filename - Filename for download
 * @returns {HTMLAnchorElement} - Configured anchor element
 */
export function createDownloadLink(url, filename) {
  const sanitizedFilename = sanitizeFilename(filename);
  const a = document.createElement('a');
  a.href = url;
  a.download = sanitizedFilename;
  a.rel = 'noopener noreferrer';
  return a;
}
