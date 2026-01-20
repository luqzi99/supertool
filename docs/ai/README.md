# 🤖 AI Agent Usage & Tool Extension Guide  
**Supertool Project**

This document explains:
1. How to use AI agents (e.g. Claude Code) correctly
2. How to add new tools safely without breaking system rules

All instructions here are **non-negotiable**.

---

## 📁 Folder Structure Overview

```text
docs/
 └── ai/
      ├── ai-agents.json          # Global AI system rules (DO NOT MODIFY casually)
      ├── README.md               # This guide
      └── tools/
           ├── _tool-template.json
           ├── whatsapp-link.json
           └── <new-tool>.json
```

---

## 🧠 Core Concept (READ FIRST)

- `ai-agents.json` defines **HOW** the AI must think
- `tools/*.json` defines **WHAT** a specific tool must do
- Tools rules are **isolated**
- Global rules are **shared**

**❌ Never mix tool rules into ai-agents.json**

---

## 🚀 How to Use AI Agent (Claude Code)

### 1️⃣ Load System Rules (MANDATORY)

Every session MUST start with:

```
Load and strictly follow system rules defined in:
docs/ai/ai-agents.json

Treat them as non-negotiable system-level constraints.
```

### 2️⃣ Assign Agent Role Explicitly

Always tell the AI which role it is acting as.

**Example: Backend Implementation**
```
You are acting as the backend_builder agent.
Follow all constraints under agents.backend_builder
and global_rules in ai-agents.json.
```

**Example: Tool Design**
```
You are acting as the tool_designer agent.
Follow all constraints under agents.tool_designer
and global_rules in ai-agents.json.
```

**Example: Code Review**
```
You are acting as the reviewer agent.
Reject any solution that violates system or tool rules.
```

### 3️⃣ Using Tool-Specific Rules

When working on a specific tool:

```
You are working on tool: <tool-name>

Follow:
- docs/ai/ai-agents.json
- docs/ai/tools/<tool-name>.json
```

**Example:**
```
You are working on tool: whatsapp-link

Follow:
- docs/ai/ai-agents.json
- docs/ai/tools/whatsapp-link.json
```

---

## 🧩 How to Add a New Tool (STANDARD FLOW)

Follow these steps in order.

### 1️⃣ Create Tool Code Folder

```
app/Tools/<ToolName>/
```

**Example:**
```
app/Tools/PdfExtractor/
```

### 2️⃣ Create Tool Rule File

Copy the template:
```
docs/ai/tools/_tool-template.json
→ docs/ai/tools/pdf-extractor.json
```

Fill in at least:
- `tool`
- `objective`
- `inputs`
- `outputs.success`

### 3️⃣ Load Rules When Using AI

```
You are acting as backend_builder and tool_designer.

Follow:
- docs/ai/ai-agents.json
- docs/ai/tools/pdf-extractor.json
```

### 4️⃣ Enforce Review Before Merge

Before accepting output, run reviewer agent:

```
You are acting as the reviewer agent.

Review the solution against:
- docs/ai/ai-agents.json
- docs/ai/tools/pdf-extractor.json

Reject anything that violates rules.
```

---

## 🛑 Common Mistakes (AVOID)

- ❌ Adding tool rules into `ai-agents.json`
- ❌ Letting AI decide architecture freely
- ❌ Skipping reviewer role
- ❌ Letting controllers contain logic
- ❌ Introducing database or state

---

## 🧭 Rule of Thumb

> If a tool cannot be clearly described in a single `tools/<tool>.json` file, the tool is **too big**.
>
> **Split it.**

---

## 🔒 Governance Rules

**`ai-agents.json` is the AI constitution**

Changes require:
- Clear justification
- Version bump

**Tool rules are free to evolve independently**

---

## ✅ Summary

1. Always load global rules
2. Always assign agent role
3. Always isolate tool rules
4. Always review before accepting

This ensures **consistency**, **scalability**, and **safety** for both humans and AI.