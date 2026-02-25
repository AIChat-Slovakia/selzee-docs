---
title: "Analytics Stats"
description: "Endpoints for querying aggregated analytics data, funnels, and AI conversation insights."
sidebar_position: 21
---

# Analytics Stats

Endpoints for querying aggregated analytics data. Provides user engagement funnels, popup performance, purchase/revenue metrics with A/B testing, overview stats, and AI-powered conversation insights.

## Common request parameters

Used by overview, engagement, popup-metrics, and purchases endpoints:

| Parameter | Type | Required | Default | Constraints | Description |
|---|---|---|---|---|---|
| `chatbot_id` | `string` | yes | - | max 255 | Chatbot identifier |
| `timeframe` | `integer` | no | `7` | 1-365 | Number of days to look back |

All time-based queries use: `start_date = now() - timeframe days`, `end_date = now()`.

## Endpoints

### `GET /api/dashboard/analytics/stats/overview`

High-level conversation statistics.

**Response:**

```json
{
  "timeframe_days": 7,
  "start_date": "2026-02-17",
  "end_date": "2026-02-24",
  "total_conversations": 150,
  "total_ai_messages": 500,
  "saved_hours": "25.5"
}
```

| Field | Type | Description |
|---|---|---|
| `total_conversations` | `int` | Conversations with activity in the timeframe |
| `total_ai_messages` | `int` | Automated assistant messages in the timeframe |
| `saved_hours` | `string` | Sum of conversation durations, capped at 1.5h per conversation |

---

### `GET /api/dashboard/analytics/stats/engagement`

Visitor funnel: visitors -> approached (popup shown) -> opened (widget opened) -> chatted (conversation started).

**Response:**

```json
{
  "timeframe_days": 7,
  "start_date": "2026-02-17",
  "end_date": "2026-02-24",
  "total_users": 1250,
  "total_users_approached": 1050,
  "total_users_opened": 950,
  "total_users_chatted": 800,
  "approached_ratio": 84.0,
  "opened_ratio": 76.0,
  "chatted_ratio": 64.0
}
```

| Field | Type | Description |
|---|---|---|
| `total_users` | `int` | Distinct user tokens with `visitor` event |
| `total_users_approached` | `int` | Visitors who were also shown a popup |
| `total_users_opened` | `int` | Visitors who also opened the chat widget |
| `total_users_chatted` | `int` | Visitors who also started a conversation |
| `*_ratio` | `float` | Percentage of `total_users`, rounded to 2 decimals |

---

### `GET /api/dashboard/analytics/stats/popup-metrics`

Popup performance grouped by version, plus conversation source breakdown.

**Response:**

```json
{
  "timeframe_days": 7,
  "start_date": "2026-02-17",
  "end_date": "2026-02-24",
  "metrics": [
    {
      "popup_version": "v1",
      "popup_displayed_count": 1000,
      "popup_opened_count": 250,
      "open_rate": 25.0
    },
    {
      "popup_version": "v2",
      "popup_displayed_count": 800,
      "popup_opened_count": 300,
      "open_rate": 37.5
    }
  ],
  "conversations": {
    "total": 450,
    "from_popup": 300,
    "from_chat_button": 150,
    "popup_ratio": 66.67
  }
}
```

| Field | Type | Description |
|---|---|---|
| `metrics` | `array` | Popup stats grouped by popup version |
| `metrics[].popup_displayed_count` | `int` | Times this popup version was shown |
| `metrics[].popup_opened_count` | `int` | Times this popup version was opened |
| `metrics[].open_rate` | `float` | `(opened / displayed) * 100`, rounded to 2 decimals |
| `conversations.total` | `int` | Total `convo_started` events |
| `conversations.from_popup` | `int` | Conversations started via popup |
| `conversations.from_chat_button` | `int` | Conversations started via chat button |
| `conversations.popup_ratio` | `float` | `(from_popup / total) * 100` |

Popup versions sorted alphabetically. Unknown versions grouped as `"unknown"`.

---

### `GET /api/dashboard/analytics/stats/purchases`

Purchase and revenue metrics, with chat vs. no-chat comparison. Optionally includes A/B test breakdown.

**Response (without A/B test):**

```json
{
  "timeframe_days": 7,
  "start_date": "2026-02-17",
  "end_date": "2026-02-24",
  "total_users": 500,
  "total_users_chatted": 200,
  "total_users_purchased": 100,
  "total_users_chatted_purchased": 80,
  "total_revenue_purchased": 25000.00,
  "total_revenue_chatted_purchased": 20000.00,
  "conversion_rate_with_chat": 40.0,
  "conversion_rate_without_chat": 4.0,
  "aov_with_chat": 250.0,
  "aov_without_chat": 250.0
}
```

| Field | Type | Description |
|---|---|---|
| `total_users` | `int` | Distinct visitors |
| `total_users_chatted` | `int` | Visitors who started a conversation |
| `total_users_purchased` | `int` | Visitors who made a purchase |
| `total_users_chatted_purchased` | `int` | Visitors who chatted AND purchased (purchase after chat) |
| `total_revenue_purchased` | `float` | Total purchase revenue (base currency EUR) |
| `total_revenue_chatted_purchased` | `float` | Revenue from users who chatted before purchasing |
| `conversion_rate_with_chat` | `float` | `(chatted_purchased / chatted) * 100` |
| `conversion_rate_without_chat` | `float` | `(purchased_without_chat / total_users) * 100` |
| `aov_with_chat` | `float` | Average order value for chat users |
| `aov_without_chat` | `float` | Average order value for non-chat users |

