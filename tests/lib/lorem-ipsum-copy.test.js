import { TestRunner, assert } from '../test-runner.js';
import { handleCopyButton, isClipboardSupported } from '../../assets/js/lib/clipboard-utils.js';

const runner = new TestRunner();

runner.test('handleCopyButton: shows button feedback on success', async () => {
  // Setup markup like the tool uses
  const button = document.createElement('button');
  button.innerHTML = '<i class="bi bi-clipboard me-2" aria-hidden="true"></i><span class="btn-text">Copy</span>';
  document.body.appendChild(button);

  // Mock clipboard if not supported by environment
  const originalClipboard = navigator.clipboard;
  let wroteText = null;
  navigator.clipboard = { writeText: async (text) => { wroteText = text; return Promise.resolve(); } };

  if (!isClipboardSupported()) {
    // If clipboard isn't supported, fallback is used; this test still verifies button feedback
  }

  // Run handler (short duration so test completes quickly)
  const result = await handleCopyButton(button, 'Hello Test', { useToast: false, showButtonFeedback: true, duration: 50 });

  assert.equal(result, true, 'Copy should resolve to true');
  assert.equal(wroteText, 'Hello Test', 'Clipboard writeText must be called with provided text');

  // Immediately after, the button should be disabled (during feedback)
  assert.equal(button.disabled, true, 'Button should be disabled during feedback');

  // After the duration, it should restore (give a bit of margin)
  await new Promise((resolve) => setTimeout(resolve, 80));
  assert.equal(button.disabled, false, 'Button should be enabled after feedback duration');

  // Cleanup
  if (originalClipboard) navigator.clipboard = originalClipboard;
  document.body.removeChild(button);
});

runner.run();
