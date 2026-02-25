---
title: "Document Search"
description: "RAG pipeline endpoint for retrieving documents from a chatbot's knowledge base."
sidebar_position: 30
---

# Document Search

Retrieves contextually relevant documents from a chatbot's knowledge base using semantic search, keyword search, and hybrid search with AI-powered query optimization and relevance reranking.

## API endpoint

### `POST /api/get-docs`

**Rate limiting:** 30 requests/minute

### Request parameters

| Parameter | Type | Required | Default | Constraints | Description |
|---|---|---|---|---|---|
| `chatbot_id` | `uuid` | yes | - | valid UUID | The chatbot to search for |
| `conversation_id` | `string` | no | `""` | max 255 | Current conversation ID for summary lookup |
| `query` | `string` | no | `""` | max 5000 | Direct search query (overrides chat_history for search) |
| `chat_history` | `array` | no | `[]` | max 50 items | Chat messages for context |
| `chat_history.*.role` | `string` | yes (if chat_history) | - | `user`, `assistant`, `system` | Message role |
| `chat_history.*.content` | `string` | yes (if chat_history) | - | max 10000 | Message content |
| `language` | `string` | no | `en` | `en`, `cs`, `sk`, `de`, `pl`, `hu` | Language for query generation |
| `frontend_context` | `array` | no | `[]` | - | Context about the page the user is viewing |
| `user_context` | `array` | no | `[]` | - | User-specific context (e.g. preferences, profile) |
| `additional_context` | `array` | no | `[]` | - | Extra context for query generation |
| `user_activity` | `array` | no | `[]` | - | User activity on the website |
| `filters` | `array` | no | `[]` | - | Pre-set filters to apply (array of `{name, value, operator}`) |
| `additional_db_context` | `string` | no | `""` | max 5000 | Additional database context for query generation |
| `original_question` | `string` | no | `""` | max 5000 | The user's original question (used for reranking) |
| `extra_tags` | `array` | no | `[]` | max 20 items, each max 100 chars | Additional filter tags |
| `document_count` | `integer` | no | `10` | min 1, max 50 | Max documents to return |

### Request example

```json
{
  "chatbot_id": "550e8400-e29b-41d4-a716-446655440000",
  "conversation_id": "conv_abc123",
  "query": "red running shoes under 100 euros",
  "chat_history": [
    { "role": "user", "content": "I'm looking for running shoes" },
    { "role": "assistant", "content": "Sure! What's your budget?" },
    { "role": "user", "content": "Under 100 euros, preferably red" }
  ],
  "language": "en",
  "frontend_context": { "current_page": "/category/shoes" },
  "user_context": { "shoe_size": "42" },
  "filters": [
    { "name": "color", "value": "red", "operator": "=" }
  ],
  "document_count": 10
}
```

### Response

```json
{
  "docs": [
    {
      "content": "string or object",
      "name": "Product Name or null",
      "score": 0.95,
      "origin": "Pinecone",
      "filters": [
        { "name": "color", "value": "red", "operator": "=", "type": "metadata" }
      ],
      "search_position": 0
    }
  ],
  "summary": "User is looking for red running shoes under 100 euros"
}
```

**Response fields:**

| Field | Type | Description |
|---|---|---|
| `docs` | `SearchDocument[]` | Ranked array of matching documents |
| `docs[].content` | `string\|object` | Document content (string for raw text, object for structured data like products) |
| `docs[].name` | `string\|null` | Document/data source name |
| `docs[].score` | `float\|null` | Relevance score from the search engine |
| `docs[].origin` | `string` | Source: `Pinecone`, `Meilisearch`, `Carbon Matched`, or `Unknown` |
| `docs[].filters` | `array` | Filters that were applied to this search |
| `docs[].search_position` | `int\|null` | Which search type produced this result |
| `summary` | `string` | Short conversation summary |

## Filter operators

| Operator | Description |
|---|---|
| `=` | Equals |
| `!=` | Not equals |
| `>` | Greater than |
| `>=` | Greater than or equal |
| `<` | Less than |
| `<=` | Less than or equal |
| `in` | In array |
| `not in` | Not in array |

## Error responses

| Status | Code | Description |
|---|---|---|
| 404 | `DOCSEARCH_001` | Chatbot not found |
| 422 | - | Validation error (invalid params) |
| 429 | - | Rate limit exceeded (30/min) |
