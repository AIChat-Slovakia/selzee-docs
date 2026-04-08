---
title: "Chatbots"
description: "Endpoints for listing and viewing chatbot configurations."
sidebar_position: 10
---

# Chatbots

Endpoints for listing and viewing chatbot configurations. Returns chatbot metadata, conversation counts, and status information.

## Endpoints

### `GET /api/dashboard/chatbots`

Lists all chatbots belonging to the authenticated user, with conversation counts.

**Response:**

```json
{
  "success": true,
  "data": {
    "chatbots": [
      {
        "id": "550e8400-e29b-41d4-a716-446655440000",
        "name": "My Store Bot",
        "status": "active",
        "conversations": 42,
        "visitors": 0,
        "conversionRate": 0,
        "language": "en",
        "integratedAt": "2026-01-15",
        "lastActive": "2 hours ago"
      }
    ]
  }
}
```

**Response fields:**

| Field | Type | Description |
|---|---|---|
| `id` | `uuid` | Chatbot identifier |
| `name` | `string` | Chatbot name |
| `status` | `string` | `"active"` or `"paused"` |
| `conversations` | `integer` | Total conversation count |
| `visitors` | `integer` | Always `0` (visitor tracking not yet implemented) |
| `conversionRate` | `integer` | Always `0` (conversion tracking not yet implemented) |
| `language` | `string` | Chatbot language code (default `"en"`) |
| `integratedAt` | `string` | Integration date (formatted as `Y-m-d`) |
| `lastActive` | `string` | Human-readable time since last update (e.g. `"2 hours ago"`) |

---

### `GET /api/dashboard/chatbots/{id}`

Returns a single chatbot by ID. The chatbot must belong to the authenticated user.

**Path parameters:**

| Parameter | Type | Description |
|---|---|---|
| `id` | `uuid` | Chatbot identifier |

**Response:**

```json
{
  "success": true,
  "data": {
    "chatbot": {
      "id": "550e8400-e29b-41d4-a716-446655440000",
      "name": "My Store Bot",
      "status": "active",
      "conversations": 42,
      "visitors": 0,
      "conversionRate": 0,
      "language": "en",
      "integratedAt": "2026-01-15",
      "lastActive": "2 hours ago",
      "companyName": "Acme Corp",
      "supportEmail": "support@acme.com"
    }
  }
}
```

**Response fields:**

All fields from the list endpoint, plus:

| Field | Type | Description |
|---|---|---|
| `companyName` | `string\|null` | Company name from chatbot settings |
| `supportEmail` | `string\|null` | Support email from chatbot settings |

## Error responses

| Status | Description |
|---|---|
| 401 | Unauthorized (invalid/missing API key or auth token) |
| 404 | Chatbot not found or doesn't belong to the authenticated user |
