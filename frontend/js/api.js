// js/api.js
export const API_BASE = 'http://127.0.0.1:8000/api';

export async function apiCall(endpoint, method = 'GET', payload = null) {
  const options = { method, headers: { 'Accept': 'application/json' } };
  if (payload) {
    options.headers['Content-Type'] = 'application/json';
    options.body = JSON.stringify(payload);
  }
  const res = await fetch(`${API_BASE}${endpoint}`, options);
  const json = await res.json().catch(() => ({}));

  if (!res.ok) {
    const err = new Error(json.message || 'Request failed');
    err.fieldErrors = json.errors || null;
    throw err;
  }
  return json;
}

export const escapeHtml = str => String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');