**"Purchase after chat" logic:**
1. Find earliest conversation start event per user
2. Count purchase events occurring after that time
3. Only purchases after the user's first chat count as "chatted_purchased"

**Purchase deduplication:** Duplicate order numbers are skipped. Only the first event per order is counted.

**Revenue:** Uses EUR-converted values for cross-currency aggregation.

**Response with A/B test** (when A/B testing is enabled for the chatbot):

```json
{
  "...": "same fields as above",
  "ab_test": {
    "control": {
      "visitors": 250,
      "orders": 50,
      "conversion_rate": 8.0,
      "aov": 250.0,
      "arpu": 50.0
    },
    "test": {
      "visitors": 250,
      "orders": 60,
      "conversion_rate": 10.0,
      "aov": 260.0,
      "arpu": 62.4
    }
  }
}
```

| Field | Type | Description |
|---|---|---|
| `ab_test.*.visitors` | `int` | Visitors in this group |
| `ab_test.*.orders` | `int` | Purchase events in this group |
| `ab_test.*.conversion_rate` | `float` | `(unique_customers / visitors) * 100` |
| `ab_test.*.aov` | `float` | Average order value: `revenue / orders` |
| `ab_test.*.arpu` | `float` | Average revenue per user: `revenue / visitors` |

Group assignment is derived from the user token's last character (see [Event Tracking](./event-tracking.md#user-token)).

---

### `GET /api/dashboard/analytics/stats/conversation-insights`

AI-powered conversation analysis report. Aggregates structured analysis data from analyzed conversations.

**Request parameters** (different from other endpoints):

| Parameter | Type | Required | Constraints | Description |
|---|---|---|---|---|
| `chatbot_id` | `string` | yes | max 255 | Chatbot identifier |
| `timeframe` | `string` | yes | max 50 | Flexible timeframe (see below) |

**Timeframe formats:**

| Format | Example | Result |
|---|---|---|
| Shortcut | `day`, `week`, `month` | 1, 7, 30 days ago |
| Flexible | `20 minutes`, `2 hours`, `3 days`, `1 week`, `2 months` | Parsed duration |
| Month name | `january`, `february`, ... `december` | Start of that month (current year) |
| Integer | `14` | 14 days ago |

**Response:**

```json
{
  "most_clicked_products": [
    {
      "item": "https://example.com/product/123",
      "count": 45,
      "conversations": [
        "https://app.selzee.com/app/{chatbot_id}/conversations/{conv_id}"
      ]
    }
  ],
  "most_talked_about_products": [
    { "item": "Nike Air Max 90", "count": 30, "conversations": ["..."] }
  ],
  "most_frequent_intents": [
    { "item": "Product availability question", "count": 25, "conversations": ["..."] }
  ],
  "most_common_complaints": [
    { "item": "Shipping delays", "count": 8, "conversations": ["..."] }
  ],
  "mood_percentages": {
    "happy": 65.5,
    "angry": 10.2,
    "neutral": 24.3
  },
  "outcome_percentages": {
    "success": 75.0,
    "fail": 10.0,
    "neutral": 15.0
  },
  "human_intervention_needed_percentage": 12.5,
  "missing_information_overview": [
    { "item": "Product availability in size L", "count": 8, "conversations": ["..."] }
  ],
  "total_conversations_analyzed": 100,
  "total_click_throughs": 145,
  "chat_conversion": {
    "ratio": 35.0,
    "total_conversions": 35,
    "total_conversations": 100
  },
  "reactions": {
    "likes": 200,
    "dislikes": 15
  },
  "average_conversation_duration_minutes": 3.5
}
```

| Field | Type | Description |
|---|---|---|
| `most_clicked_products` | `ranked[]` | Products most clicked by users |
| `most_talked_about_products` | `ranked[]` | Products most discussed in conversations |
| `most_frequent_intents` | `ranked[]` | Most common user intents |
| `most_common_complaints` | `ranked[]` | Most common user complaints |
| `mood_percentages` | `{happy, angry, neutral}` | Distribution of user mood |
| `outcome_percentages` | `{success, fail, neutral}` | Distribution of conversation outcomes |
| `human_intervention_needed_percentage` | `float` | Percentage of conversations needing human help |
| `missing_information_overview` | `ranked[]` | Knowledge gaps identified by the AI |
| `total_conversations_analyzed` | `int` | Count of conversations included in the report |
| `total_click_throughs` | `int` | Total product link clicks |
| `chat_conversion` | `object` | Conversion rate from conversations |
| `reactions` | `{likes, dislikes}` | Message reaction counts |
| `average_conversation_duration_minutes` | `float` | Average duration (capped at 60 min per conversation) |

**Ranked item format:** `{ item: string, count: int, conversations: string[] }` — sorted by count descending, with links to each relevant conversation.

**Limits:** Max 100 conversations per report.

## Error handling

| Status | Description |
|---|---|
| 401 | Unauthorized (invalid/missing API key or auth token) |
| 422 | Invalid timeframe format or missing parameters |
