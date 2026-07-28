// js/api.js
// Small, reusable API helper for making JSON requests to the backend.
// Exported so other modules/pages can import and reuse the same logic.
export const API_BASE = 'http://127.0.0.1:8000/api';

// apiCall - perform a fetch request and parse JSON, throwing a helpful
// Error when the server responds with a non-2xx status. If the backend
// returns validation errors in `errors` we attach them to the thrown Error
// under `err.fieldErrors` so callers can surface field-level messages.
export async function apiCall(endpoint, method = 'GET', payload = null) {
  const options = { method, headers: { 'Accept': 'application/json' } };
  if (payload) {
    options.headers['Content-Type'] = 'application/json';
    options.body = JSON.stringify(payload);
  }

  const res = await fetch(`${API_BASE}${endpoint}`, options);
  // Try to parse JSON, but fall back to an empty object if the body is empty
  const json = await res.json().catch(() => ({}));

  if (!res.ok) {
    const err = new Error(json.message || 'Request failed');
    err.fieldErrors = json.errors || null;
    throw err;
  }
  return json;
}

// Small utility to escape user-provided text before inserting into HTML
export const escapeHtml = str => String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');