// js/toast.js
// Small helper to show transient toast notifications. Designed to be
// safe to call from any page — it will auto-create the container if needed.
export function showToast(message, type = 'success') {
  let toast = document.getElementById('toast');

  // If the host page doesn't include the toast container, create it so
  // callers don't need to worry about bootstrapping markup.
  if (!toast) {
    toast = document.createElement('div');
    toast.id = 'toast';
    toast.className = 'toast hidden fixed bottom-6 right-6 z-50 opacity-0 translate-y-2 transition-all duration-300';
    toast.innerHTML = `<div id="toast-inner" class="px-5 py-4 rounded-2xl text-sm font-semibold shadow-2xl"></div>`;
    document.body.appendChild(toast);
  }

  const inner = document.getElementById('toast-inner');
  inner.textContent = message;
  inner.className = `px-5 py-4 rounded-2xl text-sm font-semibold shadow-2xl ${
    type === 'success' ? 'bg-gradient-to-r from-pink-500 to-fuchsia-500 text-white' : 'bg-red-500 text-white'
  }`;

  // Animate toast in
  toast.classList.remove('hidden');
  requestAnimationFrame(() => toast.classList.remove('opacity-0', 'translate-y-2'));

  // Clear any previous hide timer and schedule hiding after 3s
  clearTimeout(showToast._t);
  showToast._t = setTimeout(() => {
    toast.classList.add('opacity-0', 'translate-y-2');
    setTimeout(() => toast.classList.add('hidden'), 250);
  }, 3000);
}