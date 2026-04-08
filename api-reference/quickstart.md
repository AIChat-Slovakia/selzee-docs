---
title: "Quickstart"
description: "How to authenticate and call the Selzee dashboard API using an API key."
sidebar_position: 2
---

# Quickstart

How to authenticate and call the Selzee dashboard API using an API key.

## Authentication

All dashboard API endpoints accept **Bearer token** authentication via the `Authorization` header:

```
Authorization: Bearer {your-api-key}
```

API keys are scoped to a single chatbot. When you authenticate with an API key, all endpoints automatically filter data to that chatbot only.

## Base URL

```
https://selzee.com/api/dashboard
```

## First request

List your chatbot(s):

```bash
curl https://selzee.com/api/dashboard/chatbots \
  -H "Authorization: Bearer {your-api-key}" \
  -H "Accept: application/json"
```

Response:

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
        "language": "en"
      }
    ]
  }
}
```

The `Accept: application/json` header is required — without it, the server returns an HTML page instead of JSON.

## Available endpoints

### Chatbots

| Method | Endpoint | Description | Docs |
|---|---|---|---|
| `GET` | `/chatbots` | List chatbots | [Chatbots](./dashboard/chatbots.md) |
| `GET` | `/chatbots/{id}` | Show chatbot details | [Chatbots](./dashboard/chatbots.md) |

### Data Sources

| Method | Endpoint | Description | Docs |
|---|---|---|---|
| `GET` | `/data-sources` | List data sources | [Data Sources](./dashboard/data-sources.md) |
| `GET` | `/data-sources/{id}` | Show data source with chunks | [Data Sources](./dashboard/data-sources.md) |

### Analytics

| Method | Endpoint | Description | Docs |
|---|---|---|---|
| `GET` | `/analytics/stats/overview` | Conversation stats | [Analytics Stats](./analytics/analytics-stats.md) |
| `GET` | `/analytics/stats/engagement` | User engagement funnel | [Analytics Stats](./analytics/analytics-stats.md) |
| `GET` | `/analytics/stats/popup-metrics` | Popup performance | [Analytics Stats](./analytics/analytics-stats.md) |
| `GET` | `/analytics/stats/purchases` | Purchase & revenue metrics | [Analytics Stats](./analytics/analytics-stats.md) |
| `GET` | `/analytics/stats/conversation-insights` | AI conversation analysis | [Analytics Stats](./analytics/analytics-stats.md) |

All endpoints above are prefixed with `/api/dashboard`.

## Examples

### Get chatbot details

```bash
curl https://selzee.com/api/dashboard/chatbots/550e8400-e29b-41d4-a716-446655440000 \
  -H "Authorization: Bearer {your-api-key}" \
  -H "Accept: application/json"
```

### List data sources

```bash
curl https://selzee.com/api/dashboard/data-sources \
  -H "Authorization: Bearer {your-api-key}" \
  -H "Accept: application/json"
```

### Get analytics overview (last 30 days)

```bash
curl "https://selzee.com/api/dashboard/analytics/stats/overview?chatbot_id={id}&timeframe=30" \
  -H "Authorization: Bearer {your-api-key}" \
  -H "Accept: application/json"
```

Note: Analytics endpoints require a `chatbot_id` query parameter. When using API key auth, this is still required in the request but must match the chatbot associated with your key.

## Error responses

### 401 Unauthorized

```json
{
  "error": "Authentication failed",
  "details": "Invalid API key"
}
```

Causes: missing/invalid API key, key not associated with a chatbot.

### 404 Not Found

Resource doesn't exist or doesn't belong to the chatbot associated with your API key.

### 422 Validation Error

Request parameters failed validation. The response includes field-level error messages.
