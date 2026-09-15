# Agent Skill Workflow & Design Governance — ABACOOS v2

---

## 1. Overview & Workflow Execution Order

To create cohesive, high-quality, human-designed UI/UX experiences, all design and frontend modifications must follow a **strict 3-tier skill execution hierarchy**.

When executing UI/UX work, skills MUST be used in this precise order:

```mermaid
graph TD
    Step1["1. ui-ux-pro-max"] -->|Design Tokens & UX Rules| Step2["2. superdesign"]
    Step2 -->|Visual Composition & Layout Refinement| Step3["3. animate"]
    Step3 -->|Motion, Easing & Micro-Interactions| Final["Cohesive, Polished & Intentional UI"]
```

1. **`ui-ux-pro-max`** — Establish the design system, color palette, typography, and UX direction.
2. **`superdesign`** — Refine the visual composition, hierarchy, and distinctive UI character.
3. **`animate`** — Add purposeful motion, timing, easing, and interactive feedback.

---

## 2. Skill Responsibilities & Governance Matrix

Each skill has a dedicated, non-overlapping responsibility. Skills **must never override or cross into another skill's domain**.

| Skill | Primary Responsibilities | Domain Boundaries & Constraints |
| :--- | :--- | :--- |
| **`ui-ux-pro-max`** <br>*(Source of Truth)* | • Typography & Font scale<br>• Color tokens & palettes<br>• Spacing scale & layout grid<br>• UX patterns & accessibility<br>• Component visual language | **Does NOT handling motion or layout placement.** Serves as the single source of truth for design system tokens. |
| **`superdesign`** <br>*(Visual Refinement)* | • Visual composition<br>• Page & component layout hierarchy<br>• Distinctive visual character<br>• Aesthetic refinement & canvas drafts | **Must adhere to `ui-ux-pro-max` design tokens.** Does NOT invent arbitrary colors or fonts outside the established system. |
| **`animate`** <br>*(Motion Engineering)* | • Purposeful motion & micro-interactions<br>• Easing curves & duration timing<br>• Entrance & exit behaviors<br>• Interactive hover/active feedback | **Focuses purely on motion.** Does NOT alter colors, static layouts, or core component styling established by prior tiers. |

---

## 3. Pre-Implementation Workflow Protocol

Before modifying any source code in the repository for UI/UX tasks, the agent MUST:

1. **Codebase Analysis**: Inspect existing component source code, CSS tokens, and render branches.
2. **Proposed Approach Explanation**: Present a concise proposal outlining:
   - Tokens derived from `ui-ux-pro-max`.
   - Layout & visual hierarchy structured via `superdesign`.
   - Motion & easing curves engineered via `animate`.
3. **User Alignment**: Wait for approval or feedback on the proposed approach before modifying files.

---

## 4. Design Goal

The combined outcome of this 3-tier workflow ensures the UI feels **cohesive, polished, intentional, and human-crafted** rather than generic or AI-generated.
