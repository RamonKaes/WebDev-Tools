/**
 * Drag and Drop File Handling Utilities
 *
 * Secure file upload handlers with MIME type validation and size limits.
 * Prevents malicious file uploads and provides consistent drag-drop experience.
 */

/**
 * Default security configuration
 */
const DEFAULT_CONFIG = {
  MAX_FILE_SIZE: 10 * 1024 * 1024,
  ALLOWED_TYPES: [
    'image/png', 'image/jpeg', 'image/gif', 'image/webp', 'image/svg+xml', 'image/bmp',
    'text/plain', 'text/csv', 'text/html', 'text/css', 'text/javascript',
    'application/json', 'application/xml', 'text/xml',
    'application/pdf'
  ],
  BLOCKED_EXTENSIONS: [
    '.exe', '.bat', '.cmd', '.com', '.scr', '.vbs', '.js', '.jar',
    '.app', '.deb', '.rpm', '.dmg', '.pkg', '.sh', '.bash',
    '.ps1', '.psm1', '.psd1', '.msi', '.dll', '.so', '.dylib'
  ]
};

/**
 * Validate file security (type, size, extension)
 *
 * @param {File} file - File to validate
 * @param {object} options - Validation options
 * @param {number} options.maxSize - Maximum file size in bytes
 * @param {Array<string>} options.allowedTypes - Allowed MIME types
 * @param {Array<string>} options.blockedExtensions - Blocked file extensions
 * @returns {object} - Validation result with { valid: boolean, error: string }
 */
export function validateFileSecurity(file, options = {}) {
  const {
    maxSize = DEFAULT_CONFIG.MAX_FILE_SIZE,
    allowedTypes = DEFAULT_CONFIG.ALLOWED_TYPES,
    blockedExtensions = DEFAULT_CONFIG.BLOCKED_EXTENSIONS
  } = options;

  if (file.size > maxSize) {
    return {
      valid: false,
      error: `File size (${formatFileSize(file.size)}) exceeds maximum (${formatFileSize(maxSize)})`
    };
  }

  const fileName = file.name.toLowerCase();
  const hasBlockedExt = blockedExtensions.some(ext => fileName.endsWith(ext));
  if (hasBlockedExt) {
    return {
      valid: false,
      error: `File type not allowed: ${file.name}`
    };
  }

  if (allowedTypes && allowedTypes.length > 0) {
    const isAllowed = allowedTypes.some(type => {
      if (type.endsWith('/*')) {
        const category = type.slice(0, -2);
        return file.type.startsWith(category + '/');
      }
      return file.type === type;
    });

    if (!isAllowed) {
      return {
        valid: false,
        error: `MIME type not allowed: ${file.type || 'unknown'}`
      };
    }
  }

  if (file.type && file.name) {
    const ext = fileName.slice(fileName.lastIndexOf('.'));
    const suspiciousMismatches = {
      '.txt': ['text/plain', 'text/csv'],
      '.json': ['application/json'],
      '.xml': ['application/xml', 'text/xml'],
      '.png': ['image/png'],
      '.jpg': ['image/jpeg'],
      '.jpeg': ['image/jpeg'],
      '.gif': ['image/gif'],
      '.svg': ['image/svg+xml']
    };

    if (ext in suspiciousMismatches) {
      const expectedTypes = suspiciousMismatches[ext];
      if (!expectedTypes.includes(file.type)) {
        console.warn(`MIME type mismatch: ${file.name} has type ${file.type}, expected ${expectedTypes.join(' or ')}`);
      }
    }
  }

  return { valid: true, error: null };
}

/**
 * Set up drag-and-drop file handling on element
 *
 * @param {HTMLElement} element - Drop zone element
 * @param {Function} onFilesDropped - Callback when files are dropped
 * @param {object} options - Optional configuration
 * @param {string} options.highlightClass - CSS class to apply during drag
 * @param {Array<string>} options.acceptedTypes - Accepted MIME types
 * @param {boolean} options.multiple - Allow multiple files
 * @param {number} options.maxFileSize - Maximum file size in bytes
 * @param {boolean} options.validateSecurity - Enable security validation
 * @param {Function} options.onValidationError - Callback for validation errors
 * @returns {Function} - Cleanup function to remove event listeners
 */
