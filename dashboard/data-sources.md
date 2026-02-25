---
title: "Data Sources"
description: "Endpoints for listing and viewing data sources and testing document search."
sidebar_position: 11
---

# Data Sources

Endpoints for listing and viewing data sources, plus a search test endpoint for testing document retrieval against a chatbot's knowledge base.

## Endpoints

### `GET /api/dashboard/data-sources`

Lists all parent data sources for the authenticated user's chatbots, ordered by creation date descending. Also returns chatbot list, CMS providers, and aggregated extra tag configuration.

**Response:**

```json
{
  "success": true,
  "data": {
    "dataSources": [
      {
        "id": "a1b2c3d4-...",
        "name": "Product Catalog",
        "type": "file",
        "subtype": "csv",
        "status": "completed",
        "source": "products.csv",
        "documentCount": 150,
        "productCount": 150,
        "childrenCount": 3,
        "autoUpdate": false,
        "chatbotId": "550e8400-...",
        "chatbotName": "My Store Bot",
        "createdAt": "2026-01-15 10:30",
        "updatedAt": "2 hours ago"
      }
    ],
    "chatbots": [
      {
        "id": "550e8400-...",
        "name": "My Store Bot"
      }
    ],
    "cmsProviders": ["shoptet"],
    "extraTagConfig": {
      "550e8400-...": {
        "name": "static_category",
        "values": ["shoes", "clothing", "accessories"]
      }
    }
  }
}
```

**Data source list fields:**

| Field | Type | Description |
|---|---|---|
| `id` | `uuid` | Data source identifier |
| `name` | `string` | Data source name |
| `type` | `string` | Type (e.g. `"file"`, `"url"`, `"text"`, `"crawl"`) |
| `subtype` | `string\|null` | Subtype (e.g. `"csv"`, `"pdf"`, `"sitemap"`) |
| `status` | `string` | Processing status (e.g. `"completed"`, `"processing"`, `"failed"`) |
| `source` | `string\|null` | Original source (filename, URL, etc.) |
| `documentCount` | `integer\|null` | Number of documents/chunks |
| `productCount` | `integer\|null` | Number of products (for product catalogs) |
| `childrenCount` | `integer` | Number of child data sources |
| `autoUpdate` | `boolean\|null` | Whether auto-update is enabled |
| `chatbotId` | `uuid` | Associated chatbot ID |
| `chatbotName` | `string` | Associated chatbot name |
| `createdAt` | `string` | Creation date (`Y-m-d H:i` format) |
| `updatedAt` | `string` | Human-readable time since last update |

**Extra tag config:**

Per-chatbot aggregation of extra tag names and values across all data sources. Used to populate filter dropdowns.

| Field | Type | Description |
|---|---|---|
| `name` | `string` | Tag name (defaults to `"static_category"`) |
| `values` | `string[]` | All unique tag values across data sources for this chatbot |

**CMS providers:**

Array of available CMS provider names for your account (e.g. `["shoptet"]`). Empty array if no CMS is connected.

---

### `GET /api/dashboard/data-sources/{id}`

Returns a single data source with document chunks, raw content preview, and child data sources. The data source must belong to your account.

**Path parameters:**

| Parameter | Type | Description |
|---|---|---|
| `id` | `uuid` | Data source identifier |

**Response:**

```json
{
  "success": true,
  "data": {
    "dataSource": {
      "id": "a1b2c3d4-...",
      "name": "Product Catalog",
      "type": "file",
      "subtype": "csv",
      "status": "completed",
      "source": "products.csv",
      "rawPath": "data-sources/abc123/products.csv",
      "documentCount": 150,
      "productCount": 150,
      "childrenCount": 3,
      "autoUpdate": false,
      "simpleFetch": false,
      "extraTags": [
        { "name": "category", "value": "shoes" }
      ],
      "chatbotId": "550e8400-...",
      "chatbotName": "My Store Bot",
      "createdAt": "2026-01-15 10:30:00",
      "updatedAt": "2026-01-15 12:45:00",
      "settings": {}
    },
    "chunks": [
      {
        "id": "chunk-uuid-...",
        "index": 0,
        "content": "Product description text...",
        "tokenCount": 256,
        "hasEmbedding": true
      }
    ],
    "rawContent": "Raw file content preview (max 50KB)...",
    "children": [
      {
        "id": "child-uuid-...",
        "name": "Page 1",
        "source": "https://example.com/page1",
        "status": "completed",
        "documentCount": 5,
        "createdAt": "2026-01-15 10:35"
      }
    ]
  }
}
```

**Data source detail fields:**

All fields from the list endpoint, plus:

| Field | Type | Description |
|---|---|---|
| `rawPath` | `string\|null` | Storage path for raw content |
| `simpleFetch` | `boolean\|null` | Whether simple fetch mode is enabled |
| `extraTags` | `array\|null` | Extra tag configuration (`[{name, value}]`) |
| `createdAt` | `string` | Creation timestamp (`Y-m-d H:i:s` format) |
| `updatedAt` | `string` | Last update timestamp (`Y-m-d H:i:s` format) |
| `settings` | `object\|null` | Data source settings JSON |

**Chunk fields:**

| Field | Type | Description |
|---|---|---|
| `id` | `uuid` | Chunk identifier |
| `index` | `integer` | Chunk index (ordered) |
| `content` | `string` | Chunk text content |
| `tokenCount` | `integer\|null` | Token count for this chunk |
| `hasEmbedding` | `boolean` | Whether an embedding vector exists |

**Children fields:**

| Field | Type | Description |
|---|---|---|
| `id` | `uuid` | Child data source identifier |
| `name` | `string` | Child name |
| `source` | `string\|null` | Child source (URL, filename, etc.) |
| `status` | `string` | Processing status |
| `documentCount` | `integer\|null` | Number of documents |
| `createdAt` | `string` | Creation date (`Y-m-d H:i` format) |

**Raw content:** Truncated at 50KB with a note showing total character count. Returns `null` if no raw content exists or download fails.

---

### `POST /app/data-sources/search-test`

Tests document search against a chatbot's knowledge base. Web-only route (not available via API key auth).

**Request parameters:**

| Parameter | Type | Required | Default | Constraints | Description |
|---|---|---|---|---|---|
| `chatbot_id` | `uuid` | yes | - | valid UUID | Chatbot whose knowledge base to search |
| `query` | `string` | yes | - | max 5000 | Search query text |
| `document_count` | `integer` | no | `10` | 1-50 | Max documents to return |

**Authorization:** The chatbot must belong to your account.

**Response:**

Same format as `POST /api/get-docs` (see [Document Search](../document-search.md)):

```json
{
  "docs": [
    {
      "content": "Document text or structured object",
      "name": "Product Name",
      "score": 0.95,
      "origin": "Pinecone",
      "filters": [],
      "search_position": 0
    }
  ],
  "summary": ""
}
```

**Error responses:**

| Status | Description |
|---|---|
| 401 | Unauthorized |
| 404 | Chatbot not found or doesn't belong to your account |
| 422 | Validation error (missing/invalid parameters) |
| 500 | Search failed |
