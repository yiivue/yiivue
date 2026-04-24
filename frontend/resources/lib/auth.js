const TOKEN_KEY = 'auth_token'
const USER_KEY = 'auth_user'
const EXPIRES_AT_KEY = 'auth_expires_at'
export const AUTH_CHANGE_EVENT = 'yiivue-auth-changed'

function dispatchAuthChange() {
  if (typeof window === 'undefined') {
    return
  }

  window.dispatchEvent(new CustomEvent(AUTH_CHANGE_EVENT))
}

function getStorage() {
  if (typeof window === 'undefined') {
    return null
  }

  return window.localStorage
}

function parseStoredJson(key) {
  const storage = getStorage()

  if (!storage) {
    return null
  }

  try {
    const value = storage.getItem(key)
    return value ? JSON.parse(value) : null
  } catch {
    storage.removeItem(key)
    return null
  }
}

async function parseResponse(response) {
  const contentType = response.headers.get('content-type') || ''

  if (contentType.includes('application/json')) {
    return response.json()
  }

  const text = await response.text()

  return text ? { message: text } : null
}

export function getApiBaseUrl() {
  const configuredBaseUrl = (import.meta.env.VITE_API_BASE_URL || '').trim()

  if (configuredBaseUrl) {
    return configuredBaseUrl.replace(/\/+$/, '')
  }

  if (typeof window === 'undefined') {
    return ''
  }

  return window.location.origin.replace(/\/+$/, '')
}

export function getAuthToken() {
  const storage = getStorage()

  if (!storage) {
    return ''
  }

  return storage.getItem(TOKEN_KEY) || ''
}

export function getStoredUser() {
  return parseStoredJson(USER_KEY)
}

export function setAuthSession(payload) {
  const storage = getStorage()

  if (!storage || !payload?.access_token) {
    return
  }

  storage.setItem(TOKEN_KEY, payload.access_token)

  if (payload.user) {
    storage.setItem(USER_KEY, JSON.stringify(payload.user))
  }

  if (Number.isFinite(payload.expires_in)) {
    storage.setItem(
      EXPIRES_AT_KEY,
      String(Date.now() + (payload.expires_in * 1000))
    )
  }

  dispatchAuthChange()
}

export function clearAuthSession() {
  const storage = getStorage()

  if (!storage) {
    return
  }

  storage.removeItem(TOKEN_KEY)
  storage.removeItem(USER_KEY)
  storage.removeItem(EXPIRES_AT_KEY)
  dispatchAuthChange()
}

export function isAuthenticated() {
  const token = getAuthToken()

  if (!token) {
    return false
  }

  const storage = getStorage()
  const expiresAt = Number(storage?.getItem(EXPIRES_AT_KEY) || 0)

  if (Number.isFinite(expiresAt) && expiresAt > 0 && Date.now() >= expiresAt) {
    clearAuthSession()
    return false
  }

  return true
}

export function getAuthHeaders(headers = {}) {
  const token = getAuthToken()

  if (!token) {
    return headers
  }

  return {
    ...headers,
    Authorization: `Bearer ${token}`,
  }
}

export async function apiRequest(path, options = {}) {
  const headers = new Headers(options.headers || {})

  if (!headers.has('Accept')) {
    headers.set('Accept', 'application/json')
  }

  if (options.body && !(options.body instanceof FormData) && !headers.has('Content-Type')) {
    headers.set('Content-Type', 'application/json')
  }

  const response = await fetch(`${getApiBaseUrl()}${path}`, {
    ...options,
    headers,
  })

  const payload = await parseResponse(response)

  if (!response.ok) {
    throw new Error(payload?.message || `Request failed with status ${response.status}.`)
  }

  return payload
}

export function login(payload) {
  return apiRequest('/api/auth/login', {
    method: 'POST',
    body: JSON.stringify(payload),
  })
}

export function register(payload) {
  return apiRequest('/api/auth/register', {
    method: 'POST',
    body: JSON.stringify(payload),
  })
}

export function logout() {
  return apiRequest('/api/auth/logout', {
    method: 'POST',
    headers: getAuthHeaders(),
  })
}