export function setupDropZone(element, onFilesDropped, options = {}) {
  const {
    highlightClass = 'drag-over',
    acceptedTypes = null,
    multiple = true,
    maxFileSize = DEFAULT_CONFIG.MAX_FILE_SIZE,
    validateSecurity = true,
    onValidationError = null
  } = options;

  let dragCounter = 0;

  function handleDragEnter(e) {
    e.preventDefault();
    e.stopPropagation();
    dragCounter++;
    if (dragCounter === 1) {
      element.classList.add(highlightClass);
    }
  }

  function handleDragOver(e) {
    e.preventDefault();
    e.stopPropagation();

    const allowedEffects = ['copy', 'move'];
    if (e.dataTransfer.effectAllowed && !allowedEffects.includes(e.dataTransfer.effectAllowed)) {
      console.warn(`Suspicious drop effect: ${e.dataTransfer.effectAllowed}`);
    }

    e.dataTransfer.dropEffect = 'copy';
  }

  function handleDragLeave(e) {
    e.preventDefault();
    e.stopPropagation();
    dragCounter--;
    if (dragCounter === 0) {
      element.classList.remove(highlightClass);
    }
  }

  function handleDrop(e) {
    e.preventDefault();
    e.stopPropagation();
    dragCounter = 0;
    element.classList.remove(highlightClass);

    const files = e.dataTransfer.files;
    if (files.length === 0) return;

    let filteredFiles = Array.from(files);

    if (validateSecurity) {
      const validatedFiles = [];
      for (const file of filteredFiles) {
        const validation = validateFileSecurity(file, {
          maxSize: maxFileSize,
          allowedTypes: acceptedTypes || DEFAULT_CONFIG.ALLOWED_TYPES
        });

        if (validation.valid) {
          validatedFiles.push(file);
        } else {
          console.warn(`File rejected: ${file.name} - ${validation.error}`);
          if (onValidationError) {
            onValidationError(file, validation.error);
          }
        }
      }
      filteredFiles = validatedFiles;
    } else {
      if (acceptedTypes && acceptedTypes.length > 0) {
        filteredFiles = filteredFiles.filter(file =>
          acceptedTypes.some(type => {
            if (type.endsWith('/*')) {
              const category = type.slice(0, -2);
              return file.type.startsWith(category + '/');
            }
            return file.type === type;
          })
        );
      }
    }

    if (!multiple && filteredFiles.length > 0) {
      filteredFiles = [filteredFiles[0]];
    }

    if (filteredFiles.length > 0) {
      onFilesDropped(filteredFiles);
    }
  }

  element.addEventListener('dragenter', handleDragEnter);
  element.addEventListener('dragover', handleDragOver);
  element.addEventListener('dragleave', handleDragLeave);
  element.addEventListener('drop', handleDrop);

  return () => {
    element.removeEventListener('dragenter', handleDragEnter);
    element.removeEventListener('dragover', handleDragOver);
    element.removeEventListener('dragleave', handleDragLeave);
    element.removeEventListener('drop', handleDrop);
    element.classList.remove(highlightClass);
  };
}

/**
 * Read file as text
 *
 * @param {File} file - File to read
 * @param {string} encoding - Character encoding
 * @returns {Promise<string>} - File content as text
 */
export function readFileAsText(file, encoding = 'UTF-8') {
  return new Promise((resolve, reject) => {
    const reader = new FileReader();
    reader.onload = (e) => resolve(e.target.result);
    reader.onerror = (e) => reject(new Error(`Failed to read file: ${file.name}`));
    reader.readAsText(file, encoding);
  });
}

/**
 * Read file as Data URL (base64)
 *
 * @param {File} file - File to read
 * @returns {Promise<string>} - File content as data URL
 */
export function readFileAsDataURL(file) {
  return new Promise((resolve, reject) => {
    const reader = new FileReader();
    reader.onload = (e) => resolve(e.target.result);
    reader.onerror = (e) => reject(new Error(`Failed to read file: ${file.name}`));
    reader.readAsDataURL(file);
  });
}

/**
 * Read file as ArrayBuffer
 *
 * @param {File} file - File to read
 * @returns {Promise<ArrayBuffer>} - File content as ArrayBuffer
 */
export function readFileAsArrayBuffer(file) {
  return new Promise((resolve, reject) => {
    const reader = new FileReader();
    reader.onload = (e) => resolve(e.target.result);
    reader.onerror = (e) => reject(new Error(`Failed to read file: ${file.name}`));
    reader.readAsArrayBuffer(file);
  });
}

/**
 * Read file with progress tracking
 *
 * @param {File} file - File to read
 * @param {Function} onProgress - Progress callback (progress: 0-100)
 * @param {string} readAs - Read mode: 'text', 'dataURL', 'arrayBuffer'
 * @returns {Promise} - File content
 */
export function readFileWithProgress(file, onProgress, readAs = 'arrayBuffer') {
  return new Promise((resolve, reject) => {
    const reader = new FileReader();

    reader.onprogress = (e) => {
      if (e.lengthComputable) {
        const progress = Math.round((e.loaded / e.total) * 100);
        onProgress(progress);
      }
    };

    reader.onload = (e) => resolve(e.target.result);
    reader.onerror = (e) => reject(new Error(`Failed to read file: ${file.name}`));

    switch (readAs) {
      case 'text':
        reader.readAsText(file);
        break;
      case 'dataURL':
        reader.readAsDataURL(file);
        break;
      case 'arrayBuffer':
      default:
        reader.readAsArrayBuffer(file);
        break;
    }
  });
}

/**
 * Validate file size
 *
 * @param {File} file - File to check
 * @param {number} maxSizeMB - Maximum size in megabytes
 * @returns {boolean} - True if file is within size limit
 */
export function validateFileSize(file, maxSizeMB) {
  const maxBytes = maxSizeMB * 1024 * 1024;
  return file.size <= maxBytes;
}

/**
 * Validate file type
 *
 * @param {File} file - File to check
 * @param {Array<string>} acceptedTypes - Accepted MIME types or extensions
 * @returns {boolean} - True if file type is accepted
 */
export function validateFileType(file, acceptedTypes) {
  return acceptedTypes.some(type => {
    if (type.startsWith('.')) {
      return file.name.toLowerCase().endsWith(type.toLowerCase());
    }
    if (type.endsWith('/*')) {
      const category = type.slice(0, -2);
      return file.type.startsWith(category + '/');
    }
    return file.type === type;
  });
}

/**
 * Format file size for display
 *
 * @param {number} bytes - File size in bytes
 * @returns {string} - Formatted size (e.g., '1.5 MB')
 */
export function formatFileSize(bytes) {
  if (bytes === 0) return '0 Bytes';

  const k = 1024;
  const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
  const i = Math.floor(Math.log(bytes) / Math.log(k));

  return Math.round((bytes / Math.pow(k, i)) * 100) / 100 + ' ' + sizes[i];
}

export { DEFAULT_CONFIG };
