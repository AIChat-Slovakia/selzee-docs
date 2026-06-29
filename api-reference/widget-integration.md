---
title: "Widget Integration"
description: "Open the Selzee chatbot and send a question from your own input field using the window.selzee browser API."
sidebar_position: 40
---

# Widget Integration

This guide explains how to add a custom text field with a button on your own page (e.g. a "Contact" page) where a customer types a question, submits it — and the Selzee chatbot opens automatically and asks that question right away (it appears as a user message, and the chatbot answers it).

This functionality is **already supported** by the chatbot and requires no changes on the Selzee side. You only need to call it from your frontend.

> This document is intended for the customer's developers who integrate the widget on their website.

## How it works

When the Selzee widget is loaded on the page, it exposes a global object `window.selzee` in the browser. It has a public method:

```js
window.selzee.toggleAndSend({ message: "question text" });
```

This method:

1. opens the chatbot window,
2. sends the given text as a user message,
3. the chatbot generates a response to the message — exactly as if the user had typed the question directly into the chatbot.

The widget is injected directly into your page's DOM (not into an iframe), so `window.selzee` is available directly, without `postMessage` or cross-origin communication.

## Prerequisite

The standard Selzee embed script must be installed on the page — the one you were given when the chatbot was deployed. It looks roughly like this (your chatbot ID will differ):

```html
<script id="aichat-script" type="text/javascript">
  let AICHAT_FE_SETTINGS = {
    id: "YOUR-CHATBOT-ID",
    version: "full",
    link_preview: "true",
    lang: "cs",
    allowed_sites: ["*"],
    exclude_paths: []
  };
  (function () {
    var d = document, s = d.createElement("script");
    s.src = `https://aichat.sk/api/get-aichatbot?id=${AICHAT_FE_SETTINGS.id}&language=${AICHAT_FE_SETTINGS.lang || ""}`;
    s.async = true;
    s.onload = function () { if (window.runAichat) window.runAichat(); };
    d.getElementsByTagName("head")[0].appendChild(s);
  })();
</script>
```

Without this script, `window.selzee` does not exist and the integration will not work.

## Important: the widget loads asynchronously

The embed script and the widget itself load in the background. At the moment your page renders, `window.selzee` (and its HTML elements) may not be ready yet.

For that reason, **do not call `toggleAndSend` immediately**. Call it only when the user submits a question, and check first that the widget is ready. You can detect readiness like this:

```js
function selzeeReady() {
  return !!(window.selzee && document.getElementById("chat_aichat"));
}
```

## Recommended helper function

This function safely waits until the widget is ready (max ~10 s), handles the case where the chat is already open, and then opens the chat and sends the question:

```js
function askSelzee(question, { timeoutMs = 10000, intervalMs = 150 } = {}) {
  const text = (question || "").trim();
  if (!text) return; // we don't send empty questions

  const start = Date.now();

  (function waitForWidget() {
    const ready = window.selzee && document.getElementById("chat_aichat");

    if (ready) {
      const chatEl = document.getElementById("chat_aichat");
      const isOpen = chatEl && chatEl.style.display === "flex";

      // toggleAndSend toggles the chat state. If it's already open, close it
      // first so the following call opens it again (instead of hiding it).
      if (isOpen) window.selzee.toggleChat();

      window.selzee.toggleAndSend({ message: text, openWay: "contact_form" });
      return;
    }

    if (Date.now() - start < timeoutMs) {
      setTimeout(waitForWidget, intervalMs);
    } else {
      console.error("Selzee widget did not load in time — the question was not sent.");
    }
  })();
}
```

The `openWay: "contact_form"` parameter is optional — it only serves to distinguish in analytics where the window was opened from. You can use any custom string.

## Complete example (field + button)

HTML matching an input field ("How can we help you?"):

```html
<form id="selzee-ask-form" class="selzee-ask">
  <label for="selzee-ask-input">How can we help you?</label>
  <input
    id="selzee-ask-input"
    type="text"
    placeholder="e.g. What is the status of my order?"
    autocomplete="off"
  />
  <button type="submit">Ask</button>
</form>
```

JavaScript (include the `askSelzee` function from the previous section, then):

```js
document.getElementById("selzee-ask-form").addEventListener("submit", function (e) {
  e.preventDefault(); // prevents form submission / page reload
  const input = document.getElementById("selzee-ask-input");
  askSelzee(input.value);
  input.value = "";
});
```

That's it. After clicking "Ask", the chatbot opens and immediately asks the question the customer typed.

## Notes and edge cases

- **Empty input** — `askSelzee` ignores empty text (the chatbot won't send an empty message anyway), so no additional validation is needed.
- **Chat already open** — handled in the helper function (see above). Without this handling, `toggleAndSend` would close the window of an already-open chat instead.
- **Page without the widget** — if the embed script is not included on the given page, `window.selzee` is never created and the function just logs an error after the timeout; nothing breaks. Make sure the widget is deployed on the "Contact" page.
- **Multiple calls in a row** — if the user sends a question, waits for the answer, then sends another, it works normally as a continuation of the conversation. A new question is not sent while the previous answer is still being generated.

## Summary for developers

1. Make sure the Selzee embed script is deployed on the page.
2. After your form is submitted, call `window.selzee.toggleAndSend({ message: question })`.
3. Handle the asynchronous loading of the widget (the `askSelzee` helper function above).

No changes are needed on the Selzee side.
