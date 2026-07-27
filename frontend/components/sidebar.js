// components/sidebar.js
class AppSidebar extends HTMLElement {
  connectedCallback() {
    this.innerHTML = `
      <aside class="fixed left-0 top-0 h-full w-72 glass border-r border-pink-100 z-20">
        <div class="p-6 border-b border-pink-100 flex items-center gap-3">
          <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-pink-500 to-fuchsia-500 flex items-center justify-center text-white font-bold text-xl shadow-lg">S</div>
          <div>
            <h1 class="text-xl font-extrabold text-gray-900">StoreManager</h1>
            <p class="text-sm text-pink-500 font-medium">Premium Dashboard</p>
          </div>
        </div>

        <nav class="p-4 space-y-2">
          <!-- Dashboard button (points to index.html or disabled) -->
          <a href="./index.html" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-gray-600 hover:bg-pink-50 transition">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7m-9 2v8m0-8H5m7 0h7"/></svg>
            Dashboard
          </a>

          <!-- Categories button points directly to index.html -->
          <a href="./index.html" class="flex items-center gap-3 px-4 py-3 rounded-2xl bg-gradient-to-r from-pink-500 to-fuchsia-500 text-white shadow-lg">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V7a2 2 0 00-2-2h-3V3H9v2H6a2 2 0 00-2 2v6m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0H4"/></svg>
            Categories
          </a>
        </nav>
      </aside>
    `;
  }
}

customElements.define('app-sidebar', AppSidebar);