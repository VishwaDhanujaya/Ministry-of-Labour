# Orchestration Plan

1. Set up heartbeat cron for liveness tracking.
2. Spawn **E2E Testing Orchestrator** in a parallel subagent. This agent will create tests based on ORIGINAL_REQUEST.md.
3. Spawn sub-orchestrators for M1, M2, and M3.
   - M1: SEO Optimization (`teamwork_preview_explorer` then iteration loop) -> `sub_orch_m1_seo`
   - M2: Backend & Deployment (`sub_orch_m2_backend`)
   - M3: UI Polish (`sub_orch_m3_ui`)
   Wait, since these are independent, I can spawn 4 subagents (Type: self, Role: sub-orchestrator) concurrently.
4. Each sub-orchestrator will manage its own `SCOPE.md` and iteration loop (Explorer -> Worker -> Reviewer).
5. Once `TEST_READY.md` is available and M1-3 are done, run M4 Phase 1 (Test Pass) and Phase 2 (Adversarial Coverage).
6. Report victory.
