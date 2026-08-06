// components/sidebar.js
// Web component that renders the left-hand navigation/sidebar with dynamic active link detection.
class AppSidebar extends HTMLElement {
  connectedCallback() {
    this.style.display = 'block';

    // Get current filename to accurately highlight the active page
    const currentPath = window.location.pathname;
    const isProducts = currentPath.includes('products.html');
    const isCategories = currentPath.includes('categories.html') || (currentPath.endsWith('/index.html') || currentPath.endsWith('/'));

    // Reusable tailwind classes for active vs inactive menu items
    const activeClass = "flex items-center gap-3 px-4 py-3 rounded-2xl bg-gradient-to-r from-pink-500 to-fuchsia-500 text-white shadow-lg font-semibold";
    const inactiveClass = "flex items-center gap-3 px-4 py-3 rounded-2xl text-gray-600 hover:bg-pink-50 transition font-medium";

    this.innerHTML = `
      <aside class="fixed left-0 top-0 h-full w-72 glass border-r border-pink-100 z-20 bg-white/80 backdrop-blur-md">
        <div class="p-6 border-b border-pink-100 flex items-center gap-3">
          <!-- Brand/logo area -->
          <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-pink-500 to-fuchsia-500 flex items-center justify-center text-white font-bold text-xl shadow-lg">S</div>
          <div>
            <h1 class="text-xl font-extrabold text-gray-900">StoreManager</h1>
            <p class="text-sm text-pink-500 font-medium">Premium Dashboard</p>
          </div>
        </div>

        <!-- Navigation links -->
        <nav class="p-4 space-y-2">
          <!-- Categories Link (index.html) -->
          <a href="./index.html" class="${isCategories ? activeClass : inactiveClass}">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V7a2 2 0 00-2-2h-3V3H9v2H6a2 2 0 00-2 2v6m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0H4"/>
            </svg>
            Categories
          </a>

          <!-- Products Link (products.html) -->
          <a href="./products.html" class="${isProducts ? activeClass : inactiveClass}">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
            </svg>
            Products
          </a>
        </nav>

        <!-- Logout button -->
        <div class="absolute bottom-6 left-0 w-full px-4">
          <button id="sidebar-logout-btn" class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-red-500 hover:bg-red-50 transition font-semibold">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
            </svg>
            Logout
          </button>
        </div>
      </aside>
    `;

    // Wire up the logout button
    this.querySelector('#sidebar-logout-btn').addEventListener('click', () => {
      localStorage.removeItem('auth_token');
      localStorage.removeItem('auth_user');
      localStorage.removeItem('auth_expires_at');
      sessionStorage.removeItem('auth_token');
      sessionStorage.removeItem('auth_user');
      sessionStorage.removeItem('auth_expires_at');
      window.location.href = './login.html';
    });
  }
}

// Register the web component
customElements.define('app-sidebar', AppSidebar);