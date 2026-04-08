---
title: "Password Reset"
description: "How the password reset flow works, from requesting a reset link to setting a new password."
sidebar_position: 20
---

# Password Reset

Users can reset their password via an email-based flow. Reset emails are delivered through the [Loops](https://loops.so) transactional email API.

There are two ways to initiate a password reset:

1. **Not logged in** — from the login page via "Forgot password?"
2. **Logged in** — from the dashboard profile settings via "Forgot password? Send reset link"

## Option 1: Not logged in

Use this when you can't remember your password and need to sign in.

### Flow

1. Click "Forgot password?" on the login page
2. Enter your email address and submit
3. Check your email for a reset link
4. Click the link and set a new password
5. You are redirected to the login page

### Endpoint: `POST /forgot-password`

Requests a password reset link. Returns the same success message regardless of whether the email exists (prevents email enumeration).

**Middleware:** `guest` (only accessible when not logged in)

**Rate limit:** 5 requests per minute. Additionally, only one token can be generated per email address every 60 seconds.

**Request body:**

| Field | Type | Required | Description |
|---|---|---|---|
| `email` | `string` | Yes | User's email address |

**Response:** Redirects back with a status message.

```
"If an account with that email exists, we've sent a password reset link."
```

---

## Option 2: Logged in (from dashboard)

Use this when you are already signed in and want to reset your password from your profile settings.

### Flow

1. Go to **Settings → Profile** in the dashboard
2. Scroll to the **Password** section
3. Click "Forgot password? Send reset link"
4. Check your email for a reset link
5. Click the link and set a new password
6. You are redirected back to your profile settings

### Endpoint: `POST /app/send-password-reset`

Sends a password reset link to the authenticated user's email. No email input is needed — it uses the email from the current session.

**Middleware:** `auth` (must be logged in)

**Rate limit:** 5 requests per minute.

**Request body:** None.

**Response:** Redirects back with a status message.

```
"Password reset link has been sent to your email."
```

---

## Shared endpoints

### `GET /reset-password/{token}`

Renders the password reset form. Accessible by both guests and authenticated users.

**Parameters:**

| Parameter | Location | Type | Description |
|---|---|---|---|
| `token` | path | `string` | Reset token from the email link |
| `email` | query | `string` | User's email address |

---

### `POST /reset-password`

Submits the new password. Validates the token, updates the password, and invalidates existing sessions.

**Rate limit:** 10 requests per minute.

**Request body:**

| Field | Type | Required | Description |
|---|---|---|---|
| `token` | `string` | Yes | Reset token from the email |
| `email` | `string` | Yes | User's email address |
| `password` | `string` | Yes | New password |
| `password_confirmation` | `string` | Yes | Must match `password` |

**Success:**
- **Logged in:** Redirects to profile settings with a success message.
- **Not logged in:** Redirects to `/login` with a success message.

**Error responses:**

| Scenario | Behavior |
|---|---|
| Invalid or expired token | Redirects back with validation error |
| Token already used | Redirects back with validation error |
| Password confirmation mismatch | Redirects back with validation error |

## Token lifecycle

- Tokens are stored in the `password_reset_tokens` table (one per email)
- Tokens expire after **60 minutes** (configurable in `config/auth.php`)
- Tokens are single-use — deleted after a successful reset
- A new token cannot be requested within **60 seconds** of the previous one

## Email delivery

Reset emails are sent asynchronously via a queued job (`SendLoopsEmailJob`) that calls the Loops transactional email API.

- **Template ID:** `cmazfwf9s06n4yw0ipb9gn7hj`
- **Retries:** 3 attempts with 30-second backoff
- **Required config:** `LOOPS_API_KEY` must be set in `.env`

## Key files

| File | Purpose |
|---|---|
| `app/Domain/Auth/Controllers/PasswordResetController.php` | Controller with `sendResetLink`, `sendResetLinkAuthenticated`, `showResetForm`, `reset` methods |
| `app/Domain/Auth/Actions/SendPasswordResetLink.php` | Generates token and dispatches email job |
| `app/Jobs/SendLoopsEmailJob.php` | Queued job for Loops API call |
| `app/Shared/Services/Loops/LoopsService.php` | Loops HTTP client (`sendTransactionalEmail`) |
| `resources/js/Pages/Auth/ForgotPassword.vue` | Forgot password form (guest) |
| `resources/js/Pages/Auth/ResetPassword.vue` | Reset password form (shared) |
| `resources/js/Pages/Dashboard/Settings/Profile.vue` | Profile settings with reset link button (authenticated) |
| `config/auth.php` | Token expiry and throttle settings |
