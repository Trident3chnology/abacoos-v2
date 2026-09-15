# Graph Report - .  (2026-08-13)

## Corpus Check
- cluster-only mode — file stats not available

## Summary
- 14 nodes · 9 edges · 7 communities (2 shown, 5 thin omitted)
- Extraction: 78% EXTRACTED · 22% INFERRED · 0% AMBIGUOUS · INFERRED: 2 edges (avg confidence: 0.9)
- Token cost: 166 input · 24 output

## Graph Freshness
- Built from commit: `79e0fb3b`
- Run `git rev-parse HEAD` and compare to check if the graph is stale.
- Run `graphify update .` after code changes (no API cost).

## Community Hubs (Navigation)
- Account and Transaction APIs
- Core Infrastructure and Authentication
- Application Entry Point
- Activity Log Processor
- Category API Controller
- Sub-Account API Controller
- User & Invitation API Controller

## God Nodes (most connected - your core abstractions)
1. `Core Business Logic` - 4 edges
2. `Account API Controller` - 2 edges
3. `Transaction API Controller` - 2 edges
4. `Action-Based Routing Pattern` - 2 edges
5. `Multi-Tenant Data Isolation` - 2 edges
6. `Application Entry Point` - 2 edges
7. `Database Connection & Infrastructure` - 1 edges
8. `Login Handler` - 1 edges
9. `Registration Handler` - 1 edges
10. `Main View Wrapper` - 1 edges

## Surprising Connections (you probably didn't know these)
- `Account API Controller` --implements--> `Multi-Tenant Data Isolation`  [INFERRED]
  account/process.php → API & Data Connections.md
- `Transaction API Controller` --implements--> `Multi-Tenant Data Isolation`  [INFERRED]
  transaction/process.php → API & Data Connections.md
- `Account API Controller` --implements--> `Action-Based Routing Pattern`  [EXTRACTED]
  account/process.php → API & Data Connections.md
- `Transaction API Controller` --implements--> `Action-Based Routing Pattern`  [EXTRACTED]
  transaction/process.php → API & Data Connections.md
- `Application Entry Point` --calls--> `Core Business Logic`  [EXTRACTED]
  index.php → include/functions.php

## Import Cycles
- None detected.

## Hyperedges (group relationships)
- **Authentication & Onboarding Flow** — login, sign_up, include_functions, global_library_database [EXTRACTED 0.95]
- **API Controller Layer** — account_process, transaction_process, sub_account_process, category_process, user_process, activity_log_process [EXTRACTED 1.00]

## Communities (7 total, 5 thin omitted)

### Community 0 - "Account and Transaction APIs"
Cohesion: 0.67
Nodes (4): Account API Controller, Action-Based Routing Pattern, Multi-Tenant Data Isolation, Transaction API Controller

### Community 1 - "Core Infrastructure and Authentication"
Cohesion: 0.50
Nodes (4): Database Connection & Infrastructure, Core Business Logic, Login Handler, Registration Handler

## Knowledge Gaps
- **8 isolated node(s):** `Database Connection & Infrastructure`, `Login Handler`, `Registration Handler`, `Main View Wrapper`, `Activity Log Processor` (+3 more)
  These have ≤1 connection - possible missing edges or undocumented components.
- **5 thin communities (<3 nodes) omitted from report** — run `graphify query` to explore isolated nodes.

## Suggested Questions
_Questions this graph is uniquely positioned to answer:_

- **Why does `Core Business Logic` connect `Core Infrastructure and Authentication` to `Application Entry Point`?**
  _High betweenness centrality (0.115) - this node is a cross-community bridge._
- **Why does `Application Entry Point` connect `Application Entry Point` to `Core Infrastructure and Authentication`?**
  _High betweenness centrality (0.051) - this node is a cross-community bridge._
- **Are the 2 inferred relationships involving `Multi-Tenant Data Isolation` (e.g. with `Account API Controller` and `Transaction API Controller`) actually correct?**
  _`Multi-Tenant Data Isolation` has 2 INFERRED edges - model-reasoned connections that need verification._
- **What connects `Database Connection & Infrastructure`, `Login Handler`, `Registration Handler` to the rest of the system?**
  _8 weakly-connected nodes found - possible documentation gaps or missing edges._