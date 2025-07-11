/* ----------------------------------------------------------------------------
 * Bookmarx - Open Source Telemetry
 *
 * @package     Bookmarx
 * @author      A.Tselegidis <alextselegidis@gmail.com>
 * @copyright   Copyright (c) Alex Tselegidis
 * @license     https://opensource.org/licenses/GPL-3.0 - GPLv3
 * @link        https://bookmarx.org
 * ---------------------------------------------------------------------------- */

// Auto-hide alert

setTimeout(() => {
    const alertNodeList = document.querySelectorAll('.alert');
    if (alertNodeList.length) {
        Array.from(alertNodeList).forEach((alertEl) => {
            const bsAlert = bootstrap.Alert.getOrCreateInstance(alertEl);
            bsAlert.close();
        });
    }
}, 3000); // 3000 ms = 3 seconds

// Auto-focus create modal input

document
    .getElementById('create-modal')
    .addEventListener('shown.bs.modal', (event) => event.target.querySelector('input:not([type="hidden"])').focus());
