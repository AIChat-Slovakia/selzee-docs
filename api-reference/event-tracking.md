---
title: "Event Tracking"
description: "Record user interactions with the chatbot widget for analytics."
sidebar_position: 20
---

# Event Tracking

Records user interactions with the chatbot widget. Supports e-commerce tracking (cart, purchases), A/B testing, and visitor funnel analysis.

## API endpoints

All tracking endpoints are public (no JWT required), behind origin validation only.

### `POST /api/analytics/track`

Primary tracking endpoint. Also available as:
- `POST /api/events/track` (alias)
- `POST /api/save` (legacy alias)
- `GET /api/analytics/track` (legacy GET format)
- `GET /api/events/track` (legacy GET format)

**Rate limiting:** 120 requests/minute per IP

### Request (POST format)

```json
{
  "event": "purchase",
  "token": "user_abc123def456",
  "data": {
    "chatbot_id": "550e8400-e29b-41d4-a716-446655440000",
    "items": [
      {
        "item_id": "SKU-123",
        "value": 49.99,
        "quantity": 2,
        "currency": "EUR"
      }
    ],
    "orderNum": "ORD-2024-001",
    "popup_version": "v2",
    "open_way": "popup"
  },
  "ab_test": true
}
```

### Request (GET format, legacy)

```
GET /api/analytics/track?e=purchase&u=user_abc123def456&d=%7B%22chatbot_id%22%3A%22...%22%7D
```

| Param | Maps to |
|---|---|
| `e` | `event` |
| `u` | `token` |
| `d` | `data` (URL-encoded JSON) |

### Request parameters

| Parameter | Type | Required | Constraints | Description |
|---|---|---|---|---|
| `event` (or `e`) | `string` | yes | max 50, must be allowed type | Event type |
| `token` (or `u`) | `string` | yes | 8-128 chars, alphanumeric + `-_` | User token |
| `data` | `object` | no | - | Event payload |
| `data.chatbot_id` | `string` | no | max 512 | Chatbot identifier |
| `data.items` | `array` | no | max 50 items | Cart/purchase items |
| `data.items[].item_id` | `string` | no | max 128 (also accepts `id`) | Product identifier |
| `data.items[].value` | `numeric` | no | (also accepts `price`) | Item price |
| `data.items[].quantity` | `integer` | no | min 1, default 1 | Item quantity |
| `data.items[].currency` | `string` | no | max 3 chars (e.g. `EUR`) | ISO currency code |
| `data.orderNum` | `string` | no | max 512 | Order number (for purchase deduplication) |
| `data.popup_version` | `string` | no | - | Popup version identifier |
| `data.open_way` | `string` | no | `popup` or `chat_button` | How the conversation was started |
| `ab_test` | `boolean` | no | default `false` | Enable A/B test group assignment |

### Response

```json
{
  "success": true
}
```

### Error responses

| Status | Code | Description |
|---|---|---|
| 400 | `ANALYTICS_001` | Invalid event payload (malformed JSON, invalid data) |
| 400 | `ANALYTICS_002` | Payload too large (> 50 KB) |
| 422 | - | Validation error (missing event/token, invalid type, bad format) |
| 429 | - | Rate limit exceeded (120/min) |

## Event types

| Event | Purpose | Key data fields |
|---|---|---|
| `visitor` | User visits page with chatbot | `chatbot_id` |
| `popup_displayed` | Popup shown to user | `popup_version` |
| `popup_opened` | User clicks/opens popup | `popup_version` |
| `bot_open` | Chat widget opened | `chatbot_id` |
| `convo_started` | Conversation initiated | `open_way` (`popup` or `chat_button`) |
| `message_sent` | User sends a message | `chatbot_id` |
| `message_like` | User likes an AI response | `chatbot_id` |
| `message_dislike` | User dislikes an AI response | `chatbot_id` |
| `click_through` | User clicks a product link | `chatbot_id` |
| `added_to_cart` | Product added to cart | `items` |
| `go_to_cart` | User navigates to cart | `chatbot_id` |
| `purchase` | Transaction completed | `items`, `orderNum` |
| `error` | Client-side error | Error details |

**Normalization:** `tracktrans` is normalized to `purchase` (legacy alias).

## Data constraints

| Constraint | Value |
|---|---|
| Max payload size | 50,000 bytes (JSON encoded) |
| Max items per event | 50 |
| Max item_id length | 128 chars |
| Max orderNum / chatbot_id | 512 chars |
| Max URL length | 2,048 chars |
| Max user_agent length | 1,024 chars |
| User token format | 8-128 chars, `[A-Za-z0-9_-]+` |

## User token

- Generated client-side (8-128 chars, alphanumeric + `-_`)
- Used as the primary user identifier across all events
- Last character determines A/B test group (when enabled):
  - `'0'` -> `control`
  - `'1'` -> `test`
  - other -> `null` (not assigned)

## Currency conversion

Purchase values are converted to EUR (base currency) for cross-currency aggregation.

**Supported currencies and static rates (to EUR):**

| Currency | Rate | Currency | Rate |
|---|---|---|---|
| EUR | 1.0 | CHF | 1.05 |
| USD | 0.92 | DKK | 0.134 |
| GBP | 1.17 | SEK | 0.088 |
| CZK | 0.041 | NOK | 0.086 |
| PLN | 0.23 | BGN | 0.51 |
| RON | 0.20 | HRK | 0.133 |
| HUF | 0.0026 | RSD | 0.0085 |
| UAH | 0.024 | | |

Unknown currencies are logged as warnings and `total_value_base` is set to `null`.
