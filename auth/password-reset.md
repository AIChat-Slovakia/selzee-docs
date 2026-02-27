---
title: "Password Reset"
description: "How the password reset flow works, from requesting a reset link to setting a new password."
sidebar_position: 20
---

# Password Reset

Users can reset their password via an email-based flow. Reset emails are delivered through the [Loops](https://loops.so) transactional email API.

## Flow overview

1. User submits their email on the forgot-password page
2. Server generates a reset token and dispatches an email via Loops
3. User clicks the reset link in the email
4. User enters a new password and submits
5. Password is updated and user is redirected to login

## Endpoints

### `POST /forgot-password`

Requests a password reset link. Returns the same success message regardless of whether the email exists (prevents email enumeration).

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

### `GET /reset-password/{token}`

Renders the password reset form. The token is passed as a URL parameter and the email as a query string.

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

**Success:** Redirects to `/login` with a success message.

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
| `app/Domain/Auth/Controllers/PasswordResetController.php` | Controller with `sendResetLink`, `showResetForm`, `reset` methods |
| `app/Domain/Auth/Actions/SendPasswordResetLink.php` | Generates token and dispatches email job |
| `app/Jobs/SendLoopsEmailJob.php` | Queued job for Loops API call |
| `app/Shared/Services/Loops/LoopsService.php` | Loops HTTP client (`sendTransactionalEmail`) |
| `resources/js/Pages/Auth/ForgotPassword.vue` | Forgot password form |
| `resources/js/Pages/Auth/ResetPassword.vue` | Reset password form |
| `config/auth.php` | Token expiry and throttle settings |
