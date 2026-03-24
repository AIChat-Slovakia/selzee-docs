---
title: "Agent Configuration"
description: "Configuring chatbot appearance, intelligence settings, and actions including operator handoff, cart integration, and order status."
sidebar_position: 43
---

# Agent Configuration

The **Agent** tab provides options for configuring your chatbot's appearance, response logic, and integrations.

## Appearance

The **Appearance** section controls the visual presentation of your chatbot.

### Agent Name

The display name of your chatbot.

### Agent Personality

A short description shown below the name that further describes your chatbot's character.

### Gender

Controls the grammatical gender used in chatbot responses. When set to male, the chatbot responds using masculine forms; when set to female, it uses feminine forms.

### Welcome Message

This message is displayed to every user who opens the chat window. It typically serves as a brief introduction and welcome. The text supports Markdown formatting.

### Initial Prompts

Short suggested messages displayed before the user asks their first question. These should address the most common inquiries, recommend specific products or categories, or help with product selection. When a user clicks one of these prompts, the text is sent to the chatbot as a message. Keep the text clear and action-oriented.

### Currency

The currency displayed when showing product prices.

### Brand Color

Choose your brand color using one of two methods:

- Color Picker
- Hex color code

The selected color is also used for initial prompt buttons and quick reply suggestions.

### Avatar Image

Upload an avatar image for your chatbot. Supported formats: JPEG, JPG, PNG, GIF.

### Chat Button

When enabled, the chat button text is shown next to the chatbot icon when the chat window is minimized. When disabled, only the chatbot icon is visible.

### Input Placeholder

The placeholder text displayed in the message input field.

### Position

The offset of the chat widget's position on the page, specified in pixels (e.g., 24px).

### Custom CSS

Add custom CSS to style the chat widget (font, text color, etc.).

## Intelligence

The **Intelligence** section defines the response logic and boundaries your chatbot must follow.

### Language

The language selected here is the chatbot's preferred language for communication. If a user communicates in a different language, the chatbot automatically adapts to match.

### System Instructions

Core settings that define how the chatbot responds, how it handles specific situations, what procedures it must follow, and what it must avoid.

If the chatbot includes unwanted information in its responses, you can reshape its response logic by updating the system instructions.

### Tone of Voice

Set guidelines for the tone the chatbot uses when communicating. Consider the level of formality and align the voice with your brand.

**Qualification** — Describe your target audience demographics, customer profile, their pain points, and the solutions they seek. Define what questions the chatbot should ask to qualify users.

### Escalation

Define scenarios where the next step should be escalation to a human support agent, phone contact, or email. The AI evaluates keywords such as "I want to speak to a person" or "I don't want to talk to a robot" and escalates the conversation accordingly.

### Personality

Choose one of three personality styles: **Formal**, **Balanced**, or **Friendly**.

### Product Preferences

Specify brands, products, and product categories to prioritize in product recommendations. When multiple suitable products are available, items listed here take priority.

### Quick Reply Suggestions

Set the logic for generating quick reply buttons shown to the user after each chatbot message. These help maintain a smooth conversation flow and reduce barriers in the sales process. Describe how the chatbot should generate the content of these clickable buttons.

### Products to Recommend

Set the maximum number of products displayed to users when a match is found.

### Proactive Popups

Enable proactive outreach using the toggle switch. When enabled, the chatbot reaches out to users at the right moment based on their on-page activity — welcoming them to the site, helping compare products, assisting with product selection, recovering abandoned carts, and more.

## Actions

The **Actions** section provides options for interacting with third-party services and e-commerce platforms.

### Operator Connection

Keep this setting enabled if the chatbot serves as a direct customer communication channel and you plan to actively participate in conversations. When a handoff is triggered, AI responses are deactivated and your team receives notifications via the dashboard (sound and visual alerts), browser notifications, and email. The AI evaluates the need for escalation based on cues like "I don't want to talk to a robot" or "I want a human."

### Shopping Cart

Add products to the customer's cart directly through the chat. If you use the Selzee plugin for Upgates, Shoptet, or Shopify, this works out of the box. For other platforms, a custom technical integration is required — see the technical documentation for details.

### Order Status

The chatbot can handle "Where is my order?" requests directly in the chat. The customer provides their order number and email for verification, and the chatbot displays the current order status. If you use the Selzee plugin for Upgates, Shoptet, or Shopify, this works without additional setup. For other platforms, you need to provide an API endpoint that retrieves the order status by order number and email — see the technical documentation for details.